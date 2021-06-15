FROM bbereczky/php-grpc:8.0.5-fpm
RUN apt-get install make -y
COPY . .
RUN composer install
