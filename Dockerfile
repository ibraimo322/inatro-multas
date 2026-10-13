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

# Configurar o DocumentRoot do Apache para a pasta public/ do CodeIgniter 4
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Habilitar AllowOverride no diretório public para suporte a rotas amigáveis via .htaccess
RUN printf '<Directory /var/www/html/public>\n    Options -Indexes +FollowSymLinks\n    AllowOverride All\n    Require all granted\n</Directory>\n' >> /etc/apache2/apache2.conf

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
