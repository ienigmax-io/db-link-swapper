<?php

/**
 * Usage: php script.php <source> <dest> <oldDomain> <newDomain>
 * <source> - The source file to read from.
 * <dest> - The destination file to write to.
 * <oldDomain> - The domain to replace.
 * <newDomain> - The domain to replace with.
 * author: @iEnigmaX
 * version: 1.0
 */

if ($argc < 4) {
    die("Usage: php script.php <source> <dest> <oldDomain> <newDomain>\n");
}

$resourcePath = __DIR__ . '/resources';
$exportPath = __DIR__ . '/exports';

$source = $resourcePath . '/' . $argv[1];
$dest = $exportPath . '/' . $argv[2];
$oldDomain = $argv[3];
$newDomain = $argv[4];

echo json_encode([
        'source' => $source,
        'dest' => $dest,
        'oldDomain' => $oldDomain,
        'newDomain' => $newDomain
    ], JSON_PRETTY_PRINT) . "\n";

if (!file_exists($source)) {
    die("Source file does not exist.\n");
}

$readStream = fopen($source, 'r');
$writeStream = fopen($dest, 'w');

if (!$readStream || !$writeStream) {
    die("Failed to open source or destination file.\n");
}

while (($line = fgets($readStream)) !== false) {
    $newLine = str_replace($oldDomain, $newDomain, $line);
    fwrite($writeStream, $newLine);
}

fclose($readStream);
fclose($writeStream);

echo "Domain replacement completed.\n";