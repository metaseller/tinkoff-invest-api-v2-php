FROM composer:2.10.3 AS composer

FROM ghcr.io/shivammathur/extensions/grpc/8.5:1.84.0@sha256:cde35785af4014cf24adc2871a062f80ba60e27c27236a271d5c238bc5afb744 AS grpc

FROM php:8.5.12-cli-trixie

ARG BUILD_JOBS=4
RUN apt-get update \
    && apt-get install -y --no-install-recommends unzip \
    && docker-php-ext-install -j"${BUILD_JOBS}" bcmath \
    && rm -rf /var/lib/apt/lists/*
COPY --from=grpc /grpc@8.5/1.84.0/grpc.so /tmp/grpc.so
RUN mv /tmp/grpc.so "$(php-config --extension-dir)/grpc.so" \
    && docker-php-ext-enable grpc \
    && php --ri grpc

COPY --from=composer /usr/bin/composer /usr/local/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
WORKDIR /app
CMD ["sleep", "infinity"]
