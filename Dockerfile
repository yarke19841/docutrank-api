FROM php:8.1-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libpq-dev \
    nodejs npm

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo pdo_pgsql zip

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

WORKDIR /var/www

# Copiar el código fuente
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction -vvv

# Compilar assets (si tienes React)
RUN npm install && npm run build || true

# Crear symlink de storage (ignora errores si ya existe)
RUN php artisan storage:link || true

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
