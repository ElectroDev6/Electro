FROM php:8.1-apache

# Cài các thư viện cần thiết
RUN apt-get update && apt-get install -y \
    default-libmysqlclient-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd \
    && a2enmod rewrite

# Copy source code vào container    
COPY . /var/www/html

# Trỏ DocumentRoot vào thư mục public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|DocumentRoot .*|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Phân quyền cho Apache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Đảm bảo Apache ưu tiên index.php
RUN echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf
