<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id');
            $table->text('post_text')->nullable();
            $table->string('link_url')->nullable();
            $table->string('link_text')->nullable();
            $table->foreignId('post_id')->nullable()->references('id')->on('posts');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};