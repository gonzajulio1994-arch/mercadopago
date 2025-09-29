# Usamos la imagen oficial de PHP con Apache
FROM php:8.1-apache

# Copiamos los archivos del proyecto al directorio de Apache
COPY . /var/www/html/

# Damos permisos
RUN chown -R www-data:www-data /var/www/html

# Exponemos el puerto 80 (para acceso web)
EXPOSE 80
