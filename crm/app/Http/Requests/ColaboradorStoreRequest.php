<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ColaboradorStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $companyId = auth()->id();
        
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('colaboradores')->where(function ($query) use ($companyId) {
                    return $query->where('company_id', $companyId);
                })
            ],
            'phone' => [
                'nullable',
                'string',
                'max:15',
                Rule::unique('colaboradores')->where(function ($query) use ($companyId) {
                    return $query->where('company_id', $companyId);
                })
            ],
            'cargo' => 'nullable|string|max:255',
            'departamento' => 'nullable|string|max:255',
            'salario' => 'nullable|string',
            'data_admissao' => 'nullable|date',
            'status' => 'nullable|in:ativo,inativo',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto válido.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            
            'email.email' => 'O e-mail deve ter um formato válido.',
            'email.max' => 'O e-mail não pode ter mais de 255 caracteres.',
            'email.unique' => 'Este e-mail já está cadastrado na sua empresa.',
            
            'phone.string' => 'O telefone deve ser um texto válido.',
            'phone.max' => 'O telefone não pode ter mais de 15 caracteres.',
            'phone.unique' => 'Este telefone já está cadastrado na sua empresa.',
            
            'cargo.string' => 'O cargo deve ser um texto válido.',
            'cargo.max' => 'O cargo não pode ter mais de 255 caracteres.',
            
            'departamento.string' => 'O departamento deve ser um texto válido.',
            'departamento.max' => 'O departamento não pode ter mais de 255 caracteres.',
            
            'salario.string' => 'O salário deve ser um texto válido.',
            
            'data_admissao.date' => 'A data de admissão deve ser uma data válida.',
            
            'status.in' => 'O status deve ser ativo ou inativo.',
        ];
    }
}