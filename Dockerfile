FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip sqlite3

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd pdo_sqlite

RUN a2enmod rewrite

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Create SQLite database file and set permissions
RUN touch database/database.sqlite && \
    chmod 666 database/database.sqlite

# Copy .env.example to .env if not exists
RUN cp .env.example .env 2>/dev/null || true

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Generate app key (but Render will override with env var)
RUN php artisan key:generate --no-interaction

# Set wide permissions for storage and bootstrap cache
RUN chown -R www-data:www-data storage bootstrap/cache database && \
    chmod -R 775 storage bootstrap/cache database

USER www-data

EXPOSE 10000

CMD ["apache2-foreground"]
