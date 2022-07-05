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
        Schema::table('courses', function (Blueprint $table) {

            $table->unsignedBigInteger('banner_id')->after('teacher_id')->nullable();
            $table->foreign('banner_id')->references('id')->on('media')->onDelete('SET NULL');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('banner_id');
        });
    }
};
