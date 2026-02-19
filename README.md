# TradeFlow ERP

TradeFlow adalah sistem ERP sederhana berbasis Laravel + Filament yang
mengelola proses Sales dan Purchase dalam satu sistem terpusat.

Project ini dibuat untuk kebutuhan pembelajaran dan pengembangan sistem
Sales Cycle & Purchase Cycle dengan arsitektur yang scalable.

---

## 🚀 Tech Stack

- Laravel 10+
- Laravel Breeze (Authentication)
- Filament Admin Panel
- MySQL
- Blade
- Role-based Authorization (Policy)

---

## 🧩 Fitur Utama

### 🔹 Authentication
- Login menggunakan Laravel Breeze
- Role-based access:
  - Admin
  - Sales
  - Purchasing
  - Manager

---

### 🔹 Sales Cycle
1. Staff Sales membuat Sales Order
2. Sales Order memiliki banyak item
3. Sistem menghitung total otomatis
4. Sales Payment dicatat
5. Invoice dapat dicetak (Printable Invoice)

---

### 🔹 Master Data
- Customer
- Supplier
- Product

---

### 🔹 Authorization
- Menggunakan Laravel Policy
- Role menentukan akses:
  - Admin: akses penuh
  - Sales: hanya Sales
  - Purchasing: hanya Purchase
  - Manager: view report

---

## 🏗️ Arsitektur Project


tradeflow/
│
├── app/
│ ├── Models/
│ ├── Filament/
│ │ └── Resources/
│ ├── Policies/
│ └── Providers/
│
├── database/
│ └── migrations/
│
├── resources/
│ └── views/
│
├── routes/
│ └── web.php
│
├── Flow.md
└── README.md


---

## 📄 Flow Sistem

Semua aturan bisnis dan alur sistem dijelaskan secara lengkap di:


Flow.md


File ini menjadi source of truth untuk pengembangan sistem.

---

## 🖨️ Printable Invoice

Invoice dapat dicetak melalui:
- Route khusus
- Blade template invoice
- Data diambil dari Sales Order dan Sales Payment

---

## 🔐 Future Ready (Payment Gateway)

Struktur database sudah disiapkan untuk integrasi payment gateway
seperti Xendit tanpa perlu refactor besar.

Saat ini sistem masih menggunakan manual payment recording.

---

## ⚙️ Instalasi

```bash
git clone <repository-url>
cd tradeflow
composer install
cp .env.example .env
php artisan key:generate

Edit konfigurasi database di .env, lalu jalankan:

php artisan migrate
php artisan serve
🧠 Catatan Arsitektur

Business logic berada di Model / Service Layer

Filament hanya sebagai admin interface

Tidak ada login untuk customer atau supplier

Sistem hanya untuk internal perusahaan
