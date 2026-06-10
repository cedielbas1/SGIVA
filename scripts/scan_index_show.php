<?php
$base = __DIR__ . '/../resources/views';
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base));
$patterns = ["/route\('\w+\\.create'/", "/route\('\w+\\.edit'/", "/route\('\w+\\.destroy'/"];
$issues = [];
foreach ($it as $file) {
    if ($file->isDir()) continue;
    $name = $file->getFilename();
    if (!in_array($name, ['index.blade.php','show.blade.php'])) continue;
    $text = file_get_contents($file->getPathname());
    $lines = preg_split('/\r?\n/', $text);
    foreach ($lines as $i => $line) {
        foreach ($patterns as $pat) {
            if (preg_match($pat, $line)) {
                $start = max(0, $i - 6);
                $window = implode("\n", array_slice($lines, $start, $i - $start + 1));
                if (strpos($window, '@can') === false && strpos($window, '@auth') === false && strpos($window, '@guest') === false) {
                    $issues[] = [$file->getPathname(), $i + 1, trim($line)];
                }
            }
        }
    }
}
foreach ($issues as $iss) {
    echo "$iss[0]:$iss[1]: $iss[2]\n";
}
echo "----\nFound " . count($issues) . " potential issues\n";
