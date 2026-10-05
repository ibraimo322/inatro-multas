<?php

namespace App\Models;

use CodeIgniter\Model;

class InfracaoModel extends Model
{
    protected $table            = 'infracoes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tipo',
        'artigo_lei',
        'descricao',
        'valor',
        'activo',
        'created_at',
    ];

    /**
     * Retorna todas as infracções activas
     */
    public function getInfracoesActivas()
    {
        return $this->where('activo', 1)->orderBy('tipo', 'ASC')->findAll();
    }
}
