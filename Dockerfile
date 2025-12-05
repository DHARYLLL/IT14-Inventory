FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip gd bcmath

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app files
COPY . .

# Install PHP dependencies (no dev dependencies for production)
RUN composer install --no-dev --optimize-autoloader

# Laravel setup and caching
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Create storage link (for PDF generation with dompdf)
RUN php artisan storage:link

# Expose port (Render uses port 8080 for Docker containers)
EXPOSE 8080

# Start Laravel with built-in server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]