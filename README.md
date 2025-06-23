# Redis Cache Laravel Project

This is a Laravel-based RESTful API project featuring user authentication (register, login, logout) using Laravel Sanctum, and CRUD operations for projects using redis cache. The API is protected by Sanctum authentication middleware.

## Features
- User registration, login, and logout with token-based authentication (Sanctum)
- Project CRUD (Create, Read, Update, Delete) endpoints
- Pagination for project listing
- Feature tests for authentication and project endpoints

## Requirements
- PHP >= 8.1
- Composer
- MySQL or SQLite (for testing)
- Node.js & npm (for frontend assets, if needed)

## Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd redp
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install && npm run build # if using frontend assets
   ```

3. **Copy and configure environment files**
   ```bash
   cp .env.example .env
   cp .env.example .env.testing
   # Edit .env and .env.testing for your DB and mail settings
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Run migrations**
   ```bash
   php artisan migrate:fresh --seed
   # For tests:
   php artisan migrate --env=testing
   ```

6. **Run the development server**
   ```bash
   php artisan serve
   ```

## API Endpoints

- `POST /api/register` — Register a new user
- `POST /api/login` — Login and receive a token
- `POST /api/logout` — Logout (requires Bearer token)
- `GET /api/projects` — List projects (requires Bearer token)
- `POST /api/projects` — Create project (requires Bearer token)
- `GET /api/projects/{id}` — Show project (requires Bearer token)
- `PUT /api/projects/{id}` — Update project (requires Bearer token)
- `DELETE /api/projects/{id}` — Delete project (requires Bearer token)

## Running Tests

```bash
php artisan test
```

## Caching
- The project listing endpoint uses Laravel's cache to store paginated results for 60 minutes, improving performance for repeated requests.
- You can configure the cache driver and duration in the code or `.env` file.

## Observers
- The `ProjectObserver` is registered in `AppServiceProvider` and listens to model events for the `Project` model.
- Observers allow you to handle logic automatically when projects are created, updated, or deleted (e.g., logging, notifications, or cache invalidation).

## Notes
- All project routes are protected by Sanctum (`auth:sanctum`).
- Update the `Project` model and migrations to match your required fields.
- Adjust `.env.testing` for your test database.

---

Feel free to contribute or open issues for improvements!
