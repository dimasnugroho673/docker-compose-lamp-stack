FROM php:7.1.20-apache

# Fix the source.list for stretch
RUN printf "deb http://archive.debian.org/debian/ stretch main\n" > /etc/apt/sources.list && \
    printf "deb-src http://archive.debian.org/debian/ stretch main\n" >>  /etc/apt/sources.list && \
    printf "deb http://archive.debian.org/debian-security stretch/updates main\n" >>  /etc/apt/sources.list && \
    printf "deb-src http://archive.debian.org/debian-security stretch/updates main" >>  /etc/apt/sources.list

# Update package list
RUN apt-get update -o Acquire::Check-Valid-Until=false && \
    apt-get upgrade -y --allow-unauthenticated && \
    apt-get install -y --allow-unauthenticated \
        libapt-inst2.0 apt-utils nano wget dialog

# Install useful tools
RUN apt-get -y install apt-utils nano wget dialog --allow-unauthenticated

# Install important libraries
RUN apt-get -y install --fix-missing apt-utils build-essential git curl libcurl3 libcurl3-dev zip --allow-unauthenticated

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install xdebug
RUN pecl install xdebug-2.5.0
RUN docker-php-ext-enable xdebug

# Other PHP7 Extensions

RUN apt-get -y install libmcrypt-dev --allow-unauthenticated
RUN docker-php-ext-install mcrypt

RUN apt-get -y install libsqlite3-dev libsqlite3-0 mysql-client --allow-unauthenticated
RUN docker-php-ext-install pdo_mysql 
RUN docker-php-ext-install pdo_sqlite
RUN docker-php-ext-install mysqli

RUN docker-php-ext-install curl
RUN docker-php-ext-install tokenizer
RUN docker-php-ext-install json
RUN docker-php-ext-install bcmath

RUN apt-get -y install zlib1g-dev --allow-unauthenticated
RUN docker-php-ext-install zip

RUN apt-get -y install libicu-dev --allow-unauthenticated
RUN docker-php-ext-install -j$(nproc) intl

RUN docker-php-ext-install mbstring

RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev --allow-unauthenticated
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ 
RUN docker-php-ext-install -j$(nproc) gd

# Insure an SSL directory exists
RUN mkdir -p /etc/apache2/ssl

# Enable SSL support
RUN a2enmod ssl && a2enmod rewrite

# Enable apache modules
RUN a2enmod rewrite headers
