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
        Schema::create('investment_funds', function (Blueprint $table) {
            $table->id();
            $table->string('fund_number');
            $table->string('fund');
            $table->string('platform');
            $table->string('type');
            $table->date('offer_date');
            $table->unsignedFloat('value');
            $table->unsignedFloat('platform_share');
            $table->text('fund_duration');
            $table->unsignedFloat('total_return');
            $table->text('fund_manager')->nullable();
            $table->text('fund_manager_website')->nullable();
            $table->text('developer')->nullable();
            $table->text('location')->nullable();
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
        Schema::dropIfExists('investment_funds');
    }
};
