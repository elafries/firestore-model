FROM bbereczky/php-grpc:7.4-fpm
COPY . .
RUN composer install
