<div align="center">

# AutoMarket - Vehicle Marketplace Platform

**A full-stack vehicle listing and marketplace platform built with Laravel 11.**
Dual-interface system: a powerful admin/backend panel for management and a RESTful API for mobile/frontend clients.

[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php)](https://www.php.net)
[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel)](https://laravel.com)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)

</div>

---

## Project Overview

**AutoMarket** is a comprehensive vehicle listing and marketplace web application. It solves the problem of managing a car dealership or multi-seller vehicle marketplace by providing:

- A **secure admin panel** for managing vehicles, users, content, and platform settings
- A **REST API** (JWT-authenticated) for mobile applications and third-party frontends
- A **real-time chat** system between buyers and sellers via Laravel Reverb (WebSockets)
- A **CMS layer** for managing blogs, FAQs, testimonials, dynamic pages, and About Us content

The platform supports two user roles from the API side (**seller** and **user/buyer**) and uses Spatie Permission for granular admin access control.

---

## Project Features

### Authentication & Authorization
- Session-based auth for admin panel (Laravel Breeze)
- JWT-based auth for API users (tymon/jwt-auth)
- OTP (One-Time Password) email verification for registration and password reset
- Google OAuth login for API users
- Phone + OTP login alternative
- Role & permission management (Spatie Permission)

### Vehicle Management
- Full CRUD for vehicle listings with 15+ specification attributes
- Separate interior and exterior image uploads with image type management
- Vehicle tagging system
- Vehicle verification workflow (admin must verify seller-submitted listings)
- Status toggle (active/inactive) for all listings
- Soft deletes with deleted_by tracking
- Advanced vehicle filtering by: brand, category, body type, transmission, fuel type, color, drivetrain, cylinder, size, doors, price range, year range, mileage range, MPG, name search
- Sorting and pagination support

### Specification Management
Admin-controlled lookup tables for:
- Body Types, Transmissions, Fuel Types, Sizes, Doors, Mileage, Drivetrains, Cylinders, MPG ranges, Colors, Image Types

### Brand & Category Management
- Brand management with images, slugs, and priority ordering (drag-and-drop rank)
- Category management with priority ordering
- Status toggle and soft-deletes

### CMS (Content Management System)
- **About Us** - Single-entry editable company information
- **Blog** - Full blog management with slugs, images, status, and front-page toggle
- **Testimonials** - Manage customer testimonials with status toggle
- **FAQs** - Manage Q&A with priority ordering and status
- **Dynamic Pages** - Create custom pages with slugs (e.g. Privacy Policy, Terms)
- **Declarations** - Seller agreement declarations with ordering
- **Tags** - Reusable vehicle tags
- **Social Media** links management

### Real-Time Chat
- Live buyer-to-seller messaging using Laravel Reverb (WebSockets)
- API endpoints to send and fetch messages

### Reviews & Ratings
- Polymorphic review system (vehicles and users can be reviewed)
- API endpoints to post and retrieve reviews

### System Settings
- General site settings (name, logo, favicon, tagline, contact info, copyright)
- Admin panel branding (separate logo, favicon, title)
- Mail configuration (SMTP settings via .env update)
- Stripe payment gateway configuration
- PayPal payment gateway configuration

### User Management (Admin)
- Create, edit, view, and delete admin users
- Role assignment (Spatie roles)
- Status toggle and bulk delete support
- Admin profile management (avatar, password, username)

---

## Complex Features Explained

### 1. JWT + OTP Authentication Flow
The API uses `tymon/jwt-auth` for stateless authentication. Upon registration:
1. User submits name, email, phone, password, role
2. A 4-digit OTP is generated, **hashed with `Hash::make()`**, and stored in `users.otp` along with `otp_created_at`
3. The OTP is emailed via `OtpNotification` (Laravel Mail)
4. The user verifies by submitting the plain OTP - the system uses `Hash::check()` against the stored hash
5. OTP expires after **15 minutes** (checked against `otp_created_at`)
6. A JWT token is returned on successful login/verification

### 2. Vehicle Image Type System
Instead of hardcoded image positions, images are mapped to configurable `ImageType` records (e.g., "Front Exterior", "Dashboard Interior"). Each `ImageType` has a `type` field (interior/exterior). When uploading:
- Images are stored in `vehicle/interior/` or `vehicle/exterior/` directories based on the type
- Separate `VehicleInteriorImage` and `VehicleExteriorImage` models track each image
- On update, existing images for a given type are replaced (old file deleted from disk)

### 3. Role-Based Access Control (Spatie)
The admin panel uses `spatie/laravel-permission` for fine-grained control:
- Roles are assignable to admin users (e.g., SuperAdmin, Editor, Moderator)
- Permissions are defined per resource
- The `AdminMiddleware` protects all backend routes

### 4. Vehicle Verification Workflow
Sellers submit vehicles via API > vehicles are marked `verified = 0` by default > Admin reviews via the backend panel > clicking "Verify" sets `verified = 1` > verified vehicles can then be edited and published.

### 5. Real-Time Messaging (Laravel Reverb)
Uses Laravel Reverb (WebSocket server) with Pusher-compatible protocol:
- Backend broadcasts events on a private channel
- Frontend subscribes using `laravel-echo` and `pusher-js`
- Chat messages are persisted in the `chats` table

### 6. Dynamic Slug Generation
The `generateUniqueSlug()` method in the base `Controller` generates URL-friendly slugs. If a slug already exists, it appends a numeric suffix (e.g., `toyota-camry-1`). Used for vehicles, brands, categories, and blogs.

---

## Technology Stack

| Layer | Technology |
|---|---|
| **Backend Framework** | Laravel 11.x |
| **PHP Version** | PHP 8.2+ |
| **Authentication (Web)** | Laravel Breeze (session-based) |
| **Authentication (API)** | tymon/jwt-auth 2.x (JWT tokens) |
| **Authorization** | spatie/laravel-permission 6.x |
| **Real-Time** | Laravel Reverb 1.x (WebSockets) |
| **API Support** | Laravel Sanctum 4.x |
| **Database ORM** | Laravel Eloquent |
| **DataTables** | yajra/laravel-datatables 11.x |
| **Flash Notifications** | php-flasher/flasher-laravel 2.x |
| **Frontend (Admin)** | Blade templates + TailwindCSS 3 |
| **Frontend Build** | Vite 5 + Laravel Vite Plugin |
| **SMS/Phone** | twilio/sdk 8.x |
| **CSS Framework** | TailwindCSS 3.x + Alpine.js 3.x |
| **WebSocket Client** | laravel-echo + pusher-js |
| **Queue/Jobs** | Laravel Queue (database driver) |
| **Testing** | PHPUnit 11.x |

---

## Installed Packages

### Production Dependencies (composer.json)

| Package | Version | Purpose |
|---|---|---|
| `laravel/framework` | ^11.31 | Core Laravel framework |
| `laravel/reverb` | ^1.0 | WebSocket server for real-time features |
| `laravel/sanctum` | ^4.0 | API token authentication scaffold |
| `laravel/tinker` | ^2.9 | REPL for interacting with the app |
| `php-flasher/flasher-laravel` | ^2.1 | Flash notification system for Blade |
| `spatie/laravel-permission` | ^6.10 | Roles & permissions management |
| `twilio/sdk` | ^8.3 | SMS and phone OTP delivery (optional) |
| `tymon/jwt-auth` | ^2.1 | JWT authentication for REST API |
| `yajra/laravel-datatables` | 11.0 | Server-side DataTables for admin listings |

### Development Dependencies

| Package | Version | Purpose |
|---|---|---|
| `laravel/breeze` | ^2.2 | Auth scaffolding (web admin login) |
| `fakerphp/faker` | ^1.23 | Fake data generation for seeding |
| `laravel/pail` | ^1.1 | Real-time log tailing in terminal |
| `laravel/pint` | ^1.13 | PHP code style fixer (PSR-12) |
| `laravel/sail` | ^1.26 | Docker development environment |
| `phpunit/phpunit` | ^11.0.1 | Testing framework |

### NPM Dependencies (package.json)

| Package | Purpose |
|---|---|
| `vite` + `laravel-vite-plugin` | Frontend asset bundling |
| `tailwindcss` + `autoprefixer` | Utility-first CSS framework |
| `alpinejs` | Lightweight reactive JS for Blade |
| `laravel-echo` + `pusher-js` | WebSocket client for real-time chat |
| `axios` | HTTP client for AJAX requests |
| `concurrently` | Run multiple dev servers simultaneously |

---

## Project Architecture

```
r_realstate_laravel/
├── app/
│   ├── Console/            # Custom Artisan commands
│   ├── Events/             # Broadcast event classes (real-time)
│   ├── Helper/
│   │   └── Helper.php      # Static utility methods (file upload, table checkbox)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── API/        # REST API controllers
│   │   │   │   ├── Seller/ # Seller: Vehicle CRUD, Specifications
│   │   │   │   ├── User/   # Buyer: CMS, Chat, Reviews
│   │   │   │   ├── UserAuthController.php  # JWT login, register, OTP
│   │   │   │   └── UserController.php      # Profile, password, notifications
│   │   │   ├── Auth/       # Web auth (Breeze-generated)
│   │   │   ├── Web/
│   │   │   │   └── backend/     # Admin panel controllers (24 total)
│   │   │   │       ├── admin/   # FAQ management
│   │   │   │       └── settings/# Dynamic pages, Profile settings
│   │   │   └── Controller.php   # Base: fileUpload, generateUniqueSlug
│   │   ├── Middleware/
│   │   │   ├── JWTMiddleware.php   # API JWT verification
│   │   │   └── AdminMiddleware.php # Web admin auth guard
│   │   └── Requests/       # Form request validation classes
│   ├── Models/             # 30 Eloquent models
│   ├── Notifications/
│   │   └── OtpNotification.php  # Email OTP delivery
│   ├── Services/
│   │   ├── Service.php         # Base service with fileUpload
│   │   ├── SettingService.php  # Admin settings page logic
│   │   └── UserService.php     # User show logic
│   └── Traits/
│       └── apiresponse.php     # success(), error(), generateOtp()
├── database/
│   ├── migrations/         # 33 database migrations
│   ├── seeders/            # Database seeders
│   └── factories/          # Model factories
├── resources/
│   ├── views/
│   │   ├── auth/           # Login, registration Blade views
│   │   ├── backend/        # Admin panel Blade templates
│   │   ├── email/          # Email notification templates
│   │   └── layouts/        # Shared layout templates
│   ├── css/                # Application CSS
│   └── js/                 # Alpine.js + Echo setup
├── routes/
│   ├── api.php             # REST API routes (JWT-protected)
│   ├── auth.php            # Web auth routes (Breeze)
│   ├── backend.php         # Admin panel routes
│   ├── web.php             # Public web routes
│   └── channels.php        # Broadcast channel definitions
└── public/uploads/         # User-uploaded files (images)
```

### Component Interaction Diagram

```
Mobile / Frontend App
      |  REST API (JWT Bearer Token)
      v
routes/api.php --> API Controllers --> Eloquent Models --> MySQL DB
                       |
                       |-- UserAuthController  (JWT auth + OTP email)
                       |-- Seller/VehicleController (CRUD + filtering)
                       |-- User/CMSController  (public content)
                       |-- User/ChatController (WebSocket messages)
                       +-- User/ReviewController

Admin Browser
      |  Session Auth (Laravel Breeze)
      v
routes/auth.php --> Auth Controllers (login / logout)
routes/backend.php --> Backend Controllers --> Eloquent Models --> MySQL DB
                           |-- VehicleController  (verify/manage listings)
                           |-- SettingController  (.env + DB settings)
                           |-- UserController     (users/roles management)
                           +-- CMS Controllers    (blog, faq, testimonials)

                    Laravel Reverb (WebSocket Server)
                           |
                    <------+  Real-time chat events broadcast
                           |
                    laravel-echo (JS) subscribes to private channels
```

---

## Build Information

### Development Build
Uses **Vite** with HMR (Hot Module Replacement):
```bash
npm run dev
```
Starts the Vite dev server on `http://localhost:5173` with instant CSS/JS updates.

### Production Build
```bash
npm run build
```
Vite compiles, minifies, and versions all CSS/JS assets into `public/build/`. The generated `manifest.json` is used by Laravel's `@vite()` Blade directive for fingerprinted asset URLs.

### Full Dev Stack (Recommended)
The `composer.json` `dev` script runs all services concurrently:
```bash
composer run dev
```

| Process | Command | Purpose |
|---|---|---|
| Server | `php artisan serve` | Laravel HTTP server |
| Queue | `php artisan queue:listen --tries=1` | Email & notification jobs |
| Logs | `php artisan pail --timeout=0` | Real-time log tailing |
| Assets | `npm run dev` | Vite HMR dev server |

### Build/Deployment Considerations
- `public/uploads/` must be writable by the web server - files are stored directly here (not symlinked)
- Never commit `.env` to version control
- In production, run `php artisan config:cache`, `php artisan route:cache`, and `php artisan view:cache`
- Run `php artisan queue:work` in production (or use Supervisor/Laravel Horizon)

---

## User Roadmap / User Flow

### Admin User Flow

```
1. Visit /login -> Enter credentials -> Session created
2. Redirected to /dashboard
3. Admin manages the platform:
   |-- /vehicle/list        -> Review unverified listings -> Verify or Delete
   |-- /brand               -> Add/edit/reorder car brands
   |-- /category            -> Add/edit/reorder categories
   |-- /bodyType, /color... -> Manage specification tables
   |-- /blog, /faq...       -> Manage CMS content
   |-- /users/list          -> View/create/manage admin users
   |-- /role/list           -> Define roles & permissions
   |-- /general/setting     -> Update site identity info
   +-- /system/setting      -> Update mail, Stripe, PayPal keys
4. POST /admin/logout -> Session destroyed -> Redirected to /login
```

### Seller (API) User Flow

```
1. POST /api/register { name, email, phone, password, role: "seller" }
   -> OTP emailed to user
2. POST /api/verify-otp-password { email, otp, action: "email_verification" }
   -> Account activated
3. POST /api/login { email, password }
   -> Returns JWT access token
4. GET /api/seller/get/brands, /categories, /bodyType...
   -> Load dropdowns for vehicle listing form
5. POST /api/seller/vehicle/store { all vehicle fields + images }
   -> Vehicle created with verified=0 (pending admin approval)
6. [Admin verifies vehicle] -> vehicle becomes publicly live
7. PATCH /api/seller/vehicle/status { id } -> Toggle active/inactive
8. POST /api/seller/vehicle/update { id, updated fields }
9. POST /api/logout -> JWT invalidated
```

### Buyer (API) User Flow

```
1.  POST /api/register { name, email, phone, password, role: "user" }
2.  POST /api/verify-otp-password -> Account activated
3.  POST /api/login -> JWT token returned
4.  POST /api/seller/vehicles { filters: brand, price_min, price_max, year... }
    -> Browse paginated, filtered vehicle listings
5.  GET  /api/cms/get/blogs          -> Read blog articles
6.  GET  /api/cms/single/blog/{slug} -> Read single blog post
7.  GET  /api/cms/get/faqs           -> Read FAQs
8.  GET  /api/cms/get/aboutus        -> About Us page
9.  GET  /api/cms/get/testmonial     -> Customer testimonials
10. POST /api/user/chat/send         -> Chat with seller (JWT required)
11. POST /api/user/review/store      -> Submit a vehicle review (JWT required)
12. POST /api/user-update            -> Update own profile
13. POST /api/change-password        -> Change password
14. DELETE /api/delete/user          -> Delete own account
15. POST /api/logout                 -> JWT invalidated
```

### Password Reset Flow

```
1. POST /api/forget-password { email }
   -> OTP emailed to user (hashed + timestamped in DB)
2. POST /api/verify-otp-password { email, otp, action: "forgot_password" }
   -> OTP verified (15 min expiry window)
3. POST /api/reset-password { email, otp, password, password_confirmation }
   -> Password updated, OTP cleared from DB
```

---

## Setup & Installation

### Requirements

| Requirement | Minimum Version |
|---|---|
| PHP | 8.2+ |
| Composer | 2.x |
| Node.js | 18.x+ |
| npm | 9.x+ |
| MySQL / MariaDB | 8.0+ |

### Step-by-Step Installation

**1. Clone the repository**
```bash
git clone <repository-url>
cd r_realstate_laravel
```

**2. Install PHP dependencies**
```bash
composer install
```

**3. Install Node.js dependencies**
```bash
npm install
```

**4. Set up environment file**
```bash
cp .env.example .env
php artisan key:generate
```

**5. Configure `.env`**
```env
APP_NAME="AutoMarket"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=automarket_db
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=your@email.com
MAIL_FROM_NAME="${APP_NAME}"
```

**6. Generate JWT secret**
```bash
php artisan jwt:secret
```

**7. Run database migrations**
```bash
php artisan migrate
```

**8. Seed the database (optional)**
```bash
php artisan db:seed
```

**9. Build frontend assets**
```bash
# Development (with HMR):
npm run dev

# Production:
npm run build
```

**10. Start the application**
```bash
# Single server:
php artisan serve

# All services at once (recommended for development):
composer run dev
```

**11. (Optional) Start WebSocket server for real-time chat**
```bash
php artisan reverb:start
```

**Access the app:** http://localhost:8000
**Admin login:** http://localhost:8000/login

---

## Additional Notes

### File Upload Storage
All uploads go to `public/uploads/{folder}/`. Two upload utilities exist:
- `Controller::fileUpload()` - used by all web/admin controllers
- `Helper::fileUpload()` - static method for API-side uploads

Ensure `public/uploads/` is writable: `chmod -R 775 public/uploads`

### JWT Configuration
Settings live in `config/jwt.php`. Default TTL is 60 minutes. The `/api/refresh` endpoint issues new tokens. Always run `php artisan jwt:secret` on fresh installs.

### OTP Security
OTPs are 4-digit integers, **bcrypt-hashed** before DB storage. Verification uses `Hash::check()`. Expiry is enforced via `otp_created_at` (15 minutes). Ensure mail is configured or OTP delivery will silently fail.

### Spatie Permissions Setup
On fresh install, create the first admin role manually via `/role/create` in the admin panel, or seed it via a seeder. Without a valid role, the `AdminMiddleware` may block access to all backend routes.

### DataTables (Server-Side AJAX)
All admin list pages use Yajra DataTables. The same controller method handles both the page render and the AJAX data request, detected via `$request->ajax()`. jQuery and the DataTables JS library must be included in the admin layout.

### Environment-Sensitive Settings (Security Note)
The admin Settings pages for Mail, Stripe, and PayPal directly write to the `.env` file using `preg_replace()`. In production environments, restrict write access to `.env` and consider using a dedicated secrets manager instead.

### Namespace Conventions
- Backend web controllers: `App\Http\Controllers\Web\Backend\` (capital B)
- API controllers: `App\Http\Controllers\API\` (all caps)
- Mismatched namespaces will cause class-not-found errors at runtime.

### Queue Worker (Production)
OTP email notifications implement `ShouldQueue`. Run the worker in production:
```bash
php artisan queue:work --sleep=3 --tries=3 --daemon
```
Use **Supervisor** to keep the worker alive, or use **Laravel Horizon** for dashboard-managed queues.

---

<div align="center">

**Built with Laravel 11 | PHP 8.2+ | TailwindCSS | JWT | WebSockets**

</div>
