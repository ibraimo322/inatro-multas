#!/bin/bash
set -e

# 1. Garantir que APENAS o módulo mpm_prefork está carregado (elimina AH00534: More than one MPM loaded)
rm -f /etc/apache2/mods-enabled/mpm_event.load /etc/apache2/mods-enabled/mpm_event.conf \
      /etc/apache2/mods-enabled/mpm_worker.load /etc/apache2/mods-enabled/mpm_worker.conf 2>/dev/null || true
a2enmod mpm_prefork 2>/dev/null || true
a2enmod rewrite 2>/dev/null || true

# 2. Configurar porta dinâmica caso definida pela plataforma (ex: Railway passa $PORT)
PORT="${PORT:-80}"
sed -i "s/Listen [0-9]*/Listen ${PORT}/g" /etc/apache2/ports.conf 2>/dev/null || true
sed -i "s/<VirtualHost \*:[0-9]*>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/000-default.conf 2>/dev/null || true

# 3. Garantir existência de todos os subdiretórios de writable
mkdir -p /var/www/html/writable/cache
mkdir -p /var/www/html/writable/logs
mkdir -p /var/www/html/writable/session
mkdir -p /var/www/html/writable/uploads
mkdir -p /var/www/html/writable/database

# 4. Se não existir .env, gerar um ficheiro com configurações adequadas de produção
if [ ! -f /var/www/html/.env ]; then
    echo "A gerar configuração de ambiente .env de produção..."
    BASE_URL="${APP_URL}"
    if [ -z "$BASE_URL" ] && [ -n "$RAILWAY_PUBLIC_DOMAIN" ]; then
        BASE_URL="https://${RAILWAY_PUBLIC_DOMAIN}/"
    fi

    cat <<EOF > /var/www/html/.env
CI_ENVIRONMENT = ${CI_ENVIRONMENT:-production}
app.baseURL = '${BASE_URL:-http://localhost:${PORT}/}'
app.forceGlobalSecureRequests = false
database.default.DBDriver = SQLite3
database.default.DBPrefix = ''
security.csrfProtection = 'cookie'
security.tokenRandomize = true
security.tokenName = 'csrf_token'
security.headerName = 'X-CSRF-TOKEN'
security.cookieName = 'csrf_cookie'
security.expires = 7200
security.regenerate = true
security.redirect = true
EOF
fi

# 5. Inicializar e atualizar a base de dados SQLite
DB_FILE="/var/www/html/writable/database/inatro_database.db"
if [ ! -f "$DB_FILE" ]; then
    echo "Base de dados SQLite não encontrada. A criar e a executar migrações + seeders..."
    touch "$DB_FILE"
    php spark migrate --all --force
    php spark db:seed InatroSeeder
    echo "Base de dados inicializada com sucesso!"
else
    echo "Base de dados encontrada. A verificar migrações pendentes..."
    php spark migrate --all --force
fi

# 6. Ajustar permissões para que o Apache consiga ler e escrever
chown -R www-data:www-data /var/www/html/writable
chmod -R 775 /var/www/html/writable

echo "Sistema INATRO configurado com sucesso! A iniciar Apache na porta ${PORT}..."
exec "$@"
