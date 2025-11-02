FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Set working directory
WORKDIR /var/www

# Copy existing application code
COPY . /var/www

# Copy composer if needed
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install PHP dependencies (optional)
# RUN composer install --no-dev --optimize-autoloader

# Expose FPM port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
