FROM php:fpm-alpine3.7

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

ENV WORDPRESS_VERSION 4.9.4
ENV WORDPRESS_SHA1 0e630bf940fd586b10e099cd9195b3e825fb194c

RUN set -ex; \
	curl -o wordpress.tar.gz -fSL "https://wordpress.org/wordpress-${WORDPRESS_VERSION}.tar.gz"; \
	echo "$WORDPRESS_SHA1 *wordpress.tar.gz" | sha1sum -c -; \
# upstream tarballs include ./wordpress/ so this gives us /var/www/wordpress
	tar -xzf wordpress.tar.gz -C /var/www/html --strip-components=1; \
	rm wordpress.tar.gz; \
	chown -R www-data:www-data /var/www/html

RUN { \ 
	echo '<IfModule mod_rewrite.c>'; \
	echo 'RewriteEngine On'; \
	echo 'RewriteBase /'; \
	echo 'RewriteRule ^index\.php$ - [L]'; \
	echo 'RewriteCond %{REQUEST_FILENAME} !-f'; \
	echo 'RewriteCond %{REQUEST_FILENAME} !-d'; \
	echo 'RewriteRule . /index.php [L]'; \
	echo '</IfModule>'; \
	} > .htaccess
RUN chown www-data:www-data .htaccess

VOLUME [ "/var/www/html" ]

CMD ["php-fpm"]
