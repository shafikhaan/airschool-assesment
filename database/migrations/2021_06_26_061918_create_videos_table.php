<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('directory')->nullable();
            $table->string('fileType')->nullable();
            $table->string('MIMEType')->nullable();
            $table->string('MIMETypeConverted')->nullable();
            $table->timestamp('modifyDate')->nullable();
            $table->string('timeScale')->nullable();
            $table->string('duration')->nullable();
            $table->string('compressorId')->nullable();
            $table->string('XResolution')->nullable();
            $table->string('YResolution')->nullable();
            $table->string('thumbnail')->nullable();
            $table->timestamp('conversionStatus')->nullable();
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
        Schema::dropIfExists('videos');
    }
}
