FROM php:7.1-fpm

COPY php.ini /usr/local/etc/php/php.ini

RUN apt-get update && apt-get install -y \
    git \
    wget \
    unzip \
    libmcrypt-dev \
    libpng-dev \
    imagemagick \
    libmagick++-dev \
    libmagickwand-dev \
    vim \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && docker-php-ext-install opcache pdo intl pdo_mysql bcmath gd zip \
    && pecl install imagick  \
    && docker-php-ext-enable imagick opcache \
    && apt-get install libfontenc1 libxfont1 xfonts-75dpi xfonts-base xfonts-encodings xfonts-utils \
    # clean
    && apt-get clean

RUN usermod -u 1000 www-data

WORKDIR /var/www/sakh
