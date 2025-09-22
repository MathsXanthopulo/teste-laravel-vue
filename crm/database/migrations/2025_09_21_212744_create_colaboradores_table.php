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
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('users')->onDelete('cascade');
            
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            
            $table->string('cargo')->nullable(); // Cargo/posição
            $table->string('departamento')->nullable();
            $table->decimal('salario', 10, 2)->nullable();
            $table->date('data_admissao')->nullable();
            $table->date('data_demissao')->nullable();
            
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
            
            $table->softDeletes();
            $table->timestamps();
            
            // Índices únicos por empresa (conforme regra de negócio)
            $table->unique(['company_id', 'email'], 'unique_email_per_company');
            $table->unique(['company_id', 'phone'], 'unique_phone_per_company');
            
            // Índices para performance
            $table->index(['company_id', 'status']);
            $table->index('data_admissao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colaboradores');
    }
};
