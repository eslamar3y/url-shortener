# 🔗 URL Shortener SaaS

A full-featured URL shortener built with **Laravel**, **Filament**, and **Stripe** — supporting click analytics, expiry dates, and Pro subscriptions.

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel&logoColor=white)
![Filament](https://img.shields.io/badge/Filament-v3.3-FDAE4B?style=flat)
![Stripe](https://img.shields.io/badge/Stripe-Cashier-635BFF?style=flat&logo=stripe&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat&logo=php&logoColor=white)

---

## ✨ Features

- 🔗 Shorten any URL with a custom or auto-generated code
- 📊 Track clicks — country, device, browser, referrer
- ⏰ Set expiry dates on links
- 💎 Free / Pro plans via Stripe subscriptions
- 🔒 Link deactivation with friendly error pages
- 🛠️ Admin & User dashboards powered by Filament

---

## 🚀 Getting Started

### Requirements

- PHP 8.2+
- Composer
- MySQL
- Stripe account
- Stripe CLI (for local webhook testing)

### Installation

```bash
# 1. Clone the repo
git clone https://github.com/your-username/url-shortener.git
cd url-shortener

# 2. Install dependencies
composer install

# 3. Copy env file
cp .env.example .env
php artisan key:generate

# 4. Configure your database in .env
DB_DATABASE=url_shortener
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations and seed
php artisan migrate --seed

# 6. Start the server
php artisan serve
```

---

## 💳 Stripe Setup

### 1. Add keys to `.env`

```env
STRIPE_KEY=pk_test_xxxxxxxxxxxx
STRIPE_SECRET=sk_test_xxxxxxxxxxxx
STRIPE_WEBHOOK_SECRET=whsec_xxxxxxxxxxxx
STRIPE_PRO_PRICE_ID=price_xxxxxxxxxxxx
```

### 2. Create the Pro Plan product

```bash
stripe products create --name="Pro Plan"

stripe prices create \
  --product="prod_xxxxxxxxx" \
  --unit-amount=500 \
  --currency=usd \
  --recurring[interval]=month
```

Copy the `price_xxx` output and set it as `STRIPE_PRO_PRICE_ID` in `.env`.

### 3. Run webhook listener locally

```bash
stripe listen --forward-to localhost:8000/stripe/webhook
```

> ⚠️ The `WEBHOOK_SECRET` changes every time you run `stripe listen` — update `.env` each time.

---

## 🔐 Default Accounts (after seeding)

| Role  | Email              | Password |
|-------|--------------------|----------|
| Admin | admin@admin.com    | 12345678 |
| User  | eslam@test.com     | 12345678 |

---

## 🖥️ Dashboard URLs

| URL | Description |
|-----|-------------|
| `/app` | User dashboard (manage links) |
| `/admin` | Admin dashboard |
| `/app/billing/checkout` | Upgrade to Pro |
| `/app/billing/portal` | Manage subscription (Pro users) |
| `/r/{code}` | Redirect endpoint |

---

## 📁 Project Structure

```
app/
├── Filament/
│   └── App/
│       ├── Resources/
│       │   └── LinkResource/        # Manage links
│       └── Widgets/
│           └── StatsOverview.php    # Dashboard stats
├── Http/
│   └── Controllers/
│       ├── RedirectController.php   # Handles /r/{code}
│       └── BillingController.php    # Stripe checkout & portal
└── Models/
    ├── User.php
    ├── Link.php
    └── LinkClick.php
```

---

## 📦 Tech Stack

| Package | Purpose |
|---------|---------|
| `filament/filament` | Admin & user dashboards |
| `laravel/cashier` | Stripe subscription management |
| `jenssegers/agent` | Device & browser detection |

---

## 📄 License

MIT
