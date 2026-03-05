FROM php:8.3-cli

# Install system dependencies + su-exec for privilege switching
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev libicu-dev libzip-dev \
    zip unzip sqlite3 libsqlite3-dev nodejs npm su-exec \
    && docker-php-ext-install pdo pdo_sqlite mbstring exif pcntl bcmath gd intl zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . /app
RUN cp .env.example .env \
    && composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist \
    && npm ci && npm run build \
    && mkdir -p database && touch database/database.sqlite

# Initial broad permissions (overridden at runtime)
RUN chmod -R 775 /app/storage /app/bootstrap/cache /app/database

EXPOSE 8080

# Improved startup script with runtime fixes
RUN echo '#!/bin/bash \
    set -e \n\ 
    echo "Starting Laravel..." \n\
    run_as_www() { \n\
    su-exec www-data:www-data "$@" \n\
    } \n\
    if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then\n\
    echo "Generating APP_KEY..."\n\
    run_as_www php artisan key:generate --force --no-interaction\n\
    fi\n\
    \n\
    echo "Running migrations..."\n\
    run_as_www php artisan migrate --force\n\
    echo "Seeding..."\n\
    run_as_www php artisan db:seed --force --class=DatabaseSeeder || echo "Seed skipped"\n\
    \n\
    echo "Caching..."\n\
    run_as_www php artisan config:cache\n\
    run_as_www php artisan route:cache\n\
    run_as_www php artisan view:cache\n\
    \n\
    echo "Fixing permissions..."\n\
    chown -R www-data:www-data /app/storage /app/bootstrap/cache /app/database\n\
    chmod -R 775 /app/storage /app/bootstrap/cache /app/database\n\
    \n\
    run_as_www php artisan storage:link\n\
    \n\
    echo "Server starting on port ${PORT:-8080}..."\n\
    exec run_as_www php artisan serve --host=0.0.0.0 --port=${PORT:-8080}\n\' > /app/start.sh && chmod +x /app/start.sh
RUN chmod +x /app/start.sh

CMD ["/app/start.sh"]
