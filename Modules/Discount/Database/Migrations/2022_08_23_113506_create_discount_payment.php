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
        Schema::create('discount_payment', function (Blueprint $table) {
            $table->foreignId("discount_id");
            $table->foreignId("payment_id");
            $table->primary(["discount_id", "payment_id"]);
            $table->foreign("discount_id")->references("id")->on("discounts")->onDelete("CASCADE");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('');
    }
};
