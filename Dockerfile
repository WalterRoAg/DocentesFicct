# Imagen base con PHP 8.2 y Apache
FROM php:8.2-apache

# Evitar prompts interactivos
ENV DEBIAN_FRONTEND=noninteractive
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instalar dependencias del sistema y extensiones PHP
RUN apt-get update && apt-get install -y \
    git unzip zip curl nodejs npm libpq-dev libzip-dev libxml2-dev && \
    docker-php-ext-install pdo pdo_pgsql zip xml && \
    a2enmod rewrite

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar todos los archivos del proyecto
COPY . .

# Copiar e instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar dependencias PHP sin ejecutar scripts
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts || true

# Instalar dependencias frontend si existen package.json
RUN if [ -f package.json ]; then npm install && npm run build || true; fi

# Copiar archivo .env de ejemplo si no existe
RUN cp -n .env.example .env || true

# Generar clave de Laravel y cachear configuración
RUN php artisan key:generate --force || true
RUN php artisan config:cache || true
RUN php artisan route:cache || true

# Permisos para carpetas de almacenamiento
RUN chown -R www-data:www-data storage bootstrap/cache

# Exponer puerto 80
EXPOSE 80

# Comando de inicio
CMD ["apache2-foreground"]
