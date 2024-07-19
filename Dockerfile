# Stage 1: Menggunakan image PHP versi 7.3 sebagai base image
FROM php:7.3 AS php_base

# Menjalankan perintah update dan install dependensi yang dibutuhkan
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip calendar

# Menyalin file aplikasi Laravel ke dalam container
COPY . /var/www/html

# Menetapkan working directory
WORKDIR /var/www/html

# Menginstall composer dan menjalankan perintah install
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependensi PHP menggunakan Composer
RUN composer install
RUN composer dump-autoload

# Stage 2: Menambahkan Node.js
FROM php_base AS final

# Installasi Node.js dan npm
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs

# Verifikasi versi Node.js dan npm
RUN node -v
RUN npm -v
RUN npm install
RUN npm run dev

# Menjalankan server PHP built-in ketika container dijalankan
CMD php artisan serve --host=0.0.0.0 --port=6001
