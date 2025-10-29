# Imagen base con PHP 8.2 y Apache
FROM php:8.2-apache

# Evitar prompts interactivos
ENV DEBIAN_FRONTEND=noninteractive
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instalar dependencias del sistema y extensiones PHP
RUN apt-get update && apt-get install -y \
    git unzip zip curl nodejs npm libpq-dev libzip-dev libxml2-dev && \
    docker-php-ext-install pdo pdo_pgsql zip xml

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar solo los archivos de dependencias primero para optimizar el caché de Docker
COPY composer.json composer.lock ./

# Copiar e instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar dependencias PHP.
# ¡IMPORTANTE! Se quitó --no-scripts y || true
# Si esto falla, NECESITAS ver el error.
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Copiar el resto de los archivos del proyecto
COPY . .

# Instalar dependencias frontend si existen package.json
# ¡IMPORTANTE! Se quitó || true
RUN if [ -f package.json ]; then \
        npm install && \
        npm run build; \
    fi

# Copia la configuración de Apache para que apunte a /public
# (Asegúrate de tener el archivo 'apache-config.conf' que te pasé)
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Habilita el módulo 'rewrite' de Apache (solo se necesita una vez)
RUN a2enmod rewrite

# Copiar .env.example. Render inyectará las variables reales.
RUN cp -n .env.example .env

# Generar clave y cachear configuración.
# Los '|| true' se quitan. Si esto falla, es porque
# faltan variables de entorno (como APP_KEY) en Render.
RUN php artisan key:generate --force
RUN php artisan config:cache
RUN php artisan route:cache

# Permisos para carpetas de almacenamiento
RUN chown -R www-data:www-data storage bootstrap/cache

# Exponer puerto 80
EXPOSE 80

# Comando de inicio
CMD ["apache2-foreground"]