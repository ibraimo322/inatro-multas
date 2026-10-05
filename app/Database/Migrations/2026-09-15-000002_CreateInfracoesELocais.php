<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInfracoesELocais extends Migration
{
    public function up()
    {
        // Table: infracoes
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tipo' => [
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
            'valor' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'activo' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('infracoes', true);

        // Table: locais_infracao
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'provincia' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'local_nome' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'activo' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('locais_infracao', true);
    }

    public function down()
    {
        $this->forge->dropTable('locais_infracao', true);
        $this->forge->dropTable('infracoes', true);
    }
}
