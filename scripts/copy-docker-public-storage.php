#!/usr/bin/env php
<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$target = $root.'/storage/app/public';
@mkdir($target.'/certificates', 0775, true);
@mkdir($target.'/qrcodes', 0775, true);

echo "This helper only documents the target shared directory:\n{$target}\n";
echo "Use the Docker command from SHARED_DATA.md to copy the previous named-volume files safely.\n";
