<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHashesTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        for ($i = 0; $i <= 255; $i++) {
            Schema::dropIfExists(str_pad(dechex($i), 2, "0", STR_PAD_LEFT);
            }
        }

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
    {
            for ($i = 0; $i <= 255; $i++) {
                Schema::create(str_pad(dechex($i), 2, "0", STR_PAD_LEFT), function (Blueprint $table) {
                    $table->increments('id');
                    $table->char('sha1', 40)->nullable()->index();
                    $table->char('password', 16)->nullable()->index();
                });
            }
        }
    }
