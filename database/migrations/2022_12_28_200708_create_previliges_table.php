<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreviligesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('previliges', function (Blueprint $table) {
            $table->id();
            $table->string('job')->nullable();
            $table->string('page')->nullable();
            $table->string('v')->nullable();
            $table->string('a')->nullable();
            $table->string('e')->nullable();
            $table->string('d')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('previliges');
    }
}
