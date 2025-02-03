# Apache and PHP 8.3 Dockerfile
# Maintainer: <Your Name>

# Pull base image
FROM php:8.3-apache



# Install system dependencies

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    zip \
    unzip \
    default-mysql-client



# Install PHP extensions

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip curl intl

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
