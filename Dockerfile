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

RUN touch database/database.sqlite

RUN cp .env.example .env && \
    php -r "
        \$env = file_get_contents('.env');
        \$env = preg_replace('/^APP_ENV=.*/m', 'APP_ENV=production', \$env);
        \$env = preg_replace('/^APP_DEBUG=.*/m', 'APP_DEBUG=false', \$env);
        \$env = preg_replace('/^SESSION_DRIVER=.*/m', 'SESSION_DRIVER=file', \$env);
        \$env = preg_replace('/^CACHE_STORE=.*/m', 'CACHE_STORE=file', \$env);
        \$env = preg_replace('/^QUEUE_CONNECTION=.*/m', 'QUEUE_CONNECTION=sync', \$env);
        file_put_contents('.env', \$env);
    "

RUN php artisan key:generate

RUN composer install --no-dev --optimize-autoloader

RUN npm install

RUN npm run build

RUN php artisan storage:link

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000
