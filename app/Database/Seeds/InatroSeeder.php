<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InatroSeeder extends Seeder
{
    public function run()
    {
        // 1. Utente Administrador
        $this->db->table('utilizadores_admin')->truncate();
        $this->db->table('utilizadores_admin')->insert([
            'nome'       => 'Administrador do Sistema INATRO',
            'email'      => 'admin@inatro.gov.mz',
            'senha_hash' => password_hash('admin123', PASSWORD_DEFAULT),
            'cargo'      => 'Super Administrador',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // 2. Utentes / Condutores de Teste
        $this->db->table('utentes')->truncate();
        $utentes = [
            [
                'id'              => 1,
                'nome'            => 'Carlos Alberto Mondlane',
                'numero_carta'    => '10293847/MZ',
                'data_nascimento' => '1988-04-15',
                'bi_numero'       => '110293847591B',
                'telefone'        => '+258 84 123 4567',
                'email'           => 'carlos.mondlane@exemplo.co.mz',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'id'              => 2,
                'nome'            => 'Maria Helena Macamo',
                'numero_carta'    => '99887766/MZ',
                'data_nascimento' => '1992-09-20',
                'bi_numero'       => '110998877662C',
                'telefone'        => '+258 82 987 6543',
                'email'           => 'maria.macamo@exemplo.co.mz',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'id'              => 3,
                'nome'            => 'Sérgio Fernando Tembe',
                'numero_carta'    => '55443322/MZ',
                'data_nascimento' => '1985-11-03',
                'bi_numero'       => '110554433224A',
                'telefone'        => '+258 86 555 4433',
                'email'           => 'sergio.tembe@exemplo.co.mz',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('utentes')->insertBatch($utentes);

        // 3. Tipos de Infrações Pré-cadastradas
        $this->db->table('infracoes')->truncate();
        $infracoes = [
            [
                'id'         => 1,
                'tipo'       => 'Excesso de velocidade',
                'artigo_lei' => 'Artigo 45.º do Código da Estrada',
                'descricao'  => 'Circulação a velocidade superior aos limites legais estabelecidos para a via.',
                'valor'      => 2500.00,
                'activo'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 2,
                'tipo'       => 'Estacionamento irregular',
                'artigo_lei' => 'Artigo 68.º do Código da Estrada',
                'descricao'  => 'Estacionamento em locais proibidos, passeios ou impedindo a circulação.',
                'valor'      => 1200.00,
                'activo'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 3,
                'tipo'       => 'Condução sem cinto de segurança',
                'artigo_lei' => 'Artigo 82.º do Código da Estrada',
                'descricao'  => 'Não utilização do cinto de segurança por condutor ou ocupantes.',
                'valor'      => 1500.00,
                'activo'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 4,
                'tipo'       => 'Paragem em local proibido',
                'artigo_lei' => 'Artigo 71.º do Código da Estrada',
                'descricao'  => 'Imobilização voluntária do veículo em cruzamentos ou zonas de paragem proibida.',
                'valor'      => 1000.00,
                'activo'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 5,
                'tipo'       => 'Falta de inspecção periódica',
                'artigo_lei' => 'Artigo 112.º do Código da Estrada',
                'descricao'  => 'Circulação com certificado de inspecção automóvel caducado ou inexistente.',
                'valor'      => 3500.00,
                'activo'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 6,
                'tipo'       => 'Uso de telemóvel durante a condução',
                'artigo_lei' => 'Artigo 84.º do Código da Estrada',
                'descricao'  => 'Utilização continuada de dispositivo móvel sem sistema viva-voz.',
                'valor'      => 2000.00,
                'activo'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 7,
                'tipo'       => 'Desrespeito ao sinal luminoso (Sinal Vermelho)',
                'artigo_lei' => 'Artigo 32.º do Código da Estrada',
                'descricao'  => 'Transposição de sinalização de paragem obrigatória no semáforo.',
                'valor'      => 3000.00,
                'activo'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 8,
                'tipo'       => 'Condução sob influência de álcool',
                'artigo_lei' => 'Artigo 81.º do Código da Estrada',
                'descricao'  => 'Condução com taxa de álcool no sangue superior ao limite legalmente permitido.',
                'valor'      => 5000.00,
                'activo'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 9,
                'tipo'       => 'Condução sem carta de condução habilitante',
                'artigo_lei' => 'Artigo 121.º do Código da Estrada',
                'descricao'  => 'Conduzir veículo automóvel sem possuir a respectiva carta ou licença válida.',
                'valor'      => 4000.00,
                'activo'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 10,
                'tipo'       => 'Ultrapassagem irregular em linha contínua',
                'artigo_lei' => 'Artigo 38.º do Código da Estrada',
                'descricao'  => 'Manobra de ultrapassagem em locais proibidos ou sobre marcação contínua.',
                'valor'      => 2500.00,
                'activo'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('infracoes')->insertBatch($infracoes);

        // 4. Locais de Infrações Pré-cadastrados (5 por Província x 11 Províncias = 55 Locais)
        $this->db->table('locais_infracao')->truncate();
        $provinciasLocais = [
            'Cabo Delgado' => [
                'Pemba - Av. Marginal',
                'Montepuez - Estrada Nacional N14',
                'Mocímboa da Praia - Centro Urbano',
                'Chiúre - Cruzamento Principal',
                'Palma - Zona Portuária',
            ],
            'Niassa' => [
                'Lichinga - Av. Eduardo Mondlane',
                'Cuamba - Estrada Principal',
                'Majune - Posto de Controlo',
                'Mandimba - Zona Fronteiriça',
                'Lago - Estrada de Metangula',
            ],
            'Nampula' => [
                'Nampula - Av. Samora Machel',
                'Nacala - Zona Industrial',
                'Angoche - Rotunda Central',
                'Monapo - Cruzamento EN1',
                'Ilha de Moçambique - Ponte de Acesso',
            ],
            'Zambézia' => [
                'Quelimane - Av. 25 de Setembro',
                'Mocuba - Cruzamento EN1 / EN232',
                'Gurué - Zona das Plantações',
                'Alto Molócuè - Posto Fiscal',
                'Nicoadala - Entroncamento N1',
            ],
            'Tete' => [
                'Tete - Ponte Samora Machel',
                'Moatize - Estrada da Mina',
                'Changara - Posto de Controlo EN7',
                'Angónia - Fronteira Zóbuè',
                'Cahora Bassa - Vila do Songo',
            ],
            'Manica' => [
                'Chimoio - Av. 25 de Setembro',
                'Manica - Posto Fronteiriço Machipanda',
                'Gondola - Estrada Nacional N6',
                'Catandica - Centro Comercial',
                'Sussundenga - Estrada Principal',
            ],
            'Sofala' => [
                'Beira - Rua Correia de Brito',
                'Dondo - Estrada Nacional N6',
                'Gorongosa - Cruzamento N1',
                'Manga - Zona Industrial',
                'Beira - Av. das FPLM',
            ],
            'Inhambane' => [
                'Inhambane - Av. da Revolução',
                'Maxixe - Marginal N1',
                'Vilankulo - Zona Turística',
                'Morrumbene - Posto de Controlo',
                'Massinga - Centro Urbano',
            ],
            'Gaza' => [
                'Xai-Xai - Av. Samora Machel',
                'Chókwè - Zona Agrícola',
                'Mandlakazi - Estrada Principal',
                'Bilene - Av. da Praia',
                'Chibuto - Rotunda Central',
            ],
            'Maputo' => [
                'Matola - Estrada Nacional N1',
                'Boane - Cruzamento de Namaacha',
                'Manhiça - Posto de Controlo EN1',
                'Marracuene - Rotunda da Vila',
                'Ressano Garcia - Posto Fronteiriço',
            ],
            'Cidade de Maputo' => [
                'Av. Eduardo Mondlane, Maputo',
                'Av. 24 de Julho, Maputo',
                'Av. Marginal, Maputo',
                'Av. Mao Tse Tung, Maputo',
                'Av. Kenneth Kaunda, Maputo',
            ],
        ];

        $locaisBatch = [];
        foreach ($provinciasLocais as $prov => $locais) {
            foreach ($locais as $loc) {
                $locaisBatch[] = [
                    'provincia'  => $prov,
                    'local_nome' => $loc,
                    'activo'     => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
            }
        }
        $this->db->table('locais_infracao')->insertBatch($locaisBatch);

        // 5. Multas
        $this->db->table('multas')->truncate();
        $multas = [
            [
                'id'              => 1,
                'codigo_multa'    => 'MT-2026-0001',
                'utente_id'       => 1,
                'tipo_infracao'   => 'Excesso de velocidade',
                'artigo_lei'      => 'Artigo 45.º do Código da Estrada',
                'descricao'       => 'Circulação a 85 km/h em zona urbana com limite fixado em 60 km/h.',
                'local_infracao'  => 'Av. Eduardo Mondlane, Maputo',
                'data_infracao'   => '2026-08-10 14:30:00',
                'data_vencimento' => '2026-09-25',
                'valor'           => 2500.00,
                'estado'          => 'pendente',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'id'              => 2,
                'codigo_multa'    => 'MT-2026-0002',
                'utente_id'       => 1,
                'tipo_infracao'   => 'Estacionamento irregular',
                'artigo_lei'      => 'Artigo 68.º do Código da Estrada',
                'descricao'       => 'Estacionamento em passeio pedonal impedindo o trânsito de peões.',
                'local_infracao'  => 'Av. 24 de Julho, Maputo',
                'data_infracao'   => '2026-07-05 09:15:00',
                'data_vencimento' => '2026-08-05',
                'valor'           => 1200.00,
                'estado'          => 'paga',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'id'              => 3,
                'codigo_multa'    => 'MT-2026-0003',
                'utente_id'       => 1,
                'tipo_infracao'   => 'Condução sem cinto de segurança',
                'artigo_lei'      => 'Artigo 82.º do Código da Estrada',
                'descricao'       => 'Condutor e passageiro sem utilização do cinto de segurança obrigatório.',
                'local_infracao'  => 'Av. Marginal, Maputo',
                'data_infracao'   => '2026-08-28 17:45:00',
                'data_vencimento' => '2026-09-30',
                'valor'           => 1500.00,
                'estado'          => 'em_processamento',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'id'              => 4,
                'codigo_multa'    => 'MT-2026-0004',
                'utente_id'       => 1,
                'tipo_infracao'   => 'Paragem em local proibido',
                'artigo_lei'      => 'Artigo 71.º do Código da Estrada',
                'descricao'       => 'Imobilização de veículo em cruzamento de vias de grande intensidade.',
                'local_infracao'  => 'Matola - Estrada Nacional N1',
                'data_infracao'   => '2026-08-15 11:20:00',
                'data_vencimento' => '2026-09-15',
                'valor'           => 1000.00,
                'estado'          => 'pendente',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'id'              => 5,
                'codigo_multa'    => 'MT-2026-0005',
                'utente_id'       => 1,
                'tipo_infracao'   => 'Falta de inspecção periódica',
                'artigo_lei'      => 'Artigo 112.º do Código da Estrada',
                'descricao'       => 'Circulação com certificado de inspecção automóvel caducado.',
                'local_infracao'  => 'Nampula - Av. Samora Machel',
                'data_infracao'   => '2026-05-10 08:00:00',
                'data_vencimento' => '2026-06-10',
                'valor'           => 3500.00,
                'estado'          => 'vencida',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'id'              => 6,
                'codigo_multa'    => 'MT-2026-0006',
                'utente_id'       => 1,
                'tipo_infracao'   => 'Uso de telemóvel durante a condução',
                'artigo_lei'      => 'Artigo 84.º do Código da Estrada',
                'descricao'       => 'Utilização continuada de dispositivo móvel sem sistema de mãos livres.',
                'local_infracao'  => 'Beira - Rua Correia de Brito',
                'data_infracao'   => '2026-08-20 16:10:00',
                'data_vencimento' => '2026-09-20',
                'valor'           => 2000.00,
                'estado'          => 'pendente',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'id'              => 7,
                'codigo_multa'    => 'MT-2026-0007',
                'utente_id'       => 2,
                'tipo_infracao'   => 'Desrespeito ao sinal luminoso (Sinal Vermelho)',
                'artigo_lei'      => 'Artigo 32.º do Código da Estrada',
                'descricao'       => 'Transposição de intersecção com sinalização de paragem obrigatória.',
                'local_infracao'  => 'Av. Mao Tse Tung, Maputo',
                'data_infracao'   => '2026-08-01 19:30:00',
                'data_vencimento' => '2026-09-01',
                'valor'           => 3000.00,
                'estado'          => 'pendente',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('multas')->insertBatch($multas);

        // 6. Pagamentos
        $this->db->table('pagamentos')->truncate();
        $pagamentos = [
            [
                'referencia_transacao' => 'TX-2026-000001',
                'multa_id'             => 2,
                'utente_id'            => 1,
                'valor_pago'           => 1200.00,
                'metodo_pagamento'     => 'M-Pesa',
                'detalhes_metodo'      => '+258 84 123 4567',
                'estado'               => 'pago',
                'data_pagamento'       => '2026-07-06 10:20:00',
                'created_at'           => date('Y-m-d H:i:s'),
                'updated_at'           => date('Y-m-d H:i:s'),
            ],
            [
                'referencia_transacao' => 'TX-2026-000002',
                'multa_id'             => 3,
                'utente_id'            => 1,
                'valor_pago'           => 1500.00,
                'metodo_pagamento'     => 'e-Mola',
                'detalhes_metodo'      => '+258 86 123 4567',
                'estado'               => 'pendente',
                'data_pagamento'       => '2026-08-28 18:00:00',
                'created_at'           => date('Y-m-d H:i:s'),
                'updated_at'           => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('pagamentos')->insertBatch($pagamentos);

        // 7. Logs
        $this->db->table('logs')->truncate();
        $logs = [
            [
                'utilizador' => 'Sistema Geral',
                'acao'       => 'Inicialização da Base de Dados',
                'detalhes'   => 'Tabelas populadas com infracções pré-cadastradas e 55 locais por província.',
                'ip_address' => '127.0.0.1',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'utilizador' => 'Carlos Alberto Mondlane',
                'acao'       => 'Consulta de Multas',
                'detalhes'   => 'Acesso à área do utente via Carta 10293847/MZ.',
                'ip_address' => '127.0.0.1',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour')),
            ],
            [
                'utilizador' => 'admin@inatro.gov.mz',
                'acao'       => 'Login de Administrador',
                'detalhes'   => 'Autenticação no painel de administração.',
                'ip_address' => '127.0.0.1',
                'created_at' => date('Y-m-d H:i:s', strtotime('-30 minutes')),
            ],
        ];
        $this->db->table('logs')->insertBatch($logs);
    }
}
