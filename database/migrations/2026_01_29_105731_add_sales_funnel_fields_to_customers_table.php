<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->enum('funnel_stage', ['lead', 'prospect', 'quote_sent', 'customer', 'delivered'])
                ->default('lead')
                ->after('status');
            $table->date('last_contact_date')->nullable()->after('funnel_stage');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null')->after('last_contact_date');
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['assigned_to']);
            $table->dropColumn(['funnel_stage', 'last_contact_date', 'assigned_to']);
        });
    }
};
