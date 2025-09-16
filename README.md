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
- Blade templates for web interface
- RESTful API for mobile integration

---

## ⚙️ Installation
1. Clone the repository  
   git clone https://github.com/BedaouiKhalil/field-service-management-backend.git  
   cd field-service-management-backend  

2. Install dependencies  
   composer install  
   npm install && npm run dev  

3. Configure environment  
   cp .env.example .env  
   php artisan key:generate  

4. Run migrations  
   php artisan migrate --seed  

5. Start the server  
   php artisan serve  

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

## 📜 License
This project is licensed under the MIT License - see the LICENSE.md file for details.
