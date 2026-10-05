<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Portal de Gestão e Pagamento Electrónico de Multas — INATRO',
        ];
        return view('public/index', $data);
    }
}
