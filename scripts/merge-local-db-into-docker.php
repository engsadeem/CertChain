#!/usr/bin/env php
<?php

declare(strict_types=1);

function fail(string $message, int $code = 1): never
{
    fwrite(STDERR, "ERROR: {$message}\n");
    exit($code);
}

function loadEnvFile(string $path): array
{
    if (! is_file($path)) {
        fail(".env was not found at {$path}");
    }

    $values = [];
    foreach (file($path, FILE_IGNORE_NEW_LINES) ?: [] as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || ! str_contains($line, '=')) {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        if ((str_starts_with($value, '"') && str_ends_with($value, '"')) ||
            (str_starts_with($value, "'") && str_ends_with($value, "'"))) {
            $value = substr($value, 1, -1);
        }
        $values[$key] = $value;
    }

    return $values;
}

function cliOptions(): array
{
    return getopt('', [
        'source-host::', 'source-port::', 'source-db::', 'source-user::', 'source-password::',
        'dest-host::', 'dest-port::', 'dest-db::', 'dest-user::', 'dest-password::',
    ]);
}

function pdo(string $host, int $port, string $db, string $user, string $password): PDO
{
    $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
    return new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}

function tableExists(PDO $db, string $table): bool
{
    $stmt = $db->prepare(
        'SELECT EXISTS (
            SELECT 1
            FROM information_schema.tables
            WHERE table_schema = DATABASE()
              AND table_name = ?
        )'
    );
    $stmt->execute([$table]);

    return (bool) $stmt->fetchColumn();
}

function columns(PDO $db, string $table): array
{
    if (! tableExists($db, $table)) {
        return [];
    }
    return array_map(static fn (array $row): string => $row['Field'], $db->query("SHOW COLUMNS FROM `{$table}`")->fetchAll());
}

function rows(PDO $db, string $table): array
{
    if (! tableExists($db, $table)) {
        return [];
    }
    return $db->query("SELECT * FROM `{$table}` ORDER BY `id`")->fetchAll();
}

function findOne(PDO $db, string $table, string $column, mixed $value): ?array
{
    $stmt = $db->prepare("SELECT * FROM `{$table}` WHERE `{$column}` = ? LIMIT 1");
    $stmt->execute([$value]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function insertMapped(PDO $db, string $table, array $row, array $destinationColumns, array $overrides = []): int
{
    $data = array_replace($row, $overrides);
    unset($data['id']);
    $data = array_intersect_key($data, array_flip($destinationColumns));

    if ($data === []) {
        fail("No compatible columns found while inserting into {$table}.");
    }

    $names = array_keys($data);
    $quoted = implode(', ', array_map(static fn (string $name): string => "`{$name}`", $names));
    $marks = implode(', ', array_fill(0, count($names), '?'));
    $stmt = $db->prepare("INSERT INTO `{$table}` ({$quoted}) VALUES ({$marks})");
    $stmt->execute(array_values($data));
    return (int) $db->lastInsertId();
}

function updateMapped(PDO $db, string $table, int $id, array $row, array $destinationColumns, array $protected = []): void
{
    $data = array_intersect_key($row, array_flip($destinationColumns));
    unset($data['id']);
    foreach ($protected as $column) {
        unset($data[$column]);
    }
    if ($data === []) {
        return;
    }

    $parts = [];
    foreach (array_keys($data) as $name) {
        $parts[] = "`{$name}` = ?";
    }
    $values = array_values($data);
    $values[] = $id;
    $stmt = $db->prepare("UPDATE `{$table}` SET ".implode(', ', $parts).' WHERE `id` = ?');
    $stmt->execute($values);
}

function backup(PDO $db, array $tables, string $path): void
{
    $payload = [];
    foreach ($tables as $table) {
        if (tableExists($db, $table)) {
            $payload[$table] = rows($db, $table);
        }
    }
    if (! is_dir(dirname($path)) && ! mkdir(dirname($path), 0770, true) && ! is_dir(dirname($path))) {
        fail('Could not create backup directory: '.dirname($path));
    }
    file_put_contents($path, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR));
}

$root = dirname(__DIR__);
$env = loadEnvFile($root.'/.env');
$opt = cliOptions();

$dbName = (string) ($env['DB_DATABASE'] ?? 'certchain');
$dbUser = (string) ($env['DB_USERNAME'] ?? 'certchain_user');
$dbPassword = (string) ($env['DB_PASSWORD'] ?? '');

$source = [
    'host' => (string) ($opt['source-host'] ?? '127.0.0.1'),
    'port' => (int) ($opt['source-port'] ?? 3306),
    'db' => (string) ($opt['source-db'] ?? $dbName),
    'user' => (string) ($opt['source-user'] ?? $dbUser),
    'password' => (string) ($opt['source-password'] ?? $dbPassword),
];
$dest = [
    'host' => (string) ($opt['dest-host'] ?? '127.0.0.1'),
    'port' => (int) ($opt['dest-port'] ?? ($env['DOCKER_DB_PORT'] ?? 3307)),
    'db' => (string) ($opt['dest-db'] ?? $dbName),
    'user' => (string) ($opt['dest-user'] ?? $dbUser),
    'password' => (string) ($opt['dest-password'] ?? $dbPassword),
];

if ($source === $dest) {
    fail('Source and destination databases are identical; refusing to merge.');
}

printf("Source      %s:%d/%s\n", $source['host'], $source['port'], $source['db']);
printf("Destination %s:%d/%s\n", $dest['host'], $dest['port'], $dest['db']);

try {
    $src = pdo($source['host'], $source['port'], $source['db'], $source['user'], $source['password']);
    $dst = pdo($dest['host'], $dest['port'], $dest['db'], $dest['user'], $dest['password']);
} catch (Throwable $e) {
    fail('Database connection failed: '.$e->getMessage());
}

$tables = ['users', 'universities', 'students', 'certificates', 'blockchain_records', 'verification_logs'];
$stamp = date('Ymd-His');
$backupDir = $root.'/storage/app/backups/shared-data-'.$stamp;
backup($src, $tables, $backupDir.'/source-host.json');
backup($dst, $tables, $backupDir.'/destination-docker.json');
printf("Backups written to %s\n", $backupDir);

$stats = array_fill_keys($tables, ['inserted' => 0, 'existing' => 0]);
$uniMap = [];
$studentMap = [];
$certificateMap = [];

try {
    $dst->beginTransaction();

    // Users: preserve an existing destination account/password; only add missing emails.
    if (tableExists($src, 'users') && tableExists($dst, 'users')) {
        $dstCols = columns($dst, 'users');
        foreach (rows($src, 'users') as $row) {
            $existing = findOne($dst, 'users', 'email', $row['email']);
            if ($existing) {
                $stats['users']['existing']++;
                continue;
            }
            insertMapped($dst, 'users', $row, $dstCols);
            $stats['users']['inserted']++;
        }
    }

    if (! tableExists($src, 'universities') || ! tableExists($dst, 'universities')) {
        fail('universities table is required in both databases.');
    }
    $dstUniCols = columns($dst, 'universities');
    foreach (rows($src, 'universities') as $row) {
        $existing = findOne($dst, 'universities', 'name', $row['name']);
        if ($existing) {
            $uniMap[(int) $row['id']] = (int) $existing['id'];
            $stats['universities']['existing']++;
            continue;
        }
        $newId = insertMapped($dst, 'universities', $row, $dstUniCols);
        $uniMap[(int) $row['id']] = $newId;
        $stats['universities']['inserted']++;
    }

    if (! tableExists($src, 'students') || ! tableExists($dst, 'students')) {
        fail('students table is required in both databases.');
    }
    $dstStudentCols = columns($dst, 'students');
    foreach (rows($src, 'students') as $row) {
        $mappedUniversity = $uniMap[(int) $row['university_id']] ?? null;
        if (! $mappedUniversity) {
            fail('Could not map university for source student '.$row['student_number']);
        }

        $existing = findOne($dst, 'students', 'student_number', $row['student_number']);
        if ($existing) {
            if ((string) $existing['national_id'] !== (string) $row['national_id']) {
                fail("Student conflict: {$row['student_number']} has a different national_id in the destination database.");
            }
            $studentMap[(int) $row['id']] = (int) $existing['id'];
            $stats['students']['existing']++;
            continue;
        }

        $nationalConflict = findOne($dst, 'students', 'national_id', $row['national_id']);
        if ($nationalConflict) {
            fail("Student conflict: national_id {$row['national_id']} already belongs to another student_number in destination.");
        }

        $newId = insertMapped($dst, 'students', $row, $dstStudentCols, ['university_id' => $mappedUniversity]);
        $studentMap[(int) $row['id']] = $newId;
        $stats['students']['inserted']++;
    }

    if (! tableExists($src, 'certificates') || ! tableExists($dst, 'certificates')) {
        fail('certificates table is required in both databases.');
    }
    $dstCertCols = columns($dst, 'certificates');
    foreach (rows($src, 'certificates') as $row) {
        $mappedStudent = $studentMap[(int) $row['student_id']] ?? null;
        $mappedIssuer = $uniMap[(int) $row['issued_by']] ?? null;
        if (! $mappedStudent || ! $mappedIssuer) {
            fail('Could not map relations for certificate '.$row['certificate_id']);
        }

        $existing = findOne($dst, 'certificates', 'certificate_id', $row['certificate_id']);
        if ($existing) {
            if ((string) $existing['tx_hash'] !== (string) $row['tx_hash'] ||
                strtolower((string) $existing['keccak256_hash']) !== strtolower((string) $row['keccak256_hash'])) {
                fail("Certificate conflict: {$row['certificate_id']} exists with different blockchain proof.");
            }
            $certificateMap[(int) $row['id']] = (int) $existing['id'];
            $stats['certificates']['existing']++;
            continue;
        }

        if (findOne($dst, 'certificates', 'tx_hash', $row['tx_hash'])) {
            fail("Certificate conflict: tx_hash {$row['tx_hash']} already exists under another certificate.");
        }
        if (findOne($dst, 'certificates', 'keccak256_hash', $row['keccak256_hash'])) {
            fail("Certificate conflict: keccak256_hash for {$row['certificate_id']} already exists under another certificate.");
        }

        $newId = insertMapped($dst, 'certificates', $row, $dstCertCols, [
            'student_id' => $mappedStudent,
            'issued_by' => $mappedIssuer,
        ]);
        $certificateMap[(int) $row['id']] = $newId;
        $stats['certificates']['inserted']++;
    }

    if (tableExists($src, 'blockchain_records') && tableExists($dst, 'blockchain_records')) {
        $dstCols = columns($dst, 'blockchain_records');
        foreach (rows($src, 'blockchain_records') as $row) {
            $mappedCertificate = $certificateMap[(int) $row['certificate_id']] ?? null;
            if (! $mappedCertificate) {
                continue;
            }
            $existing = findOne($dst, 'blockchain_records', 'tx_hash', $row['tx_hash']);
            if ($existing) {
                $stats['blockchain_records']['existing']++;
                continue;
            }
            insertMapped($dst, 'blockchain_records', $row, $dstCols, ['certificate_id' => $mappedCertificate]);
            $stats['blockchain_records']['inserted']++;
        }
    }

    if (tableExists($src, 'verification_logs') && tableExists($dst, 'verification_logs')) {
        $dstCols = columns($dst, 'verification_logs');
        foreach (rows($src, 'verification_logs') as $row) {
            $mappedCertificate = $certificateMap[(int) $row['certificate_id']] ?? null;
            if (! $mappedCertificate) {
                continue;
            }
            $stmt = $dst->prepare('SELECT id FROM verification_logs WHERE certificate_id = ? AND verifier_email = ? AND ip_address = ? AND ((verified_at IS NULL AND ? IS NULL) OR verified_at = ?) LIMIT 1');
            $stmt->execute([$mappedCertificate, $row['verifier_email'], $row['ip_address'], $row['verified_at'], $row['verified_at']]);
            if ($stmt->fetchColumn()) {
                $stats['verification_logs']['existing']++;
                continue;
            }
            insertMapped($dst, 'verification_logs', $row, $dstCols, ['certificate_id' => $mappedCertificate]);
            $stats['verification_logs']['inserted']++;
        }
    }

    $dst->commit();
} catch (Throwable $e) {
    if ($dst->inTransaction()) {
        $dst->rollBack();
    }
    fail('Merge aborted with no partial database changes: '.$e->getMessage());
}

echo "\nMerge completed successfully.\n";
foreach ($stats as $table => $count) {
    printf("%-20s inserted=%d existing=%d\n", $table, $count['inserted'], $count['existing']);
}
echo "\nNext: set DB_PORT=3307 in .env so native PHP and Docker use the same canonical MySQL database.\n";
