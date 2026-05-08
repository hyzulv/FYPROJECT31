FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /opt/render/project/src

COPY fyproject31/ .

RUN cp .env.example .env && \
    composer install --no-dev --optimize-autoloader && \
    php artisan key:generate && \
    npm install && \
    npm run build && \
    php artisan storage:link

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000
