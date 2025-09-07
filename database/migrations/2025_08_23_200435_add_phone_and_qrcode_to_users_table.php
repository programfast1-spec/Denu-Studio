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
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone')->nullable()->index();   // 628xxxx
                $table->string('qr_code')->nullable()->unique(); // kode unik QR
            });
        }
        public function down(): void
        {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['phone', 'qr_code']);
            });

    }
};
