<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs',function (Blueprint $table){
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->text('summary');
            $table->text('body');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('commentable')->default(0)->comment('0 => uncommentable , 1 => commentable');
            $table->string('tags');
            $table->timestamp('published_at');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('media_id')->constrained('media');
            $table->foreignId('category_id')->constrained('categories');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
