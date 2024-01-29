FROM composer:latest

WORKDIR /var/www/iquest

RUN composer install

COPY composer.json .
COPY composer.lock .

FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    libicu-dev

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_pgsql zip && docker-php-ext-configure intl && docker-php-ext-install intl

WORKDIR /var/www/iquest

COPY . /var/www/iquest
