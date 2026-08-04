FROM php:8.2-apache

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Instalar extension de MySQL para PHP
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copiar todo el proyecto al servidor
COPY . /var/www/html/

# Configurar el directorio publico como raiz
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Dar permisos correctos
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto 80
EXPOSE 80