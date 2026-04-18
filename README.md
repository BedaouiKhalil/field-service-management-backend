# Field Service Management Backend

![Laravel](https://img.shields.io/badge/Laravel-10.x-red)
![PHP](https://img.shields.io/badge/PHP-%5E8.1-blue)
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

---

## ⚙️ Installation

### 1. Clone the repository  

```bash
   git clone https://github.com/BedaouiKhalil/field-service-management-backend.git  
   cd field-service-management-backend  
```

### 2. Install dependencies

```bash
   composer install  
   npm install && npm run dev  
```

### 3. Configure environment

```bash
   cp .env.example .env  
   php artisan key:generate 
```

### 4. Run migrations

```bash
   php artisan migrate --seed  
```

### 5. Start the server
1. PHP Server
```bash
   php artisan serve  
```

2. Asset Compilation (Vite)
```bash
   npm run dev 
```

---

## 🔑 Default Credentials

When you run the migrations and seeders, a default user is created:

- **Email:** [agent@gmail.com](mailto:agent@gmail.com)
- **Password:** `12345678`  
- **Role:** `support_agent`

---

## 🛠️ Development Workflow

- **main** → Stable production-ready code  
- **develop** → Active development branch  
- **feature/*** → Feature branches (merged into develop)  

### Example

git checkout develop  
git checkout -b feature/authentication  
git commit -m "Added authentication with Fortify"  
git push origin feature/authentication  

Then, create a Pull Request to merge into **develop**.

---

## 🎯 Exception Handling

The application implements a centralized exception handler that provides consistent JSON responses for API errors:

### Custom Exception Handler

The **App\Exceptions\Handler** class extends Laravel's base exception handler and provides:
Consistent JSON response format for API requests
Automatic logging of errors in production
Proper HTTP status codes for different exception types
Support for both web and API error handling

---

## 📜 License

This project is licensed under the MIT License - see the LICENSE.md file for details.
