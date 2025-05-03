FROM php:8.1-apache

# Instalar dependencias esenciales
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libssl-dev \
    libcurl4-openssl-dev \
    libzip-dev

# Configurar Git
RUN git config --global --add safe.directory /var/www/html

# Instalar extensiones PHP necesarias
RUN pecl install mongodb && \
    docker-php-ext-enable mongodb && \
    docker-php-ext-install zip

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Configurar Apache
COPY docker/apache-config.conf /etc/apache2/sites-available/000-default.conf

# Definir directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos del proyecto
COPY . .

# Dar permisos a Apache
RUN chown -R www-data:www-data /var/www/html

# Exponer puerto 80
EXPOSE 80

# Script de entrada personalizado para instalar dependencias al iniciar
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Usar script como entrypoint
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]