FROM php:7.2-fpm

RUN apt-get update
RUN apt-get install -y --no-install-recommends git zip unzip zlib1g-dev libicu-dev g++ make autoconf libc-dev pkg-config libmcrypt-dev libcurl4-openssl-dev libssl-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# mcrypt
RUN yes | pecl install mcrypt-1.0.1
RUN docker-php-ext-enable mcrypt

# Opcache
RUN docker-php-ext-install opcache

# mbstring
RUN docker-php-ext-install mbstring

# pdo_mysql
RUN docker-php-ext-install pdo_mysql

# intl
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

# xDebug
RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.profiler_enable_trigger = 1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.profiler_output_dir = /home/ovh/profiler" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN sed -i \
        -e 's/user = www-data/user = root/' \
        -e 's/group = www-data/group = root/' \
        /usr/local/etc/php-fpm.d/www.conf

CMD ["php-fpm", "-R"]