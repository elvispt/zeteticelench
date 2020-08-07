#!/usr/bin/env bash

info() {
  echo -e "\e[92m\e[104m$1\e[49m\e[39m";
}
separator() {
  info "##################################################";
}

separator
info "Setting container to development mode"
info " - Install Xdebug"
info " - Disable Opcache"

pecl install xdebug-2.8.0
docker-php-ext-enable xdebug
mv /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini.BAK
service apache2 reload

info " - Xdebug installed and enabled"
info " - Opcache disabled"
separator
