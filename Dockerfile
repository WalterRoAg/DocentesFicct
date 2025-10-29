# Imagen base PHP 8.2 con extensiones necesarias
FROM php:8.2-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev && docker-php-ext-install pdo pdo_pgsql

# Copiar los archivos del proyecto
COPY . /var/www/html

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Generar clave de Laravel
RUN php artisan key:generate --force || true

# Exponer el puerto
EXPOSE 80

# Comando de inicio
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
