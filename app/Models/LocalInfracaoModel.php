<?php

namespace App\Models;

use CodeIgniter\Model;

class LocalInfracaoModel extends Model
{
    protected $table            = 'locais_infracao';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'provincia',
        'local_nome',
        'activo',
        'created_at',
    ];

    /**
     * Retorna a lista de províncias únicas cadastradas
     */
    public function getProvincias()
    {
        return $this->select('provincia')
                    ->where('activo', 1)
                    ->groupBy('provincia')
                    ->orderBy('provincia', 'ASC')
                    ->findAll();
    }

    /**
     * Retorna os locais pertencentes a uma determinada província
     */
    public function getLocaisPorProvincia($provincia)
    {
        return $this->where('activo', 1)
                    ->where('provincia', $provincia)
                    ->orderBy('local_nome', 'ASC')
                    ->findAll();
    }
}
