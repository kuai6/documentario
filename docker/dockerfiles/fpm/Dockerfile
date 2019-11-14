FROM mileschou/phalcon:7.3-fpm

RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get -qq update && \
	apt-get clean && \
	pecl install -o ds && \
	echo "extension=ds.so" > /usr/local/etc/php/conf.d/ds.ini && \
	rm -r /var/lib/apt/lists/*

ENV WORKDIR="/srv/www"

WORKDIR $WORKDIR

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

EXPOSE 9000
CMD ["php-fpm"]