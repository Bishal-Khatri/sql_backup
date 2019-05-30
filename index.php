<?php
require ('vendor/autoload.php');
use Ifsnop\Mysqldump as IMysqldump;

$host = 'localhost:3311';
$user = 'root';
$password = '';
$database = 'backup_ebps';
$now = date('Y-d-m-H-i-s');
$folder = '/ebps_backup/';
$file_name = $folder.$now.'-db_ebps.sql';
try {
    $dump = new IMysqldump\Mysqldump('mysql:host='.$host.';dbname='.$database, $user, $password);
    $dump->start($file_name);
    echo "--- Database backup successfull ---";
    echo "<br>";
    echo "--- Filename: $now-db_ebps.sql ---";
} catch (\Exception $e) {
    echo 'mysqldump-php error: ' . $e->getMessage();
}