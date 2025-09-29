# Imagen base con PHP y Composer
FROM php:8.2-apache

# Instala dependencias necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql

# Copiar composer desde la imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias con composer
RUN composer install --no-dev --optimize-autoloader

# Habilitar mod_rewrite (si es necesario)
RUN a2enmod rewrite

EXPOSE 80
CMD ["apache2-foreground"]
