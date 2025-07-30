# Etapa 1: Construir el frontend (React)
FROM node:18 AS frontend-build
WORKDIR /app
COPY resources/frontend/package*.json ./resources/frontend/
RUN cd resources/frontend && npm install
COPY resources/frontend ./resources/frontend
RUN cd resources/frontend && npm run build

# Etapa 2: Backend Laravel
FROM composer:2.7 AS backend-build
WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Etapa 3: Imagen final con Apache + PHP 8.2
FROM php:8.2-apache

# Instalar extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev unzip libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo pdo_pgsql zip

# Copiar Laravel backend
COPY --from=backend-build /app /var/www/html

# Copiar frontend compilado al public/
COPY --from=frontend-build /app/resources/frontend/dist /var/www/html/public

# Establecer permisos y configuración de Apache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf

EXPOSE 80
