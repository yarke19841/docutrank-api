# Etapa 1: Construcción (con Composer y dependencias)
FROM composer:2.7 as build

WORKDIR /app

# Copia todos los archivos del proyecto
COPY . .

# Instala dependencias de producción
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Etapa 2: Servidor final con Apache y PHP 8.2
FROM php:8.2-apache

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev unzip libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Habilita mod_rewrite para Laravel
RUN a2enmod rewrite

# Copia archivos del build anterior
COPY --from=build /app /var/www/html

# Configura el DocumentRoot de Apache a /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf

# Establece permisos correctos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
