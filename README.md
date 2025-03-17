# User Management API

A RESTful API for user management with authentication and role-based access control built using Laravel.

## Overview

This API provides functionality for user registration, authentication, and management. It includes features like user creation, retrieval, updating, and deletion, with role-based access control to ensure secure operations.

## Authentication

The API uses Laravel Sanctum for token-based authentication. Users can register and login to receive an access token, which must be included in the headers of subsequent requests.

## Authorization

The API implements role-based access control. By default, users are assigned the "user" role. Certain endpoints are restricted to users with the "admin" role.

## API Endpoints

### Authentication

| Method | Endpoint         | Description                                 | Access      |
|--------|------------------|---------------------------------------------|-------------|
| POST   | /api/auth/register | Register a new user and get an access token | Public      |
| POST   | /api/auth/login  | Login and get an access token               | Public      |
| GET    | /api/auth/user   | Get current authenticated user's data       | Authenticated |
| POST   | /api/auth/logout | Logout and invalidate the current token     | Authenticated |

### User Management

| Method | Endpoint      | Description                  | Access      |
|--------|---------------|------------------------------|-------------|
| GET    | /api/users    | Get paginated list of users  | Admin only  |
| POST   | /api/users    | Create a new user            | Admin only  |
| GET    | /api/users/{id} | Get a specific user by ID  | Authenticated |
| PUT    | /api/users/{id} | Update a specific user     | Admin only  |
| DELETE | /api/users/{id} | Delete a specific user     | Admin only  |

## Request and Response Format

### Authentication

#### Register

**Request:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response (201 Created):**
```json
{
  "status": "success",
  "message": "User registered successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "role": "user",
      "created_at": "2025-03-17T12:00:00.000000Z",
      "updated_at": "2025-03-17T12:00:00.000000Z"
    },
    "access_token": "1|example_token_string",
    "token_type": "Bearer"
  }
}
```

#### Login

**Request:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response (200 OK):**
```json
{
  "status": "success",
  "message": "Logged in successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "role": "user",
      "created_at": "2025-03-17T12:00:00.000000Z",
      "updated_at": "2025-03-17T12:00:00.000000Z"
    },
    "access_token": "1|example_token_string",
    "token_type": "Bearer"
  }
}
```

### User Management

#### Get Users (with pagination)

**Response (200 OK):**
```json
{
    "status": "success",
    "data": {
        "user": {
            "id": 4,
            "name": "Ang",
            "email": "ang@mail",
            "role": "admin",
            "created_at": "2025-03-17 23:22:26",
            "updated_at": "2025-03-17 23:22:26"
        }
    }
}
```

### Logout


**Response (200 OK):**
```json
{
    "status": "success",
    "message": "Logged out successfully"
}
```
## Error Handling

The API returns appropriate HTTP status codes and consistent error responses:

```json
{
  "status": "error",
  "message": "Error message description"
}
```
## Admin management
#### Get Users (with pagination)

**Response (200 OK):**
```json
{
    "status": "success",
    "data": {
        "users": [
            {
                "id": 1,
                "name": "Sodnom",
                "email": "ardan@mail",
                "role": "admin",
                "created_at": "2025-03-17T11:52:48.000000Z",
                "updated_at": "2025-03-17T11:52:48.000000Z"
            }
        ],
        "pagination": {
            "total": 1,
            "per_page": 15,
            "current_page": 1,
            "last_page": 1,
            "from": 1,
            "to": 1
        }
    }
}
```

#### Put Users

**Response (200 OK):**
```json
{
    "status": "success",
    "message": "User updated successfully",
    "data": {
        "id": 1,
        "name": "Ivan",
        "email": "ardan@mail",
        "role": "admin",
        "created_at": "2025-03-17 11:52:48",
        "updated_at": "2025-03-17 16:32:01"
    }
}
```
Common error codes:
- 400: Bad Request (validation errors)
- 401: Unauthorized (invalid or missing authentication)
- 403: Forbidden (insufficient permissions)
- 404: Not Found (resource not found)
- 422: Unprocessable Entity (validation errors)
- 500: Internal Server Error

## Authentication Headers

For authenticated endpoints, include the token in the Authorization header:

```
Authorization: Bearer {your_token}
```

## Pagination

The users list endpoint supports pagination with the following query parameters:
- `page`: Page number (default: 1)
- `per_page`: Items per page (default: 15, maximum: 100)

Example: `/api/users?page=2&per_page=20`

## Installation

1. Clone the repository
2. Set up your `.env` file
```
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=username
DB_PASSWORD=pwd
```
3. Start the server
```
docker-compose up --build
```
4. Go to the php-fpm container
```
docker compose exec php-fpm bash
```
5. From the php-fpm container, install the dependencies:
```
composer install
```
6. From the php-fpm container, run the migrations:
```
php artisan migrate
```


## Requirements

- PHP 8.0+
- Laravel 9.0+
- MySQL or compatible database

## Security

- All passwords are hashed using Laravel's built-in Hash facade
- API uses token-based authentication with Laravel Sanctum
- Role-based access control protects sensitive endpoints
