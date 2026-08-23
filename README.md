# 🌿 Grafto

**Grafto** is a RESTful Nursery E-commerce API built with **Laravel**. It allows users to browse plants, manage shopping carts, place orders, and securely authenticate using JWT. The platform is designed for nurseries selling various types of plants, including grafted trees, fruit plants, flower plants, and indoor plants.

---

## 🚀 Features

### User Features

- User Registration & Login
- JWT Authentication
- Browse Plant Categories
- Search Plants
- Filter Plants by Category
- View Plant Details
- Shopping Cart Management
- Place Orders
- View Order History
- Update User Profile

### Admin Features

- Manage Categories
- Manage Plants
- Manage Orders
- Dashboard Statistics
- Manage Users

---

## 🌱 Plant Categories

Some example categories include:

- Fruit Plants
- Flower Plants
- Indoor Plants
- Outdoor Plants
- Grafted Plants
- Jor Kolom
- Gooti Kolom
- Shakha Kolom
- Medicinal Plants
- Ornamental Plants

---

# 🛠 Tech Stack

- Laravel
- PHP
- MySQL
- Laravel Sanctum / JWT Authentication
- Eloquent ORM
- REST API

---

# 📦 Installation

Clone the repository

```bash
git clone https://github.com/jahir002201/grafto.git
```

Go to project directory

```bash
cd grafto
```

Install dependencies

```bash
composer install
```

Copy environment file

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Configure your database inside `.env`

```env
DB_DATABASE=grafto
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations

```bash
php artisan migrate
```

(Optional) Seed database

```bash
php artisan db:seed
```

Start development server

```bash
php artisan serve
```
API Docs → Dedoc Scramble

```bash
http://127.0.0.1:8000/docs/api
```

---

# 🔐 Authentication Endpoints

| Method | Endpoint | Description |
|---------|----------|-------------|
| POST | `/auth/register` | Register a new user |
| POST | `/auth/login` | Login |
| POST | `/auth/logout` | Logout |
| POST | `/auth/token/refresh` | Refresh JWT Token |

---

# 🌿 Category Endpoints

| Method | Endpoint |
|---------|----------|
| GET | `/api/categories` |
| GET | `/api/categories/{id}` |
| POST | `/api/categories` |
| PUT | `/api/categories/{id}` |
| DELETE | `/api/categories/{id}` |

---

# 🌱 Plant Endpoints

| Method | Endpoint |
|---------|----------|
| GET | `/api/plants` |
| GET | `/api/plants/{id}` |
| GET | `/api/plants?search=` |
| GET | `/api/plants?category=` |
| POST | `/api/plants` |
| PUT | `/api/plants/{id}` |
| DELETE | `/api/plants/{id}` |

---

# 🛒 Cart Endpoints

| Method | Endpoint |
|---------|----------|
| POST | `/api/carts` |
| GET | `/api/carts/{cart_id}` |
| DELETE | `/api/carts/{cart_id}` |
| POST | `/api/carts/{cart_id}/items` |
| PATCH | `/api/carts/{cart_id}/items/{item_id}` |
| DELETE | `/api/carts/{cart_id}/items/{item_id}` |

---

# 📦 Order Endpoints

| Method | Endpoint |
|---------|----------|
| GET | `/api/orders` |
| GET | `/api/orders/{id}` |
| POST | `/api/orders` |
| PUT | `/api/orders/{id}/status` |
| DELETE | `/api/orders/{id}` |

---

# 👤 Profile Endpoints

| Method | Endpoint |
|---------|----------|
| GET | `/api/profile` |
| PUT | `/api/profile` |

---

# 📊 Dashboard Endpoints

| Method | Endpoint |
|---------|----------|
| GET | `/api/dashboard/total-users` |
| GET | `/api/dashboard/total-orders` |
| GET | `/api/dashboard/total-plants` |
| GET | `/api/dashboard/total-categories` |

---

# 🗄 Database Schema

## User

- id
- first_name
- last_name
- email
- phone
- address
- password

---

## Category

- id
- name
- description
- image

---

## Plant

- id
- name
- scientific_name
- description
- price
- stock
- image
- height
- age
- sunlight
- watering
- category_id
- created_at
- updated_at

---

## Cart

- id
- user_id
- created_at

---

## CartItem

- id
- cart_id
- plant_id
- quantity

---

## Order

- id
- user_id
- total_price
- status
- created_at
- updated_at

---

## OrderItem

- id
- order_id
- plant_id
- quantity
- price

---

# 🔗 Relationships

- User → One Cart
- User → Many Orders
- Category → Many Plants
- Plant → One Category
- Cart → Many Cart Items
- Plant → Many Cart Items
- Order → Many Order Items
- Plant → Many Order Items

---

# 📁 Project Structure

```
app/
├── Http/
├── Models/
├── Services/
├── Repositories/
├── Policies/

database/
├── migrations/
├── seeders/

routes/
├── api.php

resources/

storage/

tests/
```

---

# 📌 Future Improvements

- Wishlist
- Plant Reviews & Ratings
- Online Payment Integration
- Discount Coupons
- Delivery Tracking
- Favorite Plants
- Admin Analytics
- Email Notifications

---

# 👨‍💻 Author

**Jahir Islam**

Laravel Backend Developer

---

# 📄 License

This project is open-source and available under the **MIT License**.