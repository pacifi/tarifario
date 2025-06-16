# Dockerfile
FROM php:8.2-fpm-alpine

# Instalar dependencias del sistema
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    postgresql-dev \
    oniguruma-dev \
    libxml2-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    nodejs \
    npm

# Instalar extensiones PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    zip \
    exif \
    pcntl \
    gd \
    bcmath

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de dependencias primero (para mejor cache de Docker)
COPY composer.json composer.lock ./
COPY package.json package-lock.json* ./

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copiar el código fuente
COPY . .

# Instalar dependencias Node.js (incluyendo devDependencies para el build)
RUN npm ci

# Compilar assets
RUN npm run build

# Configurar permisos
#RUN chown -R www-data:www-data /var/www/html \
#    && chmod -R 755 /var/www/html/storage \
#    && chmod -R 755 /var/www/html/bootstrap/cache

# Limpiar cache de composer y npm, remover node_modules
RUN composer clear-cache && npm cache clean --force && rm -rf node_modules

# Exponer puerto
EXPOSE 9000

# Comando por defecto
CMD ["php-fpm"]