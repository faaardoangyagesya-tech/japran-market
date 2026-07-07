# Deploy ke Vercel + NeonDB

## Persiapan

### 1. Push ke GitHub

```bash
# Buat repo di github.com, lalu:
cd japran-stock
git init
git add -A
git commit -m "init: Japran Market"
git remote add origin https://github.com/USERNAME/japran-market.git
git push -u origin main
```

### 2. Buat 3 Project di Vercel

Buka https://vercel.com/import → pilih repo `japran-market`

Buat **3 project** dengan konfigurasi:

---

## Project 1: `japran-market` (Main Site)

| Setting | Value |
|---|---|
| **Root Directory** | `main-site` |
| **Framework** | Vue.js |
| **Build Command** | `npm run build` |
| **Output Dir** | `dist` |

**Environment Variables:**
| Key | Value |
|---|---|
| `VITE_API_URL` | `https://japran-market-api.vercel.app/api` |
| `VITE_WHATSAPP_NUMBER` | `6281234567890` (ganti) |

---

## Project 2: `japran-market-admin` (Admin Panel)

| Setting | Value |
|---|---|
| **Root Directory** | `admin-panel` |
| **Framework** | Vue.js |
| **Build Command** | `npm run build` |
| **Output Dir** | `dist` |

**Environment Variables:**
| Key | Value |
|---|---|
| `VITE_API_URL` | `https://japran-market-api.vercel.app/api` |

---

## Project 3: `japran-market-api` (Backend API)

> **PENTING:** Backend Laravel butuh PHP Runtime. Vercel support PHP via community runtime `vercel-php`.

| Setting | Value |
|---|---|
| **Root Directory** | `backend` |
| **Framework** | Other |
| **Build Command** | `composer install --no-dev --optimize-autoloader` |
| **Output Dir** | `public` |

**Environment Variables:**
| Key | Value |
|---|---|
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | `base64:pQDxe1yfYdDbMbwznzBSTjtAg+A3Fb8tKHKRK28Cb8I=` |
| `APP_URL` | `https://japran-market-api.vercel.app` |
| `DATABASE_URL` | `postgresql://neondb_owner:npg_VBkU0WvJG5Ir@ep-icy-sky-aoq8x712-pooler.c-2.ap-southeast-1.aws.neon.tech/neondb?sslmode=require&channel_binding=require` |
| `DB_CONNECTION` | `pgsql` |
| `DB_HOST` | `ep-icy-sky-aoq8x712-pooler.c-2.ap-southeast-1.aws.neon.tech` |
| `DB_PORT` | `5432` |
| `DB_DATABASE` | `neondb` |
| `DB_USERNAME` | `neondb_owner` |
| `DB_PASSWORD` | `npg_VBkU0WvJG5Ir` |
| `SANCTUM_STATEFUL_DOMAINS` | `japran-market.vercel.app,japran-market-admin.vercel.app` |

---

## Setelah Deploy

### 1. Jalankan Migration

Setelah API terdeploy, akses URL berikut di browser:

```
https://japran-market-api.vercel.app/api/stats
```

Jika response JSON muncul, API sudah berjalan.

**Jalankan migration & seeder:**
Vercel tidak support `php artisan migrate`. Bisa dilakukan via:
- **Local:** `php artisan migrate --seed` (konek ke NeonDB)
- **Atau via SSH/tunnel** ke database

### 2. Test API

```bash
# Games
curl https://japran-market-api.vercel.app/api/games

# Stats
curl https://japran-market-api.vercel.app/api/stats

# Login Admin
curl -X POST https://japran-market-api.vercel.app/api/admin/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@japranmarket.com","password":"password"}'
```

### 3. Domain Custom (Optional)

Di dashboard Vercel → project → Domains:
- `japranmarket.com` → main-site
- `admin.japranmarket.com` → admin-panel
- `api.japranmarket.com` → backend

---

## Struktur File untuk Vercel

```
japran-stock/
├── .gitignore
├── DEPLOY.md
├── backend/                 → vercel project: japran-market-api
│   ├── api/index.php        ← entry point PHP (bootstrap Laravel)
│   ├── vercel.json          ← PHP runtime config
│   ├── composer.json        ← Laravel dependencies
│   ├── bootstrap/app.php
│   ├── public/index.php
│   ├── app/                 ← Controllers, Models, etc
│   ├── config/              ← Laravel config files
│   ├── database/            ← Migrations & seeders
│   └── routes/api.php
├── main-site/               → vercel project: japran-market
│   ├── vercel.json
│   └── src/
└── admin-panel/             → vercel project: japran-market-admin
    ├── vercel.json
    └── src/
```
