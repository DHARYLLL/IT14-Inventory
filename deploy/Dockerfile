# Use PHP 8.2 FPM image
FROM php:8.2-fpm

# Install system packages
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip nginx \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip gd bcmath

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application code
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Set correct permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 755 /var/www/public

# Create storage symlink
RUN php artisan storage:link || true

# Clear caches
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Copy Nginx config
COPY deploy/nginx.conf /etc/nginx/nginx.conf

# Expose port 80
EXPOSE 80

# Start PHP-FPM and Nginx in foreground
CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
