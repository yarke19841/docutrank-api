# Usa imagen oficial de PHP 8.1 con extensiones necesarias
FROM php:8.1-cli

# Instala dependencias del sistema necesarias para Laravel y DomPDF
RUN apt-get update && apt-get install -y \
    unzip zip git curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establece directorio de trabajo
WORKDIR /var/www

# Copia el proyecto Laravel
COPY . .

# Copia el .env de ejemplo
RUN cp .env.example .env

# Instala dependencias de Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Genera la clave de Laravel
RUN php artisan key:generate

# Expone el puerto por defecto de Laravel
EXPOSE 8000

# Comando por defecto para iniciar Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
