FROM php:fpm-alpine as base

RUN set -ex; \
	\
	apk add --no-cache --virtual .build-deps \
		libjpeg-turbo-dev \
		libpng-dev \
	; \
	\
	docker-php-ext-configure gd --with-jpeg; \
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

ENV WORDPRESS_VERSION 6.5.2

RUN set -ex; \
	curl -o wordpress.tar.gz -fSL "https://wordpress.org/wordpress-${WORDPRESS_VERSION}.tar.gz"; \
	# upstream tarballs include ./wordpress/ so this gives us /var/www/wordpress
	tar -xzf wordpress.tar.gz -C /var/www/html --strip-components=1; \
	rm wordpress.tar.gz; \
	chown -R www-data:www-data /var/www/html; \
	rm -rf /var/www/html/wp-content/themes/*; \
	rm -f /var/www/html/wp-content/plugins/hello.php

COPY init.sh /admin/init.sh
RUN chmod u+x /admin/init.sh
COPY wipe-posts.sh /admin/wipe-posts.sh
RUN chmod u+x /admin/wipe-posts.sh

COPY uploads.ini /usr/local/etc/php/conf.d/uploads.ini
COPY zzz_blog.conf /usr/local/etc/php-fpm.d/zzz_blog.conf

USER www-data
RUN mkdir -p /var/www/html/wp-content/uploads

VOLUME [ "/var/www/html" ]

ENTRYPOINT /admin/init.sh && php-fpm

FROM base as dev

FROM base as prod

COPY friism /var/www/html/wp-content/themes/friism
