<?php

namespace App\Services;

use RuntimeException;
use Symfony\Component\Process\Process;

class BlockchainService
{
    public function isConfigured(): bool
    {
        return filled(config('blockchain.rpc_endpoint'))
            && filled(config('blockchain.contract_address'))
            && filled(config('blockchain.private_key'));
    }

    public function keccak256Payload(array $payload): string
    {
        $canonicalJson = json_encode(
            $payload,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR
        );

        $result = $this->runNodeScript('hashPayload.js', [base64_encode($canonicalJson)], 60);

        if (! ($result['success'] ?? false) || empty($result['hash'])) {
            throw new RuntimeException($result['error'] ?? 'Failed to generate Keccak-256 payload hash.');
        }

        return $result['hash'];
    }

    public function registerCertificate(string $certificateId, string $certificateHash): array
    {
        $this->ensureConfigured();

        $result = $this->runNodeScript('registerCertificate.js', [$certificateId, $certificateHash], 300);

        if (! ($result['success'] ?? false)) {
            throw new RuntimeException($result['error'] ?? 'Blockchain certificate registration failed.');
        }

        return $result;
    }

    public function verifyCertificate(string $certificateId, string $certificateHash): array
    {
        $this->ensureConfigured();

        $result = $this->runNodeScript('verifyCertificate.js', [$certificateId, $certificateHash], 120);

        if (! ($result['success'] ?? false)) {
            throw new RuntimeException($result['error'] ?? 'Blockchain certificate verification failed.');
        }

        return $result;
    }

    public function etherscanTxUrl(?string $txHash): ?string
    {
        if (! $txHash || str_starts_with($txHash, 'local-')) {
            return null;
        }

        return rtrim((string) config('blockchain.etherscan_base_url'), '/') . '/tx/' . $txHash;
    }

    public function etherscanAddressUrl(?string $address): ?string
    {
        if (! $address || $address === 'local-dev') {
            return null;
        }

        return rtrim((string) config('blockchain.etherscan_base_url'), '/') . '/address/' . $address;
    }

    private function ensureConfigured(): void
    {
        if (! $this->isConfigured()) {
            throw new RuntimeException('Blockchain is not configured. Set ETH_RPC_URL, ETH_CONTRACT_ADDRESS, and ETH_PRIVATE_KEY in .env.');
        }
    }

    private function runNodeScript(string $script, array $arguments = [], int $timeout = 120): array
    {
        $scriptPath = base_path('blockchain/scripts/' . $script);

        if (! file_exists($scriptPath)) {
            throw new RuntimeException('Blockchain script not found: ' . $scriptPath);
        }

        $nodeBinary = config('blockchain.node_binary', 'node') ?: 'node';
        $process = new Process(array_merge([$nodeBinary, $scriptPath], $arguments), base_path(), $this->nodeEnvironment());
        $process->setTimeout($timeout);
        $process->run();

        $stdout = trim($process->getOutput());
        $stderr = trim($process->getErrorOutput());
        $decoded = $stdout !== '' ? json_decode($stdout, true) : null;

        if (! $process->isSuccessful()) {
            $message = is_array($decoded) && isset($decoded['error'])
                ? $decoded['error']
                : ($stderr ?: $stdout ?: 'Node blockchain script failed.');

            throw new RuntimeException($message);
        }

        if (! is_array($decoded)) {
            throw new RuntimeException('Invalid JSON returned by blockchain script: ' . ($stdout ?: $stderr));
        }

        return $decoded;
    }

    private function nodeEnvironment(): array
    {
        return [
            'ETHERSCAN_BASE_URL' => (string) config('blockchain.etherscan_base_url'),
            'ETH_NETWORK' => (string) config('blockchain.network'),
            'ETH_NETWORK_NAME' => (string) config('blockchain.network_name'),
            'ETH_CHAIN_ID' => (string) config('blockchain.chain_id'),
            'ETH_RPC_URL' => (string) config('blockchain.rpc_endpoint'),
            'ETH_CONTRACT_ADDRESS' => (string) config('blockchain.contract_address'),
            'ETH_PRIVATE_KEY' => (string) config('blockchain.private_key'),
            'ETH_CONFIRMATIONS' => (string) config('blockchain.confirmations', 1),
            'ETH_CERTIFICATE_ID_TYPE' => (string) config('blockchain.certificate_id_type', 'auto'),
            'ETH_REGISTER_FUNCTION' => (string) config('blockchain.register_function', 'registerCertificate'),
        ];
    }
}
