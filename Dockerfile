# Imagen base PHP 8.2 con Apache
FROM php:8.2-apache

# Instalar dependencias del sistema y extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libpq-dev libxml2-dev && \
    docker-php-ext-install pdo pdo_pgsql zip xml

# Habilitar mod_rewrite (necesario para rutas Laravel)
RUN a2enmod rewrite

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar todos los archivos del proyecto
COPY . /var/www/html

# Copiar e instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Generar la clave de aplicación de Laravel
RUN php artisan key:generate --force || true

# Establecer permisos correctos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exponer el puerto 80
EXPOSE 80

# Iniciar Apache
CMD ["apache2-foreground"]
