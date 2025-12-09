# Laravel Test

1. Install deps:

```sh
composer install
```

2. Setup database by copying `.env.example` and setting it.

3. Database migrations:

```sh
php artisan migrate:install
php artisan migrate
```

4. Running locally:

```sh
php artisan serve
```

## Screenshots

1. Create single:

![Create single](screenshots/create_single.png)

2. Create bulk:

![Create bulk](screenshots/create_bulk.png)

3. Get by ID:

![Get by ID](screenshots/get_by_id.png)

4. Get all:

![Get all](screenshots/get_all.png)

5. Update by ID:

![Update by ID](screenshots/update_by_id.png)

6. Delete by ID:

![Delete by ID](screenshots/delete_by_id.png)
