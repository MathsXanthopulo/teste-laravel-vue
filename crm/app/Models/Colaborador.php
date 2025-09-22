<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Colaborador extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'colaboradores';

    protected $fillable = [
        'company_id',
        'name',
        'email',
        'phone',
        'cargo',
        'departamento',
        'salario',
        'data_admissao',
        'data_demissao',
        'status',
    ];

    protected $casts = [
        'data_admissao' => 'date',
        'data_demissao' => 'date',
        'salario' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relacionamento com a empresa (User)
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    /**
     * Scope para filtrar por empresa
     */
    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Scope para colaboradores ativos
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'ativo');
    }

    /**
     * Scope para colaboradores inativos
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inativo');
    }

    /**
     * Accessor para formatar salário como moeda
     */
    public function getSalarioFormatadoAttribute(): string
    {
        if (!$this->salario || $this->salario === 0) {
            return 'R$ 0,00';
        }

        // Garantir que o valor seja numérico
        $valor = is_numeric($this->salario) ? (float) $this->salario : 0;
        
        return 'R$ ' . number_format($valor, 2, ',', '.');
    }

    /**
     * Accessor para gerar avatar com iniciais
     */
    public function getAvatarAttribute(): string
    {
        $names = explode(' ', $this->name);
        $initials = '';
        
        foreach ($names as $name) {
            if (!empty($name)) {
                $initials .= strtoupper(substr($name, 0, 1));
            }
        }
        
        return substr($initials, 0, 2);
    }

    /**
     * Accessor para data de admissão formatada
     */
    public function getDataAdmissaoFormatadaAttribute(): string
    {
        return $this->data_admissao ? $this->data_admissao->format('d/m/Y') : '-';
    }
}
