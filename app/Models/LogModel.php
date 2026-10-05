<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table            = 'logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'utilizador',
        'acao',
        'detalhes',
        'ip_address',
        'created_at',
    ];

    /**
     * Regista um novo log no sistema
     */
    public function registrar($utilizador, $acao, $detalhes = null)
    {
        $request = \Config\Services::request();
        return $this->insert([
            'utilizador' => $utilizador,
            'acao'       => $acao,
            'detalhes'   => $detalhes,
            'ip_address' => $request->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
