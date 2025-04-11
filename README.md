# curlAFhair 🛍️

An elegant eCommerce web application for hair & beauty products, built with Laravel 12.x, Vite, and TailwindCSS 4.1.3.

## 🔧 Tech Stack

- **Frontend**: HTML, TailwindCSS, JavaScript
- **Backend**: Laravel 12.x
- **Bundler**: Vite
- **Database**: MySQL
- **CI/CD**: GitHub Actions

## 🧰 Features

- 🔖 Landing, Shop, Cart, About, Services, and Contact pages
- 💳 Payment Gateway Integration
- 🧑‍🤝‍🧑 Guest Checkout + Membership Accounts (Citizenship)
- 🛠 Admin Dashboard to manage users and inventory
- 🚀 CI/CD via GitHub Actions

## 🧪 Local Setup

```bash
git clone https://github.com/your-username/curlAFhair.git
cd curlAFhair

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Create database and update .env, then:
php artisan migrate

# Run dev server
npm run dev
php artisan serve
