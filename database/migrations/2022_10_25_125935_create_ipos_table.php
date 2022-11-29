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
            $table->string('first_round_company_evaluation')->nullable();
            $table->string('second_round_company_evaluation')->nullable();
            $table->text('investor_category');
            $table->text('ipos_platform');
            $table->string('first_round_funding_amount')->nullable();
            $table->string('second_round_funding_amount')->nullable();
            $table->unsignedFloat('first_round_share_price')->nullable();
            $table->unsignedFloat('second_round_share_price')->nullable();
            $table->string('first_round_investors')->nullable();
            $table->string('second_round_investors')->nullable();
            $table->string('first_round_offering')->nullable();
            $table->string('second_round_offering')->nullable();
            $table->string('offering_ratio');
            $table->text('ipos_status');
            $table->text('ipos_manager');
            $table->string('news_link')->nullable();
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
