<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payment_plans', function (Blueprint $table) {
            $table->string('status')->default('NEW')->change();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('payment_plan_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_plans', function (Blueprint $table) {
            $table->string('status')->default('PENDING')->change();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('payment_plan_id');
        });
    }
};
