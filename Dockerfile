# Use the official PHP 8.3 with Apache base image
FROM php:8.3-apache

ARG user=appuser # Provide a default value
ARG uid=1000     # Provide a default value

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libjpeg-dev \
    libzip-dev \
    libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Enable Apache modules (mod_rewrite is essential for Laravel's clean URLs)
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create a non-root user
# --- FIX: Using explicit quotes for robust argument parsing ---
RUN useradd -u "$uid" -m -s "/bin/bash" -g www-data "$user"

# Set the working directory
WORKDIR /var/www/html

# Copy the Laravel application files
# This line is crucial for baking your code into the image.
COPY --chown=$user:www-data ./registry /var/www/html

# Set ownership of the Laravel storage and bootstrap/cache directories
# This is crucial for Laravel to write logs, cache, etc.
RUN chown -R $user:www-data /var/www/html/storage \
    && chown -R $user:www-data /var/www/html/bootstrap/cache

# Switch to the non-root user
USER "$user"

# Expose port 80 (Apache's default)
EXPOSE 80

# Apache is configured to start automatically by the php-apache image.
# No CMD is needed here as Apache is the primary process.