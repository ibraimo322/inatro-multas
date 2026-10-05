# Sistema INATRO — Gestão e Pagamento Electrónico de Multas de Trânsito

Plataforma web institucional desenvolvida para o **INATRO (Instituto Nacional dos Transportes Rodoviários — Moçambique)**, destinada à consulta, emissão, controlo e liquidação eletrónica de multas de trânsito, emissão de comprovativos em PDF e administração centralizada de processos de contraordenação rodoviária.

---

## 🚀 Tecnologias Utilizadas

* **Linguagem:** PHP 8.2+
* **Framework Backend:** [CodeIgniter 4](https://codeigniter.com/) (v4.7+)
* **Padrão de Arquitetura:** MVC (Model-View-Controller)
* **Base de Dados:** SQLite3 (ou compatível com MySQL/PostgreSQL através de configuração no `.env`)
* **Geração de Documentos:** [Dompdf](https://github.com/dompdf/dompdf) (`dompdf/dompdf`)
* **Interface & Estilos:** HTML5, CSS3 personalizado (`public/assets/css/inatro.css`), [Bootstrap 5](https://getbootstrap.com/), [FontAwesome 6](https://fontawesome.com/) e Google Fonts (*Inter*).

---

## 📋 Funcionalidades Principais

### 1. Portal Público
* Apresentação dos serviços da instituição.
* Acesso rápido à consulta de infrações por condutores.
* Tabela informativa de sanções, enquadramento legal e canais de atendimento.

### 2. Área do Utente / Condutor (`/utente`)
* **Identificação segura:** Acesso mediante Número da Carta de Condução e Data de Nascimento.
* **Painel do Condutor:** Resumo de multas pendentes, pagas e regularizadas.
* **Pagamento Integrado:** Simulação de liquidação via M-Pesa, e-Mola, Ponto24 e Transferência Bancária.
* **Emissão de Comprovativos:** Download imediato de recibo e certificado de pagamento em PDF com carimbo digital.
* **Histórico Completo:** Consulta de infrações anteriores e relatórios em PDF.

### 3. Painel Administrativo (`/admin`)
* **Acesso Restrito:** Autenticação por credenciais com palavras-passe encriptadas (`password_hash`).
* **Dashboard Analítico:** Métricas de arrecadação, total de infrações ativas, taxa de liquidação e gráficos.
* **Gestão de Utentes:** Cadastro, consulta e emissão de ficha cadastral do condutor.
* **Atribuição de Multas:** Registo de autos de transgressão com seleção de artigos do Código da Estrada, localização geográfica por província e cálculo automático de valores.
* **Gestão Financeira:** Acompanhamento de transações e conciliação de pagamentos.
* **Auditoria & Segurança:** Registo detalhado de logs operacionais por utilizador e endereço IP.

---

## 🛠️ Requisitos de Sistema

Certifique-se de que o computador possui:
1. **PHP 8.2** ou superior.
2. Extensões PHP ativas no `php.ini`:
   * `extension=intl`
   * `extension=sqlite3`
   * `extension=pdo_sqlite`
   * `extension=mbstring`
   * `extension=curl`
   * `extension=gd`
   * `extension=openssl`
3. **Composer** instalado globalmente ([getcomposer.org](https://getcomposer.org/)).
4. **Git** ([git-scm.com](https://git-scm.com/)).

---

## ⚙️ Instalação Passo a Passo (Em Qualquer Computador)

### 1. Clonar o Repositório
```bash
git clone https://github.com/SEU_USUARIO/inatro.git
cd inatro
```

### 2. Instalar as Dependências via Composer
```bash
composer install
```

### 3. Configurar o Ficheiro de Ambiente
Copie o ficheiro `.env.example` para `.env`:
```bash
# No Windows (PowerShell / CMD):
copy .env.example .env

# No Linux / macOS:
cp .env.example .env
```
*(Caso queira rodar em outra porta ou alterar a URL base, edite o parâmetro `app.baseURL` dentro do `.env`)*.

### 4. Executar as Migrações e Alimentar a Base de Dados
Crie as tabelas e dados iniciais (utentes de teste, administrador padrão, catálogo de infrações e postos):
```bash
php spark migrate --all
php spark db:seed InatroSeeder
```

### 5. Iniciar o Servidor de Desenvolvimento
```bash
php spark serve --port 8081
```

Aceda à aplicação no navegador em:  
👉 **`http://localhost:8081/`**

---

## 🔑 Credenciais de Teste Pré-configuradas

### Acesso Administrativo (`http://localhost:8081/admin`)
* **E-mail:** `admin@inatro.gov.mz`
* **Palavra-passe:** `admin123`

### Acesso do Utente / Condutor (`http://localhost:8081/utente/login`)
| Condutor | N.º da Carta | Data de Nascimento | BI |
| :--- | :--- | :--- | :--- |
| **Carlos Alberto Mondlane** | `10293847/MZ` | `1988-04-15` | `110293847591B` |
| **Maria Helena Macamo** | `99887766/MZ` | `1992-09-20` | `110998877662C` |
| **Sérgio Fernando Tembe** | `55443322/MZ` | `1985-11-03` | `110554433224A` |

---

## 📂 Estrutura de Diretórios

```text
Inatro/
├── app/
│   ├── Config/              # Configurações do CodeIgniter (rotas, banco, filtros)
│   ├── Controllers/         # Home.php, Utente.php, Admin.php
│   ├── Database/
│   │   ├── Migrations/      # Estrutura das tabelas em código
│   │   └── Seeds/           # Povoamento inicial de testes
│   ├── Libraries/           # PdfService.php (geração Dompdf)
│   ├── Models/              # UtenteModel, MultaModel, PagamentoModel, etc.
│   └── Views/               # Telas do portal público, condutor, admin e PDFs
├── public/                  # Raiz pública do servidor Web
│   ├── assets/              # CSS customizado e imagens do sistema
│   ├── favicon.ico
│   ├── index.php            # Ponto de entrada (Front Controller)
│   └── robots.txt
├── writable/                # Armazenamento volátil local (sessões, cache, sqlite)
├── .env.example             # Modelo de variáveis de ambiente
├── .gitignore               # Regras de exclusão do Git
├── composer.json            # Dependências e pacotes PHP
├── spark                    # Utilitário CLI do CodeIgniter 4
└── README.md                # Documentação técnica do projeto
```

---

## 📄 Licença e Uso

Este projeto foi concebido para fins institucionais e educacionais de modernização de serviços públicos rodoviários.
Desenvolvido com o auxílio do Antigravity.
