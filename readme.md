# Kampus Skeleton

Dipergunakan untuk Sample Rest API

# Cara Install

```bash
cp .env.example .env

composer install
```

Buat database

Menggunakan **MySQL**

```sql
DROP DATABASE IF EXISTS laravel_kampus;
CREATE DATABASE laravel_kampus
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;
```

Menggunakan **PostgreSQL**

```bash
su - postgres
createdb laravel_kampus
```

Migrasi Database

```bash
php artisan migrate --seed
```
