FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip gd bcmath

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node (required for Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Build frontend assets
RUN npm install && npm run build


# Create cache tables migration (skip sqlite error)
RUN php artisan cache:table 2>/dev/null || true && \
    php artisan session:table 2>/dev/null || true && \
    php artisan queue:table 2>/dev/null || true

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Create storage link
RUN php artisan storage:link

EXPOSE 8080

# Start Laravel without pre-clearing cache (will clear on first run)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]