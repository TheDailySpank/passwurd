<?php

// queue AddPasswordToDB.php

use App\Jobs\AddPasswordToDB;
use App\MyHash;

$file   = '/Volumes/Mirror/password/passwords_sorted_unique.txt';
$handle = fopen($file, "r");
if ($handle) {
    $i = 0;
    while (($line = fgets($handle)) !== false) {
        $password = trim($line);

        $my_hash = new MyHash(['password' => $password]);

        $job = (new AddPasswordToDB($my_hash))->onQueue('passwords');
        dispatch($job);

        $i = $i + 1;
        if ($i > 1000) {
            echo " [+] Dispatched: " . $password . PHP_EOL;
            $i = 0;
        }
    }
}
