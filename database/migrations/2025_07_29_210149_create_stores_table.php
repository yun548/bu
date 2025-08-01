<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('siret');
            $table->string('customs_code');
            $table->string('document_path');
            $table->timestamps();
        });
        
        Schema::create('activity_store', function (Blueprint $table) {
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->foreignId('activity_id')->constrained()->onDelete('cascade');
            $table->primary(['store_id', 'activity_id']);
        });

        Schema::create('store_user', function (Blueprint $table) {
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->primary(['store_id', 'user_id']);
        });
    }
    
    public function down(): void
    {
       
        Schema::dropIfExists('store_user');
        Schema::dropIfExists('stores');
        Schema::dropIfExists('activity_store');
        Schema::dropIfExists('activities');
    }
};