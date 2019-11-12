FROM mileschou/phalcon:7.3-fpm

RUN docker-php-ext-install pdo pdo_mysql

ENV WORKDIR="/srv/www"

WORKDIR $WORKDIR


EXPOSE 9000
CMD ["php-fpm"]