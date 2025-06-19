FROM php:8.2-fpm

ARG user=laravel
ARG uid=1000

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libwebp-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP necesarias para PostgreSQL y Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    mbstring \
    xml \
    zip \
    exif \
    pcntl \
    gd \
    bcmath \
    intl

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar Node.js 20.x desde NodeSource (como root)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm@latest

# Crear usuario
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de dependencias primero (para mejor cache de Docker)
COPY --chown=$user:$user composer.json composer.lock ./
COPY --chown=$user:$user package.json package-lock.json* ./

# Cambiar a usuario no root
USER $user

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Instalar dependencias Node.js
RUN npm ci --only=production

# Copiar el código fuente
COPY --chown=$user:$user . .

# Compilar assets (cambiar temporalmente a instalar devDependencies)
RUN npm install && npm run build

# Limpiar dependencias de desarrollo y cache
RUN npm prune --production && \
    npm cache clean --force && \
    composer clear-cache

# Configurar permisos para directorios específicos de Laravel
USER root
RUN chown -R $user:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

USER $user

# Exponer puerto
EXPOSE 9000

# Comando por defecto
CMD ["php-fpm"]