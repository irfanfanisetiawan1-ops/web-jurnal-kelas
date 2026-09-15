<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$dbHost = env('DB_HOST', '127.0.0.1');
$dbPort = env('DB_PORT', '3306');
$dbName = env('DB_DATABASE', 'jurnal_kelas');
$dbUser = env('DB_USERNAME', 'root');
$dbPass = env('DB_PASSWORD', '');

echo "Dumping database {$dbName}...\n";

$mysqldump = 'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe';
if (!file_exists($mysqldump)) {
    $dirs = glob('C:\\laragon\\bin\\mysql\\*\\bin\\mysqldump.exe');
    if (!empty($dirs)) {
        $mysqldump = $dirs[0];
    } else {
        $mysqldump = 'mysqldump';
    }
}

echo "Using mysqldump at: $mysqldump\n";

$targetSql1 = 'c:/laragon/www/web-jurnal-kelas/jurnal_kelas (20).sql';
$targetSql2 = 'c:/laragon/www/web-jurnal-kelas/jurnal_kelas_updated.sql';

$passArg = empty($dbPass) ? '' : "-p\"{$dbPass}\"";
$cmd = "\"{$mysqldump}\" -h {$dbHost} -P {$dbPort} -u {$dbUser} {$passArg} {$dbName} > \"{$targetSql1}\"";

echo "Running dump...\n";
exec($cmd, $output, $returnVar);

if ($returnVar === 0 && file_exists($targetSql1)) {
    copy($targetSql1, $targetSql2);
    echo "Database successfully dumped to:\n- {$targetSql1} (" . round(filesize($targetSql1) / 1024) . " KB)\n- {$targetSql2} (" . round(filesize($targetSql2) / 1024) . " KB)\n";
} else {
    echo "Direct dump failed with code {$returnVar}. Output: " . implode("\n", $output) . "\n";
}
