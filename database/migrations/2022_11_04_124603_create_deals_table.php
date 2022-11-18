<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ad_id');
            $table->string('chat_id');
            $table->string('seller_name');
            $table->string('seller_phone');
            $table->string('buyer_name');
            $table->string('buyer_phone');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('shares_qty');
            $table->unsignedFloat('price');
            $table->text('status');
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
        Schema::dropIfExists('deals');
    }
};
