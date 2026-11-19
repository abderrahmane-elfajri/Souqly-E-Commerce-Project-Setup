# SOUQLY — Smart Commerce Platform

> A modern full-stack multi-category e-commerce platform designed specifically for the Moroccan market, built with **Laravel monolith, Blade MVC, MySQL, Tailwind CSS v4, and vanilla JavaScript**.

---

## 🌟 Project Identity
- **Name:** SOUQLY (سوقلي)
- **Tagline:** Everything you need. One place. / كل ما تحتاجه في مكان واحد.
- **Target Market:** Morocco (Casablanca, Rabat, Marrakech, Tangier, Fès, Agadir...)
- **Currency:** Moroccan Dirham — MAD (`د.م.`)
- **Languages:** French (Default), Arabic (Full RTL support), English
- **Brand Palette:** Dark Navy (`#101D32`), Vibrant Orange (`#F28A32`), Clean White (`#FFFFFF`)
- **Payment Method:** Cash on Delivery (COD / Paiement à la livraison) + extensible payment abstraction
- **Carriers Supported:** Amana Express (Poste Maroc), Cathedis Express, Ozone Express, Aramex Maroc

---

## 🚀 Implemented Modules & Architecture

### Phase 1 — Foundation & Identity
- Monolithic Laravel 13 architecture on PHP 8.4 and MySQL 8.4.
- Agence Web4U Moroccan market standards: responsive layout, high-performance assets, typography (`Cairo` for Arabic RTL, `Plus Jakarta Sans` for French/English).
- Direct WhatsApp customer conversion links (`wa.me/212...`).

### Phase 2 — Authentication, Customer Accounts & Localization
- Role-Based Access Control (`customer`, `admin`, `super_admin`).
- Moroccan phone number validation (`^(?:(?:\+|00)212|0)[5-7]\d{8}$`) and Moroccan cities directory.
- Customer dashboard with profile updating and default delivery address management.
- Dynamic trilingual switcher with automatic RTL direction toggle (`/locale/{locale}`).

### Phase 3 — Product Catalog, Categories & Multi-Language
- Trilingual database structure (`categories`, `category_translations`, `products`, `product_translations`, `product_variants`).
- Multi-category navigation: Luxury Watches, Electronics, Fashion, Home & Living.
- Dynamic filtering by category, price range, keyword search, and sorting.
- Product detail pages with stock checks and variant attribute pickers.

### Phase 4 — Shopping Experience, Cart & Cash on Delivery (COD)
- Persistent shopping cart supporting both authenticated users and guest sessions (with automatic merge on login).
- Real-time stock validation and transactional locking (`lockForUpdate()`) to prevent overselling.
- Free shipping threshold (500 MAD) with flat 30 MAD Moroccan delivery fee below threshold.
- Immutable order snapshots (`order_items` preserve purchase price, SKU, variant attributes).

### Phase 5 — Order Lifecycle, Couriers & Live Tracking
- Complete order status transitions (`pending` $\to$ `confirmed` $\to$ `processing` $\to$ `shipped` $\to$ `delivered` / `cancelled`).
- Automated inventory audit trail (`inventory_movements` logs `sale`, `cancellation_return`, `restock`, `adjustment`).
- Order cancellation returns stock transactionally to inventory.
- Public express tracking (`/track`) using order number + Moroccan phone verification (supports guest buyers).
- Moroccan courier shipment assignment (`shipments` with tracking numbers for Amana, Cathedis, Ozone).

### Phase 6 — Administration Suite
- Administrative dashboard with real revenue in MAD, pending orders count, low-stock alerts, and recent customer activity.
- Complete Products CRUD with trilingual editing (FR, AR with RTL, EN).
- Inventory & Stock Management suite with manual adjustments and restock logs.
- Category manager with product counters.
- Customer accounts and Moroccan address directory.

### Phase 7 — Testing, Hardening & Quality Gate
- 48 automated Feature and Unit tests passing with 152 assertions (`php artisan test`).
- Zero floating-point monetary calculations (`DECIMAL 12,2`).

---

## 🔑 Demo Credentials

| Role | Email | Password | Access |
|---|---|---|---|
| **Super Admin** | `admin@souqly.ma` | `password123` | `/admin` (Full Admin Suite) |
| **Customer** | `client@souqly.ma` | `password123` | `/account` & `/account/orders` |

---

## 🛠️ Getting Started

### 1. Prerequisites
- PHP 8.2+ with `pdo_mysql`, `intl`, `gd`, `zip`, `fileinfo` extensions enabled
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

# Install Frontend dependencies and build assets
npm install
npm run build

# Environment configuration
cp .env.example .env
php artisan key:generate

# Configure your MySQL credentials in .env and run migrations & seeders
php artisan migrate --seed

# Run tests
php artisan test

# Start local server
php artisan serve
```

---

## 🌐 Main Application Routes

### Storefront & Customer
- `/` — Homepage & Featured Collections
- `/shop` — Catalog with filters, search, and categories
- `/product/{slug}` — Product details & variants
- `/cart` — Shopping cart management
- `/checkout` — Cash on Delivery checkout with Moroccan delivery form
- `/track` — Public order tracking by order number & phone
- `/account` — Customer account dashboard
- `/account/orders` — Customer order history & live delivery progress stepper
- `/locale/{locale}` — Switch language (`fr`, `ar`, `en`)

### Administration (`/admin`)
- `/admin` — Revenue, orders, stock KPIs and recent audit movements
- `/admin/orders` — Orders management, status updates, courier dispatch
- `/admin/products` — Product catalog management & trilingual editor
- `/admin/inventory` — Stock levels, critical stock alerts, manual adjustments & restock
- `/admin/categories` — Categories & taxonomies
- `/admin/customers` — Customer accounts & Moroccan addresses

---

## 🧪 Automated Test Suite

Run all tests:
```bash
php artisan test
```

Test Results:
```
Tests:    48 passed (152 assertions)
Duration: 3.5s
Status:   100% PASSING
```

---

## 📄 License
Open source under the [MIT License](LICENSE).
