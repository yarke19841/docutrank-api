# Etapa 1: Construcción con Composer y Node
FROM php:8.1-cli as build

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip libpq-dev \
    nodejs npm

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Crear directorio del proyecto
WORKDIR /var/www

# Copiar el código fuente
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader || cat /var/www/storage/logs/laravel.log || true


# Instalar y construir assets con NPM (para React en resources/js)
RUN npm install && npm run build || true

# Generar storage link
RUN php artisan storage:link || true

# Etapa final: ejecutar Laravel
FROM php:8.1-cli

RUN apt-get update && apt-get install -y libzip-dev zip libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql zip

WORKDIR /var/www

COPY --from=build /var/www /var/www

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
