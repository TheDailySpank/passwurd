<?php

use App\MyHash;

$file   = '/Volumes/Mirror/password/hashcat.txt';
$handle = fopen($file, "r");
if ($handle) {
    $i = 0;
    while (($line = fgets($handle)) !== false) {

        $password   = trim($line);
        $line_array = explode(":", $line);
        $password   = $line_array[1];
        $password   = substr($password, 0, 16);
        $password   = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $password);
        $sha1       = strtoupper(Hash('sha1', $password));

        // try {
        $hash = MyHash::updateOrCreate(
            ['sha1' => $sha1],
            ['password' => $password]
        );

        // $flight = App\Flight::updateOrCreate(
        //     ['departure' => 'Oakland', 'destination' => 'San Diego'],
        //     ['price' => 99]
        // );

        // } catch (Exception $e) {
        //     $i = $i + 1;
        //     if ($i > 1000) {
        //         echo " [x] Not Saved:" . $password . PHP_EOL;
        //         $i = 0;
        //     }
        // }

        $i = $i + 1;
        if ($i > 1000) {
            echo " [+] Added: " . $password . PHP_EOL;
            $i = 0;
        }

    }

    fclose($handle);
} else {
    // error opening the file.
}
