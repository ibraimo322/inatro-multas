<?php

namespace App\Models;

use CodeIgniter\Model;

class UtenteModel extends Model
{
    protected $table            = 'utentes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome',
        'numero_carta',
        'data_nascimento',
        'bi_numero',
        'telefone',
        'email',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Autenticar utente por N.º de Carta e Data de Nascimento
     */
    public function autenticar($numeroCarta, $dataNascimento)
    {
        return $this->where('UPPER(numero_carta)', strtoupper(trim($numeroCarta)))
                    ->where('data_nascimento', trim($dataNascimento))
                    ->first();
    }
}
