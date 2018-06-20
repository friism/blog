FROM php:fpm-alpine3.7 as base

RUN set -ex; \
	\
	apk add --no-cache --virtual .build-deps \
		libjpeg-turbo-dev \
		libpng-dev \
	; \
	\
	docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr; \
	docker-php-ext-install gd mysqli opcache; \
	\
	runDeps="$( \
		scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
			| tr ',' '\n' \
			| sort -u \
			| awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
	)"; \
	apk add --virtual .wordpress-phpexts-rundeps $runDeps; \
	apk del .build-deps

RUN apk --no-cache add mariadb-client

RUN { \
		echo 'opcache.memory_consumption=128'; \
		echo 'opcache.interned_strings_buffer=8'; \
		echo 'opcache.max_accelerated_files=4000'; \
		echo 'opcache.revalidate_freq=2'; \
		echo 'opcache.fast_shutdown=1'; \
		echo 'opcache.enable_cli=1'; \
	} > /usr/local/etc/php/conf.d/opcache-recommended.ini

# Add wp cli
RUN curl -o /usr/local/bin/wp -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
	chmod +x /usr/local/bin/wp

ENV WORDPRESS_VERSION 4.9.6
ENV WORDPRESS_SHA1 40616b40d120c97205e5852c03096115c2fca537

RUN set -ex; \
	curl -o wordpress.tar.gz -fSL "https://wordpress.org/wordpress-${WORDPRESS_VERSION}.tar.gz"; \
	echo "$WORDPRESS_SHA1 *wordpress.tar.gz" | sha1sum -c -; \
# upstream tarballs include ./wordpress/ so this gives us /var/www/wordpress
	tar -xzf wordpress.tar.gz -C /var/www/html --strip-components=1; \
	rm wordpress.tar.gz; \
	chown -R www-data:www-data /var/www/html

COPY init.sh /admin/init.sh
RUN chmod u+x /admin/init.sh

COPY uploads.ini /usr/local/etc/php/conf.d/uploads.ini

FROM base as dev

VOLUME [ "/var/www/html" ]

FROM base as prod

COPY wp-bootstrap-starter-child /var/www/html/wp-content/themes/wp-bootstrap-starter-child
VOLUME [ "/var/www/html" ]
