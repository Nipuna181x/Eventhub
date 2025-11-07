# 🎟️ EventHub - Event Management System (Laravel)

EventHub is a simple event management web application built with **Laravel 12**.  
It allows **Admins** to create, edit, and delete events, while **Users** can view events and RSVP to participate.

---

## 🚀 Features

- **Role-Based Access**
    - 👨‍💼 Admin: Create, edit, and delete events.
    - 🙋‍♂️ User: View and RSVP to events.
- **Authentication** using Laravel Breeze.
- **CRUD operations** for events.
- **Modern UI** styled with Tailwind CSS.
- **Validation & Authorization** through Form Requests and Middleware.

---

## 🧱 Tech Stack

| Layer           | Technology               |
|-----------------|--------------------------|
| Backend         | Laravel 12 (PHP 8.2+)   |
| Frontend        | Blade + Tailwind CSS     |
| Database        | MySQL                    |
| Authentication  | Laravel Breeze           |
| Version Control | Git + GitHub             |

---

## ⚙️ Installation Guide

Follow these steps to set up **EventHub** locally.

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/Nipuna181x/EventHub.git
cd EventHub
```

### 2️⃣ Install Dependencies

```bash
composer install
npm install
npm run build
```

### 3️⃣ Configure Environment

Copy the example environment file:

```bash
cp .env.example .env
```

Then update your .env file with database credentials:

```
APP_NAME=EventHub
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eventhub
DB_USERNAME=root
DB_PASSWORD=
```

Generate the application key:

```bash
php artisan key:generate
```

#### 🗄️ Database Setup

Run migrations to create all necessary tables:

```bash
php artisan migrate
```

(Optional) You can seed admin and user accounts:

```bash
php artisan tinker
```

Then inside Tinker:

```php
use App\Models\User;

User::create([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('password'),
        'role' => 'admin'
]);

User::create([
        'name' => 'User',
        'email' => 'user@gmail.com',
        'password' => bcrypt('password'),
        'role' => 'user'
]);
```

### 🧩 Running the Application

Start the local development servers:

```bash
php artisan serve
npm run dev
```

Then open your browser at:

👉 http://localhost:8000

---

## 🔑 User Roles Summary

| Role  | Access Permissions                 |
|-------|-----------------------------------|
| Admin | Create, Edit, Delete events       |
| User  | View and RSVP for events          |

---

## 🗂️ Project Structure Overview

```
EventHub/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── EventController.php
│   │   └── Requests/
│   │       └── StoreEventRequest.php
│   └── Models/
│       └── Event.php
│
├── database/
│   └── migrations/
│
├── resources/
│   └── views/
│       └── events/
│           ├── index.blade.php
│           ├── show.blade.php
│           ├── create.blade.php
│           └── edit.blade.php
│
├── routes/
│   └── web.php
│
├── public/
│
├── package.json
├── composer.json
└── README.md
```

---

## 🧠 Development Notes

Authentication handled by Laravel Breeze.

Role-based logic in EventController and Blade views using auth()->user()->role.

Form validation via StoreEventRequest.

Each event links to a user_id (event creator).

---

## 💡 Example Usage

Admin Login: admin@gmail.com / password

User Login: user@gmail.com / password

Admin can create an event and users can RSVP.

---

## 🧰 Useful Commands

| Command                                    | Description                                      |
|--------------------------------------------|--------------------------------------------------|
| php artisan migrate:fresh --seed           | Reset and reseed database                        |
| php artisan route:list                     | View all routes                                  |
| php artisan make:model Event -mcr          | Generate Model, Controller, and Migration       |
| npm run dev                                | Compile assets for development                   |
| php artisan serve                          | Start the Laravel server                         |

---

## 🧑‍💻 Author

Nipuna Dhananjaya  
📧 your.email@example.com

## 💻 GitHub

## 🪪 License

This project is open-source under the MIT License
.
