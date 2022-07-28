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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id');
            $table->foreignId('seller_id')->nullable();
            $table->foreignId('paymentable_id');
            $table->string('paymentable_type');
            $table->string('amount', 10);
            $table->string('invoice_id');
            $table->string('gateway');
            $table->enum('status', \Modules\Payment\Entities\Payment::$statuses);
            $table->tinyInteger('seller_p')->unsigned();
            $table->string('seller_share', 10);
            $table->string('site_share', 10);
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
        Schema::dropIfExists('payments');
    }
};
