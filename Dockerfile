# Imagen base de PHP 8.2 con Apache y extensiones necesarias
FROM php:8.2-apache

# Instalar dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql

# Habilitar módulo de reescritura para Laravel
RUN a2enmod rewrite

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . /var/www/html

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Generar clave de Laravel
RUN php artisan key:generate --force || true

# Establecer permisos adecuados
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exponer el puerto 80
EXPOSE 80

# Comando de inicio (Apache)
CMD ["apache2-foreground"]
