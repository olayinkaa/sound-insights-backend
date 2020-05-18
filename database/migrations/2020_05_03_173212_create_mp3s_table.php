<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMp3sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp3s', function (Blueprint $table) {
            $table->id();
            $table->string('song_title')->nullable();
            $table->string('song_name')->nullable();
            $table->string('artist_name')->nullable();
            $table->string('song_thumbnail')->nullable();
            $table->string('song_genre')->nullable();
            $table->string('song_size')->nullable();
            $table->string('song_extension')->nullable();
            $table->enum('downloadable',['0','1']);
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
        Schema::dropIfExists('mp3s');
    }
}
