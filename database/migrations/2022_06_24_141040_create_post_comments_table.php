<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('post_id');
            $table->foreignId('user_id');
            $table->text('comment_text');
            $table->unsignedBigInteger('parent_comment_id')->nullable();

            $table->timestamps();

            $table->foreign('parent_comment_id')->references('id')->on('post_comments');
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_comments');
    }
};