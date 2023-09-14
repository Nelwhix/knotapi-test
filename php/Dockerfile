FROM php:8.2-fpm-alpine

RUN mkdir -p /var/www/html

RUN delgroup dialout

RUN sed -i "s/user = www-data/user = root/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = root/g" /usr/local/etc/php-fpm.d/www.conf

USER root

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]