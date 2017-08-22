<?php
use DB;

// $db_connection = "sqlite";
$db_connection = "mysql";

$file   = '/Volumes/Mirror/password/hashcat.txt';
$handle = fopen($file, "r");
if ($handle) {
    $i              = 0;
    $password_array = array();
    while (($line = fgets($handle)) !== false) {

        $line       = trim($line);
        $line_array = explode(":", $line);

        $password = $line_array[1];
        $password = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $password);
        $password = substr($password, 0, 16);

        $sha1 = strtoupper(Hash('sha1', $password));
        // $sha256 = strtoupper(Hash('sha256', $password));
        // $md5    = strtoupper(Hash('md5', $password));

        $password_array[] = array(
            // 'created_at' => Carbon::now(),
            // 'updated_at' => Carbon::now(),
            'sha1'     => $sha1,
            // 'sha256'   => $sha256,
            // 'md5'      => $md5,
            'password' => $password,
        );
        $i = $i + 1;
        if ($i > 1000) {
            DB::connection($db_connection)->table('my_hashes')->insert($password_array);
            echo " [+] Added: " . $password . PHP_EOL;
            $i              = 0;
            $password_array = array();
        }
    }

    fclose($handle);

} else {
    // error opening the file.
}
