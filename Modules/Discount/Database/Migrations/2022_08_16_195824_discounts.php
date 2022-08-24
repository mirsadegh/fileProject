<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->string("code")->nullable();
            $table->tinyInteger("percent")->unsigned();
            $table->bigInteger("usage_limitation")->nullable()->unsigned(); // null means unlimited
            $table->timestamp("expire_at")->nullable();
            $table->string("link", 300)->nullable();
            $table->string("description")->nullable();
            $table->enum("type", [\Modules\Discount\Entities\Discount::$types])
                ->default(\Modules\Discount\Entities\Discount::TYPE_ALL);
            $table->bigInteger("uses")->default(0)->unsigned();
            $table->timestamps();
        });

        Schema::create('discountables', function (Blueprint $table) {
            $table->foreignId("discount_id");
            $table->foreignId("discountable_id");
            $table->string("discountable_type");
            $table->primary(["discount_id", "discountable_id", "discountable_type"], "discountable_key");
        });
    }

    public function down()
    {
        Schema::dropIfExists('discounts');
        Schema::dropIfExists('discountables');
    }
};
