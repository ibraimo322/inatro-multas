<?php

namespace App\Models;

use CodeIgniter\Model;

class MultaModel extends Model
{
    protected $table            = 'multas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'codigo_multa',
        'utente_id',
        'tipo_infracao',
        'artigo_lei',
        'descricao',
        'local_infracao',
        'data_infracao',
        'data_vencimento',
        'valor',
        'estado',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Buscar multas de um determinado utente com filtro opcional de estado
     */
    public function getMultasUtente($utenteId, $estado = null)
    {
        $builder = $this->where('utente_id', $utenteId);

        if (!empty($estado) && $estado !== 'todas') {
            $builder->where('estado', $estado);
        }

        return $builder->orderBy('data_infracao', 'DESC')->findAll();
    }

    /**
     * Resumo de totais por estado para o utente
     */
    public function getResumoUtente($utenteId)
    {
        $multas = $this->where('utente_id', $utenteId)->findAll();

        $resumo = [
            'total'            => count($multas),
            'pendentes'        => 0,
            'pagas'            => 0,
            'em_processamento' => 0,
            'vencidas'         => 0,
            'valor_total'      => 0.00,
        ];

        foreach ($multas as $m) {
            $resumo['valor_total'] += floatval($m['valor']);
            if ($m['estado'] === 'pendente') {
                $resumo['pendentes']++;
            } elseif ($m['estado'] === 'paga') {
                $resumo['pagas']++;
            } elseif ($m['estado'] === 'em_processamento') {
                $resumo['em_processamento']++;
            } elseif ($m['estado'] === 'vencida') {
                $resumo['vencidas']++;
            }
        }

        return $resumo;
    }

    /**
     * Obter multas completas com dados do utente para a área do admin
     */
    public function getMultasComUtente($estado = null)
    {
        $builder = $this->select('multas.*, utentes.nome as utente_nome, utentes.numero_carta')
                        ->join('utentes', 'utentes.id = multas.utente_id');

        if (!empty($estado) && $estado !== 'todas') {
            $builder->where('multas.estado', $estado);
        }

        return $builder->orderBy('multas.data_infracao', 'DESC')->findAll();
    }
}
