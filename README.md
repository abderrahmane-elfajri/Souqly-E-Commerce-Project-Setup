# Souqly-E-Commerce-Project-Setup

# SOUQLY — Smart Commerce Platform

> A modern full-stack multi-category e-commerce platform designed for the Moroccan market, built with **Laravel monolith, Blade MVC, MySQL, modern CSS3, and vanilla JavaScript**.

---

## 🌟 Project Identity
- **Name:** SOUQLY (سوقلي)
- **Tagline:** Everything you need. One place. / كل ما تحتاجه في مكان واحد.
- **Target Market:** Morocco (Casablanca, Rabat, Marrakech, Tangier, etc.)
- **Currency:** Moroccan Dirham — MAD (`د.م.`)
- **Languages:** French (Default), Arabic (Full RTL support), English
- **Brand Palette:** Dark Navy (`#101D32`), Vibrant Orange (`#F28A32`), Clean White (`#FFFFFF`)
- **Initial Payment Method:** Cash on Delivery (COD) / Paiement à la livraison + extensible payment abstraction

---

## 🚀 Tech Stack & Architecture
- **Backend:** Laravel 13 / PHP 8.4 (ZTS x64)
- **Frontend:** Blade Templates, Tailwind CSS v4, Vanilla JavaScript ES6+
- **Database:** MySQL 8.4 (InnoDB, UTF8MB4, Decimal for monetary calculations)
- **Localization:** Dynamic `SetLocale` middleware supporting LTR & RTL seamlessly
- **Asset Pipeline:** Vite

---

## 📁 Project Architecture
```
├── app/
│   ├── Enums/                 # OrderStatus, PaymentStatus, PaymentMethod
│   ├── Events/                # OrderPlaced, StockChanged
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Store/         # Catalog, cart, checkout, reviews
│   │   │   ├── Account/       # Customer orders, addresses, profile
│   │   │   └── Admin/         # Products, categories, orders, customers
│   │   ├── Middleware/        # SetLocale, role gates
│   │   └── Requests/          # Validated Form Requests
│   ├── Models/                # Product, Category, Order, Cart, User...
│   └── Services/              # CartService, CheckoutService, InventoryService
├── lang/
│   ├── fr/                    # French translations
│   ├── ar/                    # Arabic translations
│   └── en/                    # English translations
├── resources/
│   ├── css/                   # store.css, admin.css, app.css
│   ├── js/                    # app.js, cart.js, checkout.js, filters.js
│   └── views/                 # Blade storefront & admin layouts
└── database/
    └── migrations/            # Relational schema with translations
```

---

## 🛠️ Getting Started

### 1. Prerequisites
- PHP 8.2+ with `pdo_mysql`, `intl`, `gd`, `zip` extensions enabled
- Composer 2+
- Node.js 18+ & NPM
- MySQL 8.0+

### 2. Installation
```bash
# Clone the repository
git clone https://github.com/abderrahmane-elfajri/Souqly-E-Commerce-Project-Setup.git
cd Souqly-E-Commerce-Project-Setup

# Install PHP dependencies
composer install

# Install Frontend dependencies
npm install
npm run build

# Environment configuration
cp .env.example .env
php artisan key:generate

# Configure your MySQL credentials in .env and run migrations
php artisan migrate

# Start local server
php artisan serve
```

Visit [http://127.0.0.1:8000](http://127.0.0.1:8000) to browse the storefront.

---

## 📄 License
Open source under the [MIT License](LICENSE).
