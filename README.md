# 🌿 Grafto

**Grafto** is a RESTful Nursery E-commerce API built with **Laravel**. It allows users to browse plants, manage shopping carts, place orders, make secure online payments through **SSLCommerz**, and authenticate securely using JWT.

The platform is designed for nurseries selling various types of plants, including grafted trees, fruit plants, flower plants, indoor plants, and medicinal plants.

---

## 🚀 Features

### User Features

* User Registration & Login
* JWT Authentication
* Browse Plant Categories
* Search Plants
* Filter Plants by Category
* View Plant Details
* Shopping Cart Management
* Place Orders
* Online Payment with SSLCommerz
* Payment Verification & IPN Handling
* View Order History
* Update User Profile

### Admin Features

* Manage Categories
* Manage Plants
* Manage Orders
* Manage Payments
* Dashboard Statistics
* Manage Users

---

## 🌱 Plant Categories

Some example categories include:

* Fruit Plants
* Flower Plants
* Indoor Plants
* Outdoor Plants
* Grafted Plants
* Jor Kolom
* Gooti Kolom
* Shakha Kolom
* Medicinal Plants
* Ornamental Plants

---

# 🛠 Tech Stack

* Laravel
* PHP
* MySQL
* Eloquent ORM
* REST API
* JWT Authentication
* SSLCommerz Payment Gateway
* Dedoc Scramble API Documentation

---

# 📦 Installation

### Clone the repository

```bash
git clone https://github.com/jahir002201/grafto.git
```

### Go to project directory

```bash
cd grafto
```

### Install dependencies

```bash
composer install
```

### Copy environment file

```bash
cp .env.example .env
```

### Generate application key

```bash
php artisan key:generate
```

### Configure your database inside `.env`

```env
DB_DATABASE=grafto
DB_USERNAME=root
DB_PASSWORD=
```

### Configure SSLCommerz

Add your SSLCommerz credentials to `.env`:

```env
SSLCOMMERZ_STORE_ID=your_store_id
SSLCOMMERZ_STORE_PASSWORD=your_store_password
SSLCOMMERZ_SANDBOX=true
```

For production, set:

```env
SSLCOMMERZ_SANDBOX=false
```

> Keep your SSLCommerz Store ID and Store Password private. Never commit them to Git.

### Run migrations

```bash
php artisan migrate
```

### Optional: Seed database

```bash
php artisan db:seed
```

### Start development server

```bash
php artisan serve
```

API Documentation:

```text
http://127.0.0.1:8000/docs/api
```

API documentation is generated using **Dedoc Scramble**.

---

# 🔐 Authentication Endpoints

| Method | Endpoint              | Description         |
| ------ | --------------------- | ------------------- |
| POST   | `/auth/register`      | Register a new user |
| POST   | `/auth/login`         | Login               |
| POST   | `/auth/logout`        | Logout              |
| POST   | `/auth/token/refresh` | Refresh JWT Token   |

---

# 🌿 Category Endpoints

| Method | Endpoint               | Description          |
| ------ | ---------------------- | -------------------- |
| GET    | `/api/categories`      | Get all categories   |
| GET    | `/api/categories/{id}` | Get category details |
| POST   | `/api/categories`      | Create category      |
| PUT    | `/api/categories/{id}` | Update category      |
| DELETE | `/api/categories/{id}` | Delete category      |

---

# 🌱 Plant Endpoints

| Method | Endpoint                | Description               |
| ------ | ----------------------- | ------------------------- |
| GET    | `/api/plants`           | Get all plants            |
| GET    | `/api/plants/{id}`      | Get plant details         |
| GET    | `/api/plants?search=`   | Search plants             |
| GET    | `/api/plants?category=` | Filter plants by category |
| POST   | `/api/plants`           | Create plant              |
| PUT    | `/api/plants/{id}`      | Update plant              |
| DELETE | `/api/plants/{id}`      | Delete plant              |

---

# 🛒 Cart Endpoints

| Method | Endpoint                               | Description      |
| ------ | -------------------------------------- | ---------------- |
| POST   | `/api/carts`                           | Create cart      |
| GET    | `/api/carts/{cart_id}`                 | View cart        |
| DELETE | `/api/carts/{cart_id}`                 | Delete cart      |
| POST   | `/api/carts/{cart_id}/items`           | Add item to cart |
| PATCH  | `/api/carts/{cart_id}/items/{item_id}` | Update cart item |
| DELETE | `/api/carts/{cart_id}/items/{item_id}` | Remove cart item |

---

# 📦 Order Endpoints

| Method | Endpoint                  | Description         |
| ------ | ------------------------- | ------------------- |
| GET    | `/api/orders`             | Get user's orders   |
| GET    | `/api/orders/{id}`        | Get order details   |
| POST   | `/api/orders`             | Create order        |
| PUT    | `/api/orders/{id}/status` | Update order status |
| DELETE | `/api/orders/{id}`        | Delete order        |

---

# 💳 SSLCommerz Payment Gateway

Grafto supports online payments through **SSLCommerz**, allowing customers to securely pay for their orders using supported payment methods.

### Payment Flow

```text
Customer
   ↓
Create Order
   ↓
Initiate SSLCommerz Payment
   ↓
Redirect to SSLCommerz
   ↓
Complete Payment
   ↓
SSLCommerz
   ↓
Success / Fail / Cancel
   ↓
Payment Verification / IPN
   ↓
Update Payment & Order Status
```

### Payment Endpoints

| Method | Endpoint                   | Description                   |
| ------ | -------------------------- | ----------------------------- |
| POST   | `/api/orders/{id}/payment` | Initiate SSLCommerz payment   |
| GET    | `/api/payment/success`     | Payment success callback      |
| GET    | `/api/payment/fail`        | Payment failure callback      |
| GET    | `/api/payment/cancel`      | Payment cancellation callback |
| POST   | `/api/payment/ipn`         | SSLCommerz IPN callback       |

### Payment Security

The application should verify the payment through SSLCommerz before marking an order as **paid**.

The success callback alone should not be treated as proof of payment.

The payment flow should include:

* Transaction validation
* IPN handling
* Transaction ID verification
* Amount verification
* Currency verification
* Order/payment status update
* Failed and cancelled payment handling

---

# 👤 Profile Endpoints

| Method | Endpoint       | Description         |
| ------ | -------------- | ------------------- |
| GET    | `/api/profile` | Get user profile    |
| PUT    | `/api/profile` | Update user profile |

---

# 📊 Dashboard Endpoints

| Method | Endpoint                          | Description      |
| ------ | --------------------------------- | ---------------- |
| GET    | `/api/dashboard/total-users`      | Total users      |
| GET    | `/api/dashboard/total-orders`     | Total orders     |
| GET    | `/api/dashboard/total-plants`     | Total plants     |
| GET    | `/api/dashboard/total-categories` | Total categories |

---

# 🗄 Database Schema

## User

* id
* first_name
* last_name
* email
* phone
* address
* password
* created_at
* updated_at

---

## Category

* id
* name
* description
* image
* created_at
* updated_at

---

## Plant

* id
* name
* scientific_name
* description
* price
* stock
* image
* height
* age
* sunlight
* watering
* category_id
* created_at
* updated_at

---

## Cart

* id
* user_id
* created_at
* updated_at

---

## CartItem

* id
* cart_id
* plant_id
* quantity
* created_at
* updated_at

---

## Order

* id
* user_id
* total_price
* status
* created_at
* updated_at

### Order Status

```text
pending
confirmed
processing
shipped
delivered
cancelled
```

---

## OrderItem

* id
* order_id
* plant_id
* quantity
* price
* created_at
* updated_at

---

## Payment

* id
* order_id
* transaction_id
* validation_id
* amount
* currency
* payment_method
* status
* gateway_response
* paid_at
* created_at
* updated_at

### Payment Status

```text
pending
paid
failed
cancelled
refunded
```

---

# 🔗 Relationships

* User → One Cart
* User → Many Orders
* User → Many Payments through Orders
* Category → Many Plants
* Plant → One Category
* Cart → Many Cart Items
* Plant → Many Cart Items
* Order → Many Order Items
* Plant → Many Order Items
* Order → Many Payments
* Payment → One Order

---

# 💰 Order & Payment Architecture

Grafto separates **order status** from **payment status**.

```text
User
 ↓
Cart
 ↓
Order
 ↓
Payment
 ↓
SSLCommerz
```

For example, an order can have:

```text
Order Status: processing
Payment Status: paid
```

This separation makes it easier to support future features such as:

* Payment retries
* Refunds
* Multiple payment attempts
* Payment history
* Failed payments
* Different payment methods

---

# 📁 Project Structure

```text
app/
├── Http/
│   ├── Controllers/
│   ├── Requests/
│   └── Resources/
├── Models/
├── Services/
│   └── SSLCommerzService.php
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

# 🔄 Payment Integration Flow

A typical checkout process looks like this:

```text
1. User adds plants to cart
        ↓
2. User creates an order
        ↓
3. Grafto creates a pending payment
        ↓
4. Grafto initializes SSLCommerz
        ↓
5. User is redirected to SSLCommerz
        ↓
6. User completes payment
        ↓
7. SSLCommerz sends callback/IPN
        ↓
8. Grafto validates the transaction
        ↓
9. Payment status becomes "paid"
        ↓
10. Order continues processing
```

---

# 🔒 Security

Grafto uses several security mechanisms:

* JWT-based authentication
* Password hashing
* Authentication middleware
* Authorization policies
* Request validation
* Protected admin endpoints
* SSLCommerz transaction validation
* Environment-based secrets
* Database transactions for critical operations

Sensitive credentials should always be stored in `.env` and should never be committed to the repository.

---

# 📌 Future Improvements

* Wishlist
* Plant Reviews & Ratings
* Discount Coupons
* Delivery Tracking
* Favorite Plants
* Admin Analytics
* Email Notifications
* Payment Refund System
* Multiple Payment Attempts
* Payment History
* Product Recommendations
* Inventory Notifications
* Order Invoice Generation

---

# 👨‍💻 Author

**Jahirul Islam**

Laravel Backend Developer

---

# 📄 License

This project is open-source and available under the **MIT License**.
