<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Colaborador;
use App\Mail\WelcomeColaboradorMail;
use Illuminate\Support\Facades\Mail;

class TestEmailCommand extends Command
{
    protected $signature = 'test:email {email}';
    protected $description = 'Testa o envio de email de boas-vindas';

    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info("Testando envio de email para: {$email}");
        
        $colaborador = new Colaborador([
            'name' => 'Teste Email',
            'email' => $email,
            'phone' => '(11) 99999-9999',
            'cargo' => 'Desenvolvedor',
            'departamento' => 'TI',
            'data_admissao' => now(),
            'status' => 'ativo'
        ]);
        
        try {
            Mail::to($email)->send(new WelcomeColaboradorMail($colaborador));
            $this->info('✅ Email enviado com sucesso! Verifique sua caixa de entrada.');
        } catch (\Exception $e) {
            $this->error('❌ Erro ao enviar email: ' . $e->getMessage());
        }
    }
}