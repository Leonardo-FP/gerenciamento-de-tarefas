FROM php:8.3-fpm

# Instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Definir o diretório de trabalho
WORKDIR /var/www

# Copiar apenas arquivos do Composer
COPY ./src/composer.* /var/www/

# Instalar dependências sem rodar scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copiar o restante do projeto
COPY ./src /var/www

# Rodar scripts agora que artisan existe
RUN php artisan package:discover --ansi

# Expor a porta 9000
EXPOSE 9000

# Rodar o PHP-FPM
CMD ["php-fpm"]