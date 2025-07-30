# Etapa 1: Base PHP con extensiones necesarias
FROM php:8.1-cli

# Instala dependencias necesarias
RUN apt-get update && apt-get install -y \
    git zip unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip bcmath

# Instala Composer 2
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia todos los archivos
COPY . .

# Copia .env.example como .env si no existe
RUN cp .env.example .env || true

# Instala dependencias PHP
RUN composer install --optimize-autoloader --no-interaction --no-progress --prefer-dist || true

# Genera la APP_KEY (evita que falle en el build con fallback)
RUN php artisan key:generate || echo "Fallback key used"

# Permisos (opcional, pero útil en producción)
RUN chmod -R 755 /var/www/storage

# Expone el puerto del servidor Laravel
EXPOSE 8000

# Comando por defecto
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
