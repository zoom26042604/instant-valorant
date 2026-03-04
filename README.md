# Instant Valorant


> A dynamic web application built with PHP and PostgreSQL, themed around video games.
> Users can manage a personal game library, unlock achievements, and administrators
> can manage the platform content.

---

## Table of Contents

- [Instant Valorant](#instant-valorant)
  - [Table of Contents](#table-of-contents)
  - [Tech Stack](#tech-stack)
  - [Prerequisites](#prerequisites)
  - [Getting Started](#getting-started)
    - [1. Clone the repository](#1-clone-the-repository)
    - [2. Configure environment variables](#2-configure-environment-variables)
    - [3. Start the containers](#3-start-the-containers)
    - [4. Seed the database](#4-seed-the-database)
  - [Default Credentials](#default-credentials)
  - [Database Management](#database-management)
  - [Project Structure](#project-structure)
  - [Features](#features)
    - [Authentication](#authentication)
    - [Role Management](#role-management)
    - [Games](#games)
    - [User Library](#user-library)
    - [Achievements](#achievements)
    - [Admin Panel](#admin-panel)
  - [API Routes](#api-routes)
    - [Auth](#auth)
    - [Games API](#games-api)
    - [Levels](#levels)
    - [Achievements API](#achievements-api)
    - [Profile](#profile)
    - [Admin](#admin)
  - [Contributors](#contributors)

---

## Tech Stack

| Layer       | Technology                  |
|-------------|-----------------------------|
| Language    | PHP 8.2 (no framework)      |
| ORM         | RedBeanPHP                  |
| Database    | PostgreSQL 16               |
| Web Server  | Nginx                       |
| Runtime     | Docker / Docker Compose     |
| DB UI       | Adminer                     |

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
docker compose up --build -d
```

The application will be available at [http://localhost:8080](http://localhost:8080).

### 4. Seed the database

Run the seed script once to create the default admin account, the 5 platform games, and their starter achievements:

```bash
docker exec instant-valorant-php-fpm-1 php /var/www/html/seed.php
```

---

## Default Credentials

| Role      | Email                          | Password  |
|-----------|--------------------------------|-----------|
| Admin     | `admin@instant-valorant.com`   | admin1234 |

> These credentials are for development only. Change them before any deployment.

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
│   └── database.php          # RedBeanPHP connection setup
├── docker/                   # Nginx and PHP Dockerfiles
├── public/
│   └── index.php             # Application entry point and router
├── src/
│   ├── Controllers/          # Request handlers
│   │   ├── AdminController.php
│   │   ├── AchievementController.php
│   │   ├── AuthController.php
│   │   ├── GameController.php
│   │   ├── LevelController.php
│   │   ├── ProfileController.php
│   │   ├── UserController.php
│   │   └── UserGameController.php
│   ├── Helpers/
│   │   └── Auth.php          # Session guards (requireAuth, requireAdmin)
│   ├── Models/               # Model definitions
│   └── Routes/
│       ├── api.php           # JSON API routes (/api/*)
│       └── web.php           # HTML web routes
├── views/
│   ├── admin/                # Admin panel views
│   ├── achievements/         # Achievement form views
│   ├── auth/                 # Login, register, dashboard
│   ├── games/                # Game CRUD views
│   ├── layout/               # Home page
│   ├── levels/               # Level CRUD views
│   └── profile/              # User profile and library views
├── seed.php                  # Database seeder (admin + games + achievements)
└── docker-compose.yml
```

---

## Features

### Authentication

- Register, login, and logout
- Session-based authentication with session regeneration on login
- Passwords hashed with Argon2id

### Role Management

| Role    | Capabilities                                      |
|---------|---------------------------------------------------|
| `user`  | Browse games, manage personal library, unlock achievements |
| `admin` | All user capabilities + full CRUD on games, levels, achievements, and user management |

### Games

- Public listing and detail pages with levels and achievements
- Admin CRUD for platform games
- 5 games seeded by default: League of Legends, Valorant, Mario Kart, Avatar: Frontiers of Pandora, Skyrim
- Levels associated to each game (name, description)

### User Library

- Add a platform game or a fully custom game entry (name, type, description, image)
- Each platform game can only be added once per user
- Playtime (minutes) and date added are generated randomly on insertion
- Edit custom entries and remove any entry

### Achievements

- Achievements are scoped to a platform game
- Admins create and delete achievements
- Users unlock achievements manually from a game page
- Adding a platform game to the library automatically unlocks its **Débutant** achievement

### Admin Panel

- Full list of registered users with role display
- Change any user's role between `user` and `admin`
- Delete users (cannot delete own account)
- Game management via the standard games section

---

## API Routes

All routes are prefixed with `/api`. Responses are JSON.

### Auth

| Method | Route               | Auth | Description        |
|--------|---------------------|------|--------------------|
| POST   | /api/auth/register  | —    | Create an account  |
| POST   | /api/auth/login     | —    | Log in             |
| POST   | /api/auth/logout    | —    | Log out            |

### Games API

| Method | Route                       | Auth  | Description                  |
|--------|-----------------------------|-------|------------------------------|
| GET    | /api/games                  | —     | List all games               |
| POST   | /api/games                  | Admin | Create a game                |
| POST   | /api/games/seed             | Admin | Seed default games           |
| GET    | /api/games/:id              | —     | Get a game                   |
| PUT    | /api/games/:id              | Admin | Update a game                |
| DELETE | /api/games/:id              | Admin | Delete a game                |

### Levels

| Method | Route                       | Auth  | Description                  |
|--------|-----------------------------|-------|------------------------------|
| GET    | /api/games/:id/levels       | —     | List levels for a game       |
| POST   | /api/games/:id/levels       | Admin | Create a level               |
| PUT    | /api/levels/:id             | Admin | Update a level               |
| DELETE | /api/levels/:id             | Admin | Delete a level               |

### Achievements API

| Method | Route                           | Auth  | Description                  |
|--------|---------------------------------|-------|------------------------------|
| GET    | /api/games/:id/achievements     | —     | List achievements for a game |
| POST   | /api/games/:id/achievements     | Admin | Create an achievement        |
| DELETE | /api/achievements/:id           | Admin | Delete an achievement        |

### Profile

| Method | Route                             | Auth | Description               |
|--------|-----------------------------------|------|---------------------------|
| GET    | /api/profile                      | User | Get current user profile  |
| GET    | /api/profile/games                | User | Get user library          |
| POST   | /api/profile/games                | User | Add a game to library     |
| PUT    | /api/profile/games/:id            | User | Update a library entry    |
| DELETE | /api/profile/games/:id            | User | Remove from library       |
| GET    | /api/profile/achievements         | User | Get unlocked achievements |
| POST   | /api/profile/achievements/:id     | User | Unlock an achievement     |

### Admin

| Method | Route                   | Auth  | Description          |
|--------|-------------------------|-------|----------------------|
| GET    | /api/admin/users        | Admin | List all users       |
| PUT    | /api/admin/users/:id    | Admin | Update user role     |
| DELETE | /api/admin/users/:id    | Admin | Delete a user        |

---

## Contributors

| Name              | Role                        | Contact                        |
|-------------------|-----------------------------|--------------------------------|
| Nathan Ferré      | Backend Developer           | `nathan.ferre@ynov.com`        |
| Laurine Camuset   | Frontend Developer          | `laurine.camuset@ynov.com`     |
