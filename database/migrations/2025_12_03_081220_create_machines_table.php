<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('serial_number')->unique();
            $table->string('type');
            $table->string('location')->nullable();
            $table->date('installed_at')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')->on('customers')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('machines');
    }
};
