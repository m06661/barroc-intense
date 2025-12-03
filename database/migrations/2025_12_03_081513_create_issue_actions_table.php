<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('issue_actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('issue_id');
            $table->unsignedBigInteger('technician_id')->nullable();
            $table->dateTime('action_date');
            $table->text('action_description');
            $table->text('result')->nullable();
            $table->boolean('is_solution')->default(false);
            $table->timestamps();

            $table->foreign('issue_id')
                ->references('id')->on('issues')
                ->onDelete('cascade');

            $table->foreign('technician_id')
                ->references('id')->on('technicians')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('issue_actions');
    }
};
