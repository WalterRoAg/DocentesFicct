# Imagen base con PHP 8.2 y Apache
FROM php:8.2-apache

# Evitar prompts interactivos
ENV DEBIAN_FRONTEND=noninteractive
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instalar dependencias del sistema y extensiones necesarias para Laravel + PostgreSQL
RUN apt-get update && apt-get install -y \
    git unzip zip curl nodejs npm libpq-dev libzip-dev libxml2-dev && \
    docker-php-ext-install pdo pdo_pgsql zip xml && \
    a2enmod rewrite && \
    rm -rf /var/lib/apt/lists/*

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de Composer primero (para usar caché en builds futuros)
COPY composer.json composer.lock ./

# Instalar dependencias PHP (sin ejecutar scripts para evitar fallos de artisan)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Copiar el resto del proyecto
COPY . .

# Construir frontend (si existe package.json)
RUN if [ -f package.json ]; then npm install && npm run build || true; fi

# Crear archivo .env si no existe
RUN cp -n .env.example .env || true

# Generar clave de Laravel y cachear configuración
RUN php artisan key:generate --force || true
RUN php artisan config:cache || true
RUN php artisan route:cache || true

# Establecer permisos adecuados para Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Puerto de Render
ENV PORT=8080
EXPOSE 8080

# Comando de inicio (usar php artisan serve)
CMD ["bash", "-lc", "php artisan serve --host=0.0.0.0 --port=${PORT}"]
