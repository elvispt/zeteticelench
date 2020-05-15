FROM php:7.4-apache
ADD vhost.conf /var/www/vhost.conf
ADD dev.sh /root/dev.sh
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        ssh \
        openssl \
        vim \
        libxml2-dev \
        zlib1g-dev \
        libpng-dev \
        libicu-dev \
        gnupg2 \
        libzip-dev \
        unzip \
        # for db backups
        default-mysql-client \
        # for mozjpeg: building from source
        build-essential cmake libtool autoconf automake m4 nasm \
    && docker-php-ext-install zip \
    && docker-php-ext-install opcache \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install bcmath \
    && echo "### OPCACHE CONFIGURATION. YOU SHOULD DISABLE OPCACHE ON DEV ENV ###" \
    && echo "opcache.max_accelerated_files=16229" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini \
    && echo "opcache.validate_timestamps=0" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini \
    && echo "opcache.revalidate_freq=0" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini \
    && echo "opcache.save_comments=1" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini \
    && echo "memory_limit=256M" >> /usr/local/etc/php/conf.d/zzz_custom.ini \
    && echo "### INSTALL COMPOSER (1.9.1) ###" \
    && php -r "copy('https://raw.githubusercontent.com/composer/getcomposer.org/6e5e46fc7cab0015d5961f54bb39be1f4b330093/web/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer \
    && echo "### INSTALL nodejs ###" \
    && curl -sL https://deb.nodesource.com/setup_10.x | bash - \
    && apt-get install -y nodejs \
    && echo "### ACTIVATE APACHE mod_rewrite ###" \
    && a2enmod rewrite \
    && echo "### ADD VHOST CONFIGURATION ###" \
    && mv /var/www/vhost.conf /etc/apache2/sites-enabled/000-default.conf \
    && echo "### CLEANUP ###" \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* \
    && echo -e "\e[92m\e[104m##################################################\e[49m\e[39m" \
    && echo -e "\e[92m\e[104m   If you are on dev, run script: /root/dev.sh    \e[49m\e[39m" \
    && echo -e "\e[92m\e[104m##################################################\e[49m\e[39m"
