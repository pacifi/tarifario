#!/bin/bash

# Script de deployment para Laravel con Docker
# Uso: ./deploy.sh [--build]

set -e

echo "🚀 Iniciando deployment de Laravel..."

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Verificar si Docker está corriendo
if ! docker info > /dev/null 2>&1; then
    echo -e "${RED}❌ Docker no está corriendo${NC}"
    exit 1
fi

# Verificar si existe .env.production
if [ ! -f .env.production ]; then
    echo -e "${RED}❌ Archivo .env.production no encontrado${NC}"
    echo "Crea el archivo .env.production y luego será copiado como .env"
    exit 1
fi

# Copiar archivo de environment (Laravel siempre usa .env)
echo -e "${YELLOW}📋 Copiando .env.production como .env...${NC}"
cp .env.production .env

# Generar APP_KEY si no existe
if ! grep -q "APP_KEY=base64:" .env; then
    echo -e "${YELLOW}🔑 Generando APP_KEY...${NC}"
    docker run --rm -v $(pwd):/app -w /app php:8.2-cli php artisan key:generate
fi

# Build y start de containers
if [ "$1" == "--build" ]; then
    echo -e "${YELLOW}🏗️  Construyendo imágenes...${NC}"
    docker compose down
    docker compose build --no-cache
else
    echo -e "${YELLOW}🏗️  Iniciando containers...${NC}"
    docker compose down
    docker compose pull
fi

# Crear directorios necesarios
mkdir -p docker/nginx/conf.d

# Iniciar containers
echo -e "${YELLOW}🚀 Levantando containers...${NC}"
docker compose up -d

# Esperar a que la base de datos esté lista
echo -e "${YELLOW}⏳ Esperando a que la base de datos esté lista...${NC}"
sleep 10

# Ejecutar migraciones
echo -e "${YELLOW}🗄️  Ejecutando migraciones...${NC}"
docker compose exec app php artisan migrate --force

# Limpiar y optimizar cache
echo -e "${YELLOW}🧹 Optimizando aplicación...${NC}"
docker compose exec app php artisan optimize:clear
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache

# Verificar estado de containers
echo -e "${YELLOW}📊 Estado de containers:${NC}"
docker compose ps

# Verificar conectividad
echo -e "${YELLOW}🔍 Verificando conectividad...${NC}"
sleep 5
if curl -f http://localhost:9095/health > /dev/null 2>&1; then
    echo -e "${GREEN}✅ Aplicación desplegada correctamente en http://localhost:9095${NC}"
else
    echo -e "${RED}❌ Error: La aplicación no responde${NC}"
    echo "Revisa los logs con: docker compose logs"
    exit 1
fi

echo -e "${GREEN}🎉 Deployment completado exitosamente!${NC}"
echo -e "${GREEN}🌐 Aplicación disponible en: http://localhost:9095${NC}"
echo -e "${YELLOW}📋 Comandos útiles:${NC}"
echo "  - Ver logs: docker compose logs -f"
echo "  - Entrar al container: docker compose exec app bash"
echo "  - Parar aplicación: docker compose down"
echo "  - Reiniciar: docker compose restart"