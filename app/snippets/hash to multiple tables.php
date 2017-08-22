<?php

use DB;

// $db_connection = "sqlite";
$db_connection = "mysql";

// DB::connection($db_connection)->table('my_hashes')->truncate();

$directory = "/Volumes/Mirror/password/hashes";
$files     = File::allFiles($directory);

foreach ($files as $file) {
    echo $file . PHP_EOL;
    $handle = fopen($file, "r");
    if ($handle) {
        $i = 0;
        while (($line = fgets($handle)) !== false) {
            $i++;
            $sha1  = trim($line);
            $sha1  = strtoupper($sha1);
            $table = substr($sha1, 0, 2);

            DB::connection($db_connection)->table($table)->insert(['sha1' => $sha1]);

            if ($i >= 1000) {
                echo " [+] Added: " . $sha1 . PHP_EOL;
                $i = 0;
            }
        }
        fclose($handle);

        $new_file = pathinfo($file);
        rename($file, "/Volumes/Mirror/password/done/" . basename($file));
    }
}
