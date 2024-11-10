FROM php:8.3.6-fpm
ARG UID=1000
ARG GID=1000

# Install db complements.
RUN docker-php-ext-install pdo pdo_mysql

# Composer install
COPY --from=composer:2.7.7 /usr/bin/composer /usr/local/bin/composer

# Xdebug complements
RUN pecl install -o -f xdebug
COPY ./dockerfiles/php/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN docker-php-ext-enable xdebug

# Basic
WORKDIR /var/www/html
COPY . .
RUN addgroup --gid ${GID} laravel
RUN adduser --ingroup laravel --disabled-password --uid ${UID} laravel
