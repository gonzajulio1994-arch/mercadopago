# Imagen con PHP 8.2 y Apache
FROM php:8.2-apache

WORKDIR /var/www/html

# Instalar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Copiar proyecto
COPY . /var/www/html

# Instalar composer dentro del contenedor
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Puerto expuesto
EXPOSE 10000

# Levantar servidor PHP embebido
CMD ["php", "-S", "0.0.0.0:10000", "-t", "/var/www/html"]
