<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imports', function (Blueprint $table) {
            $table->id();
            $table->text('id1')->nullable();
            $table->text('id2')->nullable();
            $table->text('first_name')->nullable();
            $table->text('middle_name')->nullable();
            $table->text('sex')->nullable();
            $table->text('facebook_url')->nullable();
            $table->text('last_name')->nullable();
            $table->text('education')->nullable();
            $table->text('job1')->nullable();
            $table->text('location')->nullable();
            $table->text('city')->nullable();
            $table->text('last_city')->nullable();
            $table->text('current_job')->nullable();
            $table->text('date1')->nullable();
            $table->text('date2')->nullable();
            $table->text('date3')->nullable();
            $table->text('date4')->nullable();
            $table->text('date5')->nullable();
            $table->text('date6')->nullable();
            $table->text('date7')->nullable();
            $table->text('date8')->nullable();
            $table->text('relation_ship')->nullable();
            $table->text('date9')->nullable();
            $table->text('relation2')->nullable();
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
        Schema::dropIfExists('imports');
    }
}
