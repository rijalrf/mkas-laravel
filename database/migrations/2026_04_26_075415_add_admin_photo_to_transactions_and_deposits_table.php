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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('admin_photo')->nullable()->after('admin_note');
        });

        Schema::table('deposits', function (Blueprint $table) {
            $table->string('admin_photo')->nullable()->after('admin_note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('admin_photo');
        });

        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn('admin_photo');
        });
    }
};
