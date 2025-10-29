# Imagen base PHP 8.2 con Apache
FROM php:8.2-apache

# Paquetes del sistema + extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libpq-dev libxml2-dev && \
    docker-php-ext-install pdo pdo_pgsql zip xml && \
    a2enmod rewrite

WORKDIR /var/www/html
COPY . /var/www/html

# Evitar warning de Composer como root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instalar Composer (sin ejecutar scripts de Laravel en build)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

# Asegurar que exista .env para que artisan lea variables
RUN cp -n .env.example .env || true

# Generar clave y optimizar (ahora sí, ya con vendor listo)
RUN php artisan key:generate --force || true

# Permisos para storage y cache
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80
CMD ["apache2-foreground"]
