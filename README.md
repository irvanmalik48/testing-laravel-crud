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
![Create single (form data)](screenshots/create_single_formdata.png)

2. Create bulk:

![Create bulk](screenshots/create_bulk.png)
![Create bulk (form data)](screenshots/create_bulk_formdata.png)

3. Get by ID:

![Get by ID](screenshots/get_by_id.png)

4. Get all:

![Get all](screenshots/get_all.png)

5. Update by ID:

![Update by ID](screenshots/update_by_id.png)
![Update by ID (form data)](screenshots/update_by_id_formdata.png)

6. Delete by ID:

![Delete by ID](screenshots/delete_by_id.png)
