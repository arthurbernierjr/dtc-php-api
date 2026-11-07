FROM php:8.4-cli-bookworm
RUN apt-get update \
 && apt-get install -y --no-install-recommends libpq-dev unzip git curl \
 && docker-php-ext-install pdo_pgsql \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
 && rm -rf /var/lib/apt/lists/*
WORKDIR /app
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer create-project laravel/laravel:13.11.0 . --no-interaction --prefer-dist --no-dev \
 && php artisan install:api --no-interaction
COPY overlay/ ./
COPY boot /usr/local/bin/boot
RUN chmod +x /usr/local/bin/boot
EXPOSE 8080
CMD ["boot"]
