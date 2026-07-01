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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('issued_by')->constrained('universities')->onDelete('cascade');
            $table->string('certificate_id')->unique();
            $table->string('file_path');
            $table->string('keccak256_hash')->unique();
            $table->string('tx_hash')->unique();
            $table->string('contract_address');
            $table->enum('status', ['pending', 'issued', 'revoked'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
