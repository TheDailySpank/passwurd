<?php

namespace App\Jobs;

use App\MyHash;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddPasswordToDB implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var mixed
     */
    protected $password;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MyHash $my_hash)
    {
        $this->my_hash  = $my_hash;
        $this->password = $my_hash->password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(MyHash $my_hash)
    {
        // dd($my_hash);
        $password       = $this->password;
        $hash           = new MyHash;
        $hash->password = substr($password, 0, 16);
        // $hash->sha1     = strtoupper(Hash('sha1', $hash->password));
        // $hash->sha256   = strtoupper(Hash('sha256', $hash->password));
        // $hash->md5      = strtoupper(Hash('md5', $hash->password));

        try {
            $hash->save();
        } catch (Exception $e) {

        }
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array
     */
    public function tags()
    {
        return ['addtodb'];
    }
}
