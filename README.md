# Japran Market

Website jual beli akun game dengan sistem unik `#000001`-`#999999`.

## Struktur Project

```
japran-stock/
├── backend/          # Laravel API
├── main-site/        # Vue.js (japranmarket.com)
└── admin-panel/      # Vue.js (admin.japranmarket.com)
```

## Setup

### 1. Backend (Laravel)

```bash
cd backend

# Install dependencies (butuh PHP 8.2+ & Composer)
composer install

# Copy env & generate key
cp .env.example .env
php artisan key:generate

# Setup database (MySQL/mariaDB)
# Edit .env -> DB_DATABASE, DB_USERNAME, DB_PASSWORD

# Run migration & seeder
php artisan migrate
php artisan db:seed

# Start server
php artisan serve --port=8000
```

**Seeder default:**
- 8 Game (Roblox, Minecraft, Free Fire, Mobile Legends, PUBG, Valorant, Genshin Impact, Steam)
- Admin: `admin@japranmarket.com` / `password`

### 2. Main Site (Vue.js)

```bash
cd main-site
npm install
npm run dev
# Running di http://localhost:5173
```

### 3. Admin Panel (Vue.js)

```bash
cd admin-panel
npm install
npm run dev
# Running di http://localhost:5174
```

## Deploy

| Domain | Project |
|--------|---------|
| `japranmarket.com` | `main-site` |
| `admin.japranmarket.com` | `admin-panel` |
| `api.japranmarket.com` | `backend` |

**Build production:**
```bash
cd main-site && npm run build
cd admin-panel && npm run build
```

## Fitur

- [x] Landing page dengan particle animation
- [x] Pilih game -> lihat akun -> beli via WhatsApp
- [x] Auto-generate kode unik (#000001 - #999999)
- [x] Statistik pengunjung
- [x] Admin panel terpisah (CRUD stock & game)
- [x] Dark theme gold + blue accent
- [x] Responsive design
