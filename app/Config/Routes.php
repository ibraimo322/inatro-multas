<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --------------------------------------------------------------------
// ROTAS PÚBLICAS
// --------------------------------------------------------------------
$routes->get('/', 'Home::index');

// --------------------------------------------------------------------
// ROTAS DA ÁREA DO UTENTE / CONDUTOR
// --------------------------------------------------------------------
$routes->group('utente', function ($routes) {
    $routes->get('login', 'Utente::login');
    $routes->post('login', 'Utente::autenticar');
    $routes->get('dashboard', 'Utente::dashboard');
    $routes->get('multa/(:num)', 'Utente::multa/$1');
    $routes->get('pagar/(:num)', 'Utente::pagar/$1');
    $routes->post('confirmar', 'Utente::confirmar');
    $routes->post('processar-pagamento', 'Utente::processarPagamento');
    $routes->get('comprovativo/(:segment)', 'Utente::comprovativo/$1');
    $routes->get('gerar-pdf-pagamento/(:segment)', 'Utente::gerarPdfPagamento/$1');
    $routes->get('historico', 'Utente::historico');
    $routes->get('gerar-pdf-historico', 'Utente::gerarPdfHistorico');
    $routes->get('logout', 'Utente::logout');
});

// --------------------------------------------------------------------
// ROTAS DA ÁREA DO ADMINISTRADOR (/admin)
// --------------------------------------------------------------------
$routes->get('admin', 'Admin::login');
$routes->group('admin', function ($routes) {
    $routes->get('login', 'Admin::login');
    $routes->post('autenticar', 'Admin::autenticar');
    $routes->get('dashboard', 'Admin::dashboard');
    
    // Gestão de Utentes
    $routes->get('utentes', 'Admin::utentes');
    $routes->get('novo-utente', 'Admin::novoUtente');
    $routes->post('salvar-utente', 'Admin::salvarUtente');
    $routes->get('gerar-pdf-utente/(:num)', 'Admin::gerarPdfUtente/$1');

    // Gestão de Multas
    $routes->get('multas', 'Admin::multas');
    $routes->get('atribuir-multa', 'Admin::atribuirMulta');
    $routes->post('salvar-multa', 'Admin::salvarMulta');
    $routes->get('get-locais-por-provincia', 'Admin::getLocaisPorProvincia');
    $routes->post('alterar-estado-multa', 'Admin::alterarEstadoMulta');

    // Pagamentos e Transações
    $routes->get('pagamentos', 'Admin::pagamentos');
    $routes->get('transacoes', 'Admin::transacoes');
    $routes->get('historico', 'Admin::historico');
    $routes->get('gerar-pdf-historico', 'Admin::gerarPdfHistorico');
    $routes->get('gerar-pdf-pagamento/(:segment)', 'Admin::gerarPdfPagamento/$1');

    // Sistema e Relatórios
    $routes->get('relatorios', 'Admin::relatorios');
    $routes->get('logs', 'Admin::logs');
    $routes->get('configuracoes', 'Admin::configuracoes');
    $routes->get('logout', 'Admin::logout');
});
