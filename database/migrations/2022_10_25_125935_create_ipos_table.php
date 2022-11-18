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
        Schema::create('ipos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('company_id');
            $table->text('investor_category');
            $table->text('ipos_platform');
            $table->unsignedFloat('size');
            $table->string('funding_amount');
            $table->unsignedFloat('share_price');
            $table->string('first_round_investors');
            $table->string('second_round_investors');
            $table->string('offering_price');
            $table->string('offering_ratio');
            $table->string('first_round_offering');
            $table->string('second_round_offering');
            $table->text('ipos_status');
            $table->text('ipos_manager');
            $table->text('details')->nullable();
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
        Schema::dropIfExists('ipos');
    }
};
