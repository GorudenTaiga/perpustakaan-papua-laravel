FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite mbstring exif pcntl bcmath gd intl zip

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy application files
COPY . /app

# Create .env from .env.example
RUN cp .env.example .env

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Install NPM dependencies and build assets
RUN npm ci && npm run build

# Create SQLite database
RUN mkdir -p /app/database && touch /app/database/database.sqlite

# Set permissions
RUN chmod -R 775 /app/storage /app/bootstrap/cache /app/database

# Expose port
EXPOSE 8080

# Create startup script
RUN echo '#!/bin/bash\n\
set -e\n\
\n\
echo "Starting Laravel application..."\n\
\n\
# Generate APP_KEY if not set\n\
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then\n\
    echo "Generating APP_KEY..."\n\
    php artisan key:generate --force --no-interaction\n\
else\n\
    echo "APP_KEY already set from environment"\n\
fi\n\
\n\
# Run migrations\n\
echo "Running migrations..."\n\
php artisan migrate --force\n\
\n\
# Seed database (create admin user)\n\
echo "Seeding database..."\n\
php artisan db:seed --force --class=DatabaseSeeder || echo "Seeding failed, continuing..."\n\
\n\
# Cache config\n\
echo "Caching configuration..."\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
\n\
# Start server\n\
echo "Starting web server on port ${PORT:-8080}..."\n\
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}\n\
' > /app/start.sh && chmod +x /app/start.sh

# Start application
CMD ["/app/start.sh"]
