<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInatroTables extends Migration
{
    public function up()
    {
        // Table: utentes
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'numero_carta' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'data_nascimento' => [
                'type' => 'DATE',
            ],
            'bi_numero' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'telefone' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'null'       => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('utentes', true);

        // Table: multas
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'codigo_multa' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'utente_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tipo_infracao' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'artigo_lei' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'descricao' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'local_infracao' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'data_infracao' => [
                'type' => 'DATETIME',
            ],
            'data_vencimento' => [
                'type' => 'DATE',
            ],
            'valor' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'estado' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'default'    => 'pendente', // pendente, paga, em_processamento, vencida
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('multas', true);

        // Table: pagamentos
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'referencia_transacao' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'multa_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'utente_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'valor_pago' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'metodo_pagamento' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'detalhes_metodo' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'estado' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'default'    => 'pago', // pago, pendente, rejeitado
            ],
            'data_pagamento' => [
                'type' => 'DATETIME',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pagamentos', true);

        // Table: utilizadores_admin
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'senha_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'cargo' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'Administrador Geral',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('utilizadores_admin', true);

        // Table: logs
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'utilizador' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'acao' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'detalhes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => '45',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('logs', true);
    }

    public function down()
    {
        $this->forge->dropTable('logs', true);
        $this->forge->dropTable('utilizadores_admin', true);
        $this->forge->dropTable('pagamentos', true);
        $this->forge->dropTable('multas', true);
        $this->forge->dropTable('utentes', true);
    }
}
