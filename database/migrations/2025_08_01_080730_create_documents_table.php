<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id');
            $table->foreignId('user_id');
            $table->dateTime('uploaded_at');
            $table->dateTime('due_at')->nullable();
            $table->dateTime('emitted_at')->nullable();
            $table->string('type')->nullable();
            $table->integer('amount')->nullable();
            $table->string('status');
            $table->string('supplier')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('filepath');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
