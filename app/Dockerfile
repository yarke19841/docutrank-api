# Etapa 1: PHP + Composer + Node para compilar Laravel y React
FROM node:18-bullseye-slim as build

# Instalar PHP y extensiones
RUN apt-get update && apt-get install -y \
    php php-cli php-mbstring php-xml php-bcmath php-curl php-zip php-pgsql php-mysql php-tokenizer php-dom php-gd unzip curl git && \
    curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Crear carpeta del proyecto
WORKDIR /var/www

# Copiar todo el código
COPY . .

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Instalar dependencias de Node (React + Laravel Mix)
RUN npm install && npm run build

# Generar enlace de storage
RUN php artisan storage:link || true

# Etapa final: servidor PHP
FROM php:8.1-cli

RUN apt-get update && apt-get install -y unzip libpq-dev libzip-dev libxml2-dev && docker-php-ext-install pdo pdo_pgsql zip

WORKDIR /var/www

COPY --from=build /var/www /var/www

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
