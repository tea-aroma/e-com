# E-COM

## Installation

### Clone

```bash
git clone https://github.com/tea-aroma/e-com.git
```

```bash
cd e-com/
```

---

### Environment

Copy the example `.env` file:

```bash
cp .env.example .env
```

Update `.env` with your custom values.

#### Database

```dotenv
DB_CONNECTION=pgsql
DB_HOST=e_com_postgres
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

#### Cache & Queue (Redis)

```dotenv
QUEUE_CONNECTION=redis

CACHE_STORE=redis

REDIS_HOST=e_com_redis
```

---

### Docker

Build and start the containers:

```bash
docker compose up -d --build
```

Notice: Make sure Docker and Docker Compose are installed and running on your system.

---

### Laravel

Install dependencies:

```bash
docker compose exec app composer install
```

Generate the application key:

```bash
docker compose exec app php artisan key:generate
```

Run migrations:

```bash
docker compose exec app php artisan migrate
```

Run seeder:

```bash
docker compose exec app php artisan db:seed --class=DatabaseSeeder 
```

Now the project should be available at: http://localhost:8000

---

## API

### Available routes (V1)

| URL                | Description              |
|--------------------|--------------------------|
| `auth/register`    | Register a user          |
| `auth/login`       | User login               |
| `auth/logout`      | User logout              |
|                    |                          |
| `classifiers/list` | List classifiers         |
|                    |                          |
| `products/get`     | Get a product            |
| `products/list`    | List products            |
| `products/create`  | Create a product         |
|                    |                          |
| `cart/get`         | Get the cart             |
| `cart/products`    | List cart products       |
| `cart/append`      | Add product to cart      |
| `cart/delete`      | Remove product from cart |
| `cart/payment`     | Pay for the cart         |
|                    |                          |
| `orders/get`       | Get an order             |
| `orders/list`      | List orders              |
|                    |                          |
| `payment/accept`   | Accept payment           |
