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
            $sha1 = trim($line);
            $sha1 = strtoupper($sha1);

            $hash_array[] = array(
                // 'created_at' => Carbon::now(),
                // 'updated_at' => Carbon::now(),
                'sha1' => $sha1,
            );
            $i = $i + 1;
            if ($i > 1000) {
                DB::connection($db_connection)->table('my_hashes')->insert($hash_array);
                echo " [+] Added: " . $sha1 . PHP_EOL;
                $i          = 0;
                $hash_array = array();
            }
        }
        // last group of 1,000
        DB::connection($db_connection)->table('my_hashes')->insert($hash_array);
        echo " [+] Added: " . $sha1 . PHP_EOL;
        fclose($handle);

        $new_file = pathinfo($file);
        rename($file, "/Volumes/Mirror/password/done/" . basename($file));

    } else {
        // error opening the file.
    }
}

MyHash::whereIn()
