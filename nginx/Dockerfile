FROM nginx:alpine

RUN rm /etc/nginx/conf.d/default.conf
COPY nginx.conf /etc/nginx/nginx.conf
COPY blog-no-ssl.conf /etc/nginx/conf.d/blog.conf
