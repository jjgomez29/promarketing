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

```bash
cp .env.example .env
docker-compose up -d --build
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate --seed
```

La app queda disponible en **http://localhost:8000**

### Servicios Docker

| Servicio | Imagen            | Puerto local |
|----------|-------------------|--------------|
| app      | php:8.4-fpm       | —            |
| nginx    | nginx:1.27-alpine | 8000         |
| db       | mysql:8.4         | 3306         |

### Comandos útiles

```bash
docker-compose exec app php artisan cache:clear      # limpiar cache
docker-compose exec app php artisan migrate          # correr migraciones
docker-compose exec app php artisan test             # correr tests
docker-compose exec app php artisan tinker           # REPL
docker-compose logs -f app                           # ver logs
docker-compose down -v                               # detener y borrar volúmenes
```

## Credentials

| Rol            | Email                          | Password |
|----------------|--------------------------------|----------|
| support-agent  | agent@promarketing.com         | 123456   |
| jugador        | carlos@promarketing.com        | 123456   |
| jugador        | laura@promarketing.com         | 123456   |
| jugador        | diego@promarketing.com         | 123456   |