FROM php:8.2-apache

# Install required system packages
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libsqlite3-dev \
    && docker-php-ext-install pdo_mysql mbstring pdo_sqlite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set DocumentRoot to Laravel's public directory
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application files
COPY . .

# Create SQLite database file and set permissions
RUN touch database/database.sqlite && chmod 666 database/database.sqlite

# Copy .env.example to .env if missing
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Generate application key
RUN php artisan key:generate --no-interaction

# Set proper permissions
RUN chown -R www-data:www-data storage bootstrap/cache database && \
    chmod -R 775 storage bootstrap/cache database

# Switch to non-root user
USER www-data

EXPOSE 10000

CMD ["apache2-foreground"]

