FROM nginx:alpine as base

RUN rm /etc/nginx/conf.d/default.conf
COPY nginx.conf /etc/nginx/nginx.conf
RUN mkdir -p /run/php-sock
RUN chmod 777 /run/php-sock

FROM base as dev

COPY blog-no-ssl.conf /etc/nginx/conf.d/blog.conf

FROM base as prod

COPY blog.conf /etc/nginx/conf.d/blog.conf
