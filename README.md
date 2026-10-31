# Field Service Management Backend

![Laravel](https://img.shields.io/badge/Laravel-10.x-red)
![PHP](https://img.shields.io/badge/PHP-%5E8.2-blue)
![Docker](https://img.shields.io/badge/Docker-ready-2496ED)
![License](https://img.shields.io/badge/License-MIT-green)
![Status](https://img.shields.io/badge/Status-Active-success)

This is the backend of the **Field Service Management Platform**, built with **Laravel 10**, **Fortify**, **Sanctum**, and **Spatie Laravel Permission**.  
It provides authentication, authorization, and APIs to support both the web interface (Blade) and future mobile applications.

---

## 🚀 Features

- Laravel 10 framework
- Authentication with **Fortify**
- API authentication with **Sanctum**
- Role & Permission management using **Spatie Laravel Permission**
- Admin dashboard integrated with **AdminKit (Bootstrap 5)**
- Blade templates for web interface
- RESTful API for mobile integration

---

## 🏗️ Advanced Architecture Features

- **Full Audit Trail:** Every change to critical data (like Customers) is tracked using `owen-it/laravel-auditing`, including user ID and old/new values.
- **Centralized API Response Pattern:** Unified JSON response structure via `ApiResponse` helper for seamless Mobile/Frontend integration.
- **Robust Exception Handling:** Custom `Handler` to catch and format API errors (Validation, Auth, 404) into consistent JSON payloads.
- **Strict Typing with Constants:** Roles and Permissions managed via dedicated Constant classes to eliminate magic strings and ensure type safety.
- **Automated Data Seeding:** Heavy datasets (Wilayas/Communes) managed via JSON-driven seeders for clean and fast database initialization.
- **Service Layer Pattern:** Business logic is decoupled from controllers using dedicated Service classes (`UserService`), promoting reusability and cleaner code.
- **Atomic Transactions:** Database operations are wrapped in SQL transactions to ensure data consistency during complex store/update processes.
- **Custom Blade Components:** UI elements like role selectors are encapsulated into reusable components for a DRY (Don't Repeat Yourself) frontend.

---

## ⚙️ Installation (Docker)

### Prerequisites

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (includes Docker Compose)
- Git

No local PHP, Composer, Node or MySQL installation is required: everything runs in containers.

> If you use Laragon or XAMPP, stop it first to avoid port conflicts.

### 1. Clone the repository

```bash
git clone https://github.com/BedaouiKhalil/field-service-management-backend.git
cd field-service-management-backend
```

### 2. Configure environment

```bash
cp .env.example .env
```

On Windows (CMD): `copy .env.example .env`

The default values in `.env.example` already match the Docker setup (`DB_HOST=db`).

### 3. Build and start the containers

```bash
docker compose up -d --build
```

The first build takes a few minutes. Wait about 20 seconds afterwards so MySQL can initialize.

### 4. Install PHP dependencies

```bash
docker compose exec app composer install
```

### 5. Generate the application key

```bash
docker compose exec app php artisan key:generate
```

### 6. Run migrations and seeders

```bash
docker compose exec app php artisan migrate --seed
```

### 7. Open the application

- Application: http://localhost:8080/login
- Vite dev server: http://localhost:5173 (started automatically)

Frontend dependencies are installed and `npm run dev` is started automatically by the `node` container.

---

## 🐳 Docker Services

| Service | Role | Access |
|---|---|---|
| `nginx` | Web server | http://localhost:8080 |
| `app` | PHP-FPM + Laravel | internal (port 9000) |
| `db` | MySQL 8 | `127.0.0.1:3307` |
| `node` | Vite dev server (hot reload) | http://localhost:5173 |

## 💻 Daily Commands

```bash
docker compose up -d      # start everything
docker compose stop       # stop (data is kept)
docker compose ps         # check container status
docker compose logs -f app   # follow PHP logs
```

Run Laravel and Composer commands **inside the container**:

```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan make:model Example
docker compose exec app composer require vendor/package
docker compose exec node npm install package-name
```

Or open a shell once: `docker compose exec app bash`

> Do not run `npm install` or `composer install` from the host machine: it would overwrite the Linux binaries in `node_modules/`.

## 🗄️ Database Access

Connect with any SQL client (HeidiSQL, DBeaver, TablePlus):

| Field | Value |
|---|---|
| Host | `127.0.0.1` |
| Port | `3307` |
| User | `root` |
| Password | `secret` |
| Database | `p_field_service_management` |

These credentials are for **local development only**.

> `docker compose down` keeps the database. `docker compose down -v` **deletes it**.

## 🧰 Troubleshooting

| Problem | Solution |
|---|---|
| `Cannot connect to the Docker daemon` | Start Docker Desktop |
| `port is already allocated` | Stop the program using the port (Laragon, another project) |
| `Connection refused` to the database | Wait ~20 seconds for MySQL, then retry |
| `Access denied for user 'root'` | Check that `.env` has a single `DB_PASSWORD=secret` and run `php artisan config:clear` |
| 404 on `/` | Use `/login` |
| `vendor/autoload.php` not found | Run `docker compose exec app composer install` |
| Permission denied on `storage/` | `docker compose exec app chmod -R 777 storage bootstrap/cache` (dev only) |

## 🚢 Production

The same `Dockerfile` is used for development and production (multi-stage build):

- Development: `target: dev` in `docker-compose.yml`
- Production: `target: prod` and `target: nginx-prod` in `docker-compose.prod.yml`

In production the code is baked into the image. The `.env.production` file and all secrets are provided by the server or the CI/CD pipeline and are **never committed**.

---

## 🔑 Default Credentials

When you run the migrations and seeders, a default user is created:

- **Email:** [agent@gmail.com](mailto:agent@gmail.com)
- **Password:** `12345678`  
- **Role:** `support_agent`

> These credentials exist only in local development. They must never be created in production.

---

## 🛠️ Development Workflow

- **main** → Stable production-ready code  
- **develop** → Active development branch  
- **feature/*** → Feature branches (merged into develop)  

### Example

```bash
git checkout develop
git checkout -b feature/authentication
git commit -m "Added authentication with Fortify"
git push origin feature/authentication
```

Then, create a Pull Request to merge into **develop**.

---

## 🎯 Exception Handling

The application implements a centralized exception handler that provides consistent JSON responses for API errors:

### Custom Exception Handler

The **App\Exceptions\Handler** class extends Laravel's base exception handler and provides:

- Consistent JSON response format for API requests
- Automatic logging of errors in production
- Proper HTTP status codes for different exception types
- Support for both web and API error handling

---

## 📜 License

This project is licensed under the MIT License - see the LICENSE.md file for details.
