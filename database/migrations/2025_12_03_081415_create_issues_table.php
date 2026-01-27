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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('machine_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->dateTime('reported_at')->nullable();
            $table->string('priority')->default('normal');
            $table->string('status')->default('open');
            $table->text('description');
            $table->timestamps();

            $table->foreign('machine_id')
                ->references('id')->on('machines')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('issues');
    }
};
