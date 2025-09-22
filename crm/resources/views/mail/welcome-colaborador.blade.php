<x-mail::message>
# Bem-vindo(a), {{ $colaborador->name }}! 🎉

Seu cadastro foi concluído com sucesso em nosso sistema.

## Seus dados cadastrados:
- **Nome:** {{ $colaborador->name }}
- **E-mail:** {{ $colaborador->email ?? 'Não informado' }}
- **Telefone:** {{ $colaborador->phone ?? 'Não informado' }}
- **Cargo:** {{ $colaborador->cargo ?? 'Não informado' }}
- **Departamento:** {{ $colaborador->departamento ?? 'Não informado' }}
- **Data de admissão:** {{ $colaborador->data_admissao ? $colaborador->data_admissao->format('d/m/Y') : 'Não informada' }}

<x-mail::button :url="config('app.url')">
Acessar Portal da Empresa
</x-mail::button>

Bem-vindo à equipe!<br>
{{ $company_name }}
</x-mail::message>