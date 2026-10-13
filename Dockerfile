FROM php:8.2-apache

# Instalar dependências do sistema e bibliotecas para extensões PHP
RUN apt-get update && apt-get install -y --no-install-recommends \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libsqlite3-dev \
    zip \
    unzip \
    git \
    dos2unix \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        intl \
        gd \
        zip \
        pdo_sqlite \
        opcache \
    && a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork \
    && a2enmod rewrite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Instalar Composer a partir da imagem oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar ficheiros de dependências primeiro (aproveita cache de build do Docker)
COPY composer.json composer.lock ./

# Instalar dependências sem pacotes de desenvolvimento
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copiar todo o código-fonte da aplicação
COPY . .

# Gerar autoload otimizado do Composer
RUN composer dump-autoload --optimize --no-dev

# Configurar VirtualHost do Apache para CodeIgniter 4 (DocumentRoot public/)
RUN printf '<VirtualHost *:80>\n\
    ServerAdmin webmaster@localhost\n\
    DocumentRoot /var/www/html/public\n\
\n\
    <Directory /var/www/html/public>\n\
        Options -Indexes +FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>\n' > /etc/apache2/sites-available/000-default.conf

# Criar estrutura de diretórios em writable/
RUN mkdir -p writable/cache writable/logs writable/session writable/uploads writable/database \
    && chown -R www-data:www-data writable \
    && chmod -R 775 writable

# Configurar script de inicialização do contentor
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN dos2unix /usr/local/bin/docker-entrypoint.sh \
    && chmod +x /usr/local/bin/docker-entrypoint.sh

# Porta padrão exposta
EXPOSE 80

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
