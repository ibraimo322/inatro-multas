<?php

namespace App\Models;

use CodeIgniter\Model;

class PagamentoModel extends Model
{
    protected $table            = 'pagamentos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'referencia_transacao',
        'multa_id',
        'utente_id',
        'valor_pago',
        'metodo_pagamento',
        'detalhes_metodo',
        'estado',
        'data_pagamento',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Buscar histórico de pagamentos de um utente
     */
    public function getHistoricoUtente($utenteId)
    {
        return $this->select('pagamentos.*, multas.codigo_multa, multas.tipo_infracao, multas.local_infracao, multas.data_infracao')
                    ->join('multas', 'multas.id = pagamentos.multa_id')
                    ->where('pagamentos.utente_id', $utenteId)
                    ->orderBy('pagamentos.data_pagamento', 'DESC')
                    ->findAll();
    }

    /**
     * Obter detalhes do comprovativo de pagamento por referência ou por ID
     */
    public function getComprovativo($idOuReferencia)
    {
        $builder = $this->select('pagamentos.*, multas.codigo_multa, multas.tipo_infracao, multas.local_infracao, multas.data_infracao, utentes.nome as utente_nome, utentes.numero_carta, utentes.bi_numero')
                        ->join('multas', 'multas.id = pagamentos.multa_id')
                        ->join('utentes', 'utentes.id = pagamentos.utente_id');

        if (is_numeric($idOuReferencia)) {
            $builder->where('pagamentos.id', $idOuReferencia);
        } else {
            $builder->where('pagamentos.referencia_transacao', $idOuReferencia);
        }

        return $builder->first();
    }

    /**
     * Obter todos os pagamentos/transações para a área do admin com filtros avançados
     */
    public function getPagamentosAdmin($estado = null, $busca = null, $data = null)
    {
        $builder = $this->select('pagamentos.*, multas.codigo_multa, multas.tipo_infracao, multas.valor as multa_valor, multas.data_infracao, multas.estado as multa_estado, utentes.nome as utente_nome, utentes.numero_carta')
                        ->join('multas', 'multas.id = pagamentos.multa_id')
                        ->join('utentes', 'utentes.id = pagamentos.utente_id');

        if (!empty($estado) && $estado !== 'todos') {
            $builder->where('pagamentos.estado', $estado);
        }

        if (!empty($data)) {
            $builder->where('DATE(pagamentos.data_pagamento)', $data);
        }

        if (!empty($busca)) {
            $busca = trim($busca);
            $builder->groupStart()
                    ->like('utentes.nome', $busca)
                    ->orLike('utentes.numero_carta', $busca)
                    ->orLike('pagamentos.referencia_transacao', $busca)
                    ->orLike('multas.codigo_multa', $busca)
                    ->orLike('multas.tipo_infracao', $busca)
                    ->groupEnd();
        }

        return $builder->orderBy('pagamentos.data_pagamento', 'DESC')->findAll();
    }
}
