<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('store_user', function (Blueprint $table) {
            $table->string('role')->default('employee')->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('store_user', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};

