FROM php:8.3.10-fpm

# Install system dependencies and PostgreSQL extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd sockets \
    && docker-php-ext-configure pgsql --with-pgsql=/usr/local/pgsql

# Set proper permissions for the web server
RUN usermod -u 1000 www-data

# Set the working directory to /var/www
WORKDIR /var/www

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Redis extension
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# Switch to the www-data user
USER www-data

# Expose port 9000 for PHP-FPM
EXPOSE 9000
