FROM ubuntu:22.04

# Install PHP, Nginx, Supervisor
RUN apt-get update && apt-get install -y \
    php8.2 php8.2-fpm php8.2-mbstring php8.2-xml php8.2-zip php8.2-mysql \
    nginx supervisor curl git unzip \
    && mkdir -p /run/php

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy Laravel app
COPY . .

RUN composer install --no-dev --optimize-autoloader

# Setup Laravel permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# Copy Nginx config
COPY ./deploy/nginx.conf /etc/nginx/sites-available/default

# Supervisor config to run PHP-FPM + Nginx together
COPY ./deploy/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-n"]
