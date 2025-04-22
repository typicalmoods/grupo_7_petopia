# Petopia

Petopia is a web application that provides a backend API built with Flask and a frontend served using Nginx. The project includes user registration, login, and logout functionalities, as well as a health check endpoint.

## Project Structure

## Features

- **Backend**:
  - Built with Flask.
  - User registration, login, and logout endpoints.
  - Database integration using SQLAlchemy.
  - Health check endpoint.

- **Frontend**:
  - Static HTML served using Nginx.

- **Database**:
  - MySQL database with Flyway migrations.

## Prerequisites
- Docker and Docker Compose installed on your machine.

## Setup and Run

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd <repository-folder>
2. Start the application using Docker Compose:
    ```bash
    docker-compose up --build
3. Access the application:
    - Frontend: http://localhost:8080
    - Backend API: http://localhost:5050

## API Endpoints
### Users
- Register: `POST /api/v1/users/register`
- Login: `POST /api/v1/users/login`
- Logout: `POST /api/v1/users/logout`
- Update: `PATCH /api/v1/users/{id}`

### Health Check
- Health: `GET /health`

## Database Migrations
- Migrations are managed using Flyway.
- Migration scripts are located in migrations.
- Rollback scripts are located in rollback.

## Environment Variables
The following environment variables are used in the project:

- `APP_PORT`: Port for the Flask application (default: 5000).
- `ENCRYPT_SECRET_KEY`: Secret key for session management.
- `DATABASE_URL`: Database connection URL.

## Postman Collection
A Postman collection is included in the project: `petopia-collection.postman_collection.json`. Import it into Postman to test the API endpoints.