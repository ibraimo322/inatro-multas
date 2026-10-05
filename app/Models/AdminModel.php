<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table            = 'utilizadores_admin';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome',
        'email',
        'senha_hash',
        'cargo',
        'created_at',
    ];

    /**
     * Autenticar administrador por e-mail e senha
     */
    public function autenticar($email, $senha)
    {
        $admin = $this->where('email', strtolower(trim($email)))->first();

        if ($admin && password_verify($senha, $admin['senha_hash'])) {
            return $admin;
        }

        return false;
    }
}
