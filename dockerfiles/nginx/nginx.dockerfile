FROM nginx:1.25.5-alpine

WORKDIR /etc/nginx/conf.d
COPY ./dockerfiles/nginx/nginx.default.conf .
RUN mv nginx.default.conf default.conf

WORKDIR /var/www/html
COPY . .
