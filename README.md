# Instant Valorant

A dynamic web application built with PHP and PostgreSQL, themed around video games. Users can manage a personal game library, unlock achievements, and administrators can manage the platform content.

---

## Tech Stack

- **PHP 8.2** — application logic (no framework)
- **RedBeanPHP** — ORM / database abstraction
- **PostgreSQL 16** — relational database
- **Nginx** — web server
- **Docker / Docker Compose** — containerized environment
- **Adminer** — database management UI

---

## Prerequisites

- Docker
- Docker Compose

---

## Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/zoom26042604/instant-valorant.git
cd instant-valorant
```

### 2. Configure environment variables

Copy `.env.example` to `.env` if needed. The default values are:

```env
DB_HOST=db
DB_PORT=5432
DB_NAME=instant_valorant
DB_USER=valorant
DB_PASSWORD=secret
APP_PORT=8080
```

### 3. Start the containers

```bash
docker compose up -d
```

The application will be available at `http://localhost:8080`.

### 4. Seed the database

Run the seed script once to create the default admin account and the 5 platform games with their starter achievements:

```bash
docker exec instant-valorant-php-fpm-1 php /var/www/html/seed.php
```

---

## Default Credentials

| Role  | Email                      | Password  |
|-------|----------------------------|-----------|
| Admin | admin@instant-valorant.com | admin1234 |

---

## Database Management

Adminer is available at [http://localhost:8081](http://localhost:8081).

| Field    | Value            |
|----------|------------------|
| System   | PostgreSQL       |
| Server   | db               |
| Username | valorant         |
| Password | secret           |
| Database | instant_valorant |

---

## Project Structure

```text
.
├── config/
│   └── database.php          # RedBeanPHP setup
├── docker/                   # Nginx and PHP Dockerfiles
├── public/
│   └── index.php             # Application entry point
├── src/
│   ├── Controllers/          # Application controllers
│   ├── Helpers/
│   │   └── Auth.php          # Authentication guards
│   ├── Models/               # Model classes
│   └── Routes/
│       ├── api.php           # JSON API routes
│       └── web.php           # Web (HTML) routes
├── views/
│   ├── admin/                # Admin panel views
│   ├── achievements/         # Achievement form views
│   ├── auth/                 # Login, register, dashboard views
│   ├── games/                # Game CRUD views
│   ├── layout/               # Home page
│   ├── levels/               # Level CRUD views
│   └── profile/              # User profile and library views
├── seed.php                  # Database seeder
└── docker-compose.yml
```

---

## Features

### Authentication

- Register, login, logout
- Session-based authentication
- Passwords hashed with Argon2id

### Roles

- `user` — standard access
- `admin` — full platform management

### Games

- Public listing and detail pages
- Admin CRUD for platform games (minimum 5 seeded)
- Levels associated to each game (admin managed)

### User Library

- Add any platform game or a fully custom game entry
- Each platform game can only appear once per user
- Playtime and date added are generated randomly on add
- Edit and remove entries

### Achievements

- Achievements are linked to platform games
- Admin can create and delete achievements
- Users unlock achievements from a game detail page
- Adding a platform game automatically unlocks its starter achievement

### Admin Panel

- List all registered users
- Change user roles
- Delete users
- Manage games via the games section

---

## API Routes

All API routes are prefixed with `/api`.

| Method | Route                         | Auth  | Description                  |
|--------|-------------------------------|-------|------------------------------|
| POST   | /api/auth/register            | —     | Create an account            |
| POST   | /api/auth/login               | —     | Log in                       |
| POST   | /api/auth/logout              | —     | Log out                      |
| GET    | /api/games                    | —     | List all games               |
| POST   | /api/games                    | Admin | Create a game                |
| POST   | /api/games/seed               | Admin | Seed default games           |
| GET    | /api/games/:id                | —     | Get a game                   |
| PUT    | /api/games/:id                | Admin | Update a game                |
| DELETE | /api/games/:id                | Admin | Delete a game                |
| GET    | /api/games/:id/levels         | —     | List levels for a game       |
| POST   | /api/games/:id/levels         | Admin | Create a level               |
| PUT    | /api/levels/:id               | Admin | Update a level               |
| DELETE | /api/levels/:id               | Admin | Delete a level               |
| GET    | /api/games/:id/achievements   | —     | List achievements for a game |
| POST   | /api/games/:id/achievements   | Admin | Create an achievement        |
| DELETE | /api/achievements/:id         | Admin | Delete an achievement        |
| GET    | /api/profile                  | User  | Get current user profile     |
| GET    | /api/profile/games            | User  | Get user library             |
| POST   | /api/profile/games            | User  | Add a game to library        |
| PUT    | /api/profile/games/:id        | User  | Update a library entry       |
| DELETE | /api/profile/games/:id        | User  | Remove from library          |
| GET    | /api/profile/achievements     | User  | Get unlocked achievements    |
| POST   | /api/profile/achievements/:id | User  | Unlock an achievement        |
| GET    | /api/admin/users              | Admin | List all users               |
| PUT    | /api/admin/users/:id          | Admin | Update user role             |
| DELETE | /api/admin/users/:id          | Admin | Delete a user                |
