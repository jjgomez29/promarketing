# Player Notes Module – Prueba Técnica

## Descripción

Prueba Técnica: Se requiere implementar un nuevo módulo para que los agentes de soporte puedan dejar notas internas sobre los jugadores.

## Stack
- **Laravel 13** (PHP 8.5)
- **Livewire 4** (single-file components)
- **Spatie Laravel Permission 8**
- **MySQL 8.4** (vía Docker)
- **SQLite** (tests unitarios con `RefreshDatabase`)

## Setup con Docker (recomendado)

### Requisitos
- Docker
- Docker Compose

### Pasos para el despliegue

```bash
# 1. Clonar el repositorio
git clone <url-del-repo>
cd promarketing

# 2. Copiar archivo de entorno
cp .env.example .env

# 3. Construir y levantar contenedores
docker compose up -d --build

# 4. Instalar dependencias de PHP
docker compose exec app composer install

# 5. Generar key de aplicacion
docker compose exec app php artisan key:generate

# 6. Ejecutar migraciones y seeders
docker compose exec app php artisan migrate --seed
```

La app queda disponible en **http://localhost:8000**

### Servicios Docker

| Servicio | Imagen            | Puerto | Descripcion                    |
|----------|-------------------|--------|--------------------------------|
| app      | php:8.4-fpm       | 9000   | PHP-FPM                        |
| nginx    | nginx:1.27-alpine | 8000   | Servidor web                   |
| db       | mysql:8.4         | 3306   | Base de datos                  |
| node     | node:20-alpine    | —      | Compila assets (CSS/JS)        |

### Comandos utiles

```bash
docker compose exec app php artisan cache:clear      # limpiar cache
docker compose exec app php artisan migrate          # correr migraciones
docker compose exec app php artisan test             # correr tests
docker compose exec app php artisan tinker           # REPL
docker compose logs -f app                           # ver logs
docker compose logs node                             # ver compilacion de assets
docker compose down                                  # detener contenedores
docker compose down -v                               # detener y borrar volumenes
```

### Recompilar assets manualmente

```bash
docker compose run --rm node npm run build
```

## Credentials

| Rol            | Email                          | Password |
|----------------|--------------------------------|----------|
| support-agent  | agent@promarketing.com         | 123456   |
| jugador        | carlos@promarketing.com        | 123456   |
| jugador        | laura@promarketing.com         | 123456   |
| jugador        | diego@promarketing.com         | 123456   |