FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql mbstring zip bcmath curl xml fileinfo

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /opt/render/project/src

COPY fyproject31/ .

RUN touch database/database.sqlite

RUN echo "APP_NAME=Laravel" > .env && \
    echo "APP_ENV=production" >> .env && \
    echo "APP_KEY=" >> .env && \
    echo "APP_DEBUG=false" >> .env && \
    echo "APP_URL=http://localhost" >> .env && \
    echo "LOG_CHANNEL=stack" >> .env && \
    echo "LOG_LEVEL=warning" >> .env && \
    echo "DB_CONNECTION=sqlite" >> .env && \
    echo "SESSION_DRIVER=file" >> .env && \
    echo "CACHE_STORE=file" >> .env && \
    echo "QUEUE_CONNECTION=sync" >> .env

RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-req=ext-*

RUN php artisan key:generate

RUN npm install

RUN npm run build

RUN php artisan storage:link

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
