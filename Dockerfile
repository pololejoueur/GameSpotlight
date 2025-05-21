# Dockerfile
FROM php:8.4-fpm

# Install system dependencies + pdo_mysql
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip libonig-dev \
    libpng-dev libjpeg-dev libfreetype6-dev libxml2-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install pdo pdo_mysql gd zip opcache

# Enable OPcache
COPY docker/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app sources
COPY . .

# Install PHP deps & fix permissions
RUN composer install --optimize-autoloader \
 && chown -R www-data:www-data /var/www

USER www-data

CMD ["php-fpm"]
