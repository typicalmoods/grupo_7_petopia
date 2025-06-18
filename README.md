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
    - Frontend: http://localhost:8081
    - Backend API: http://localhost:5051

## API Endpoints
### Users
### Users
- Register: `POST /api/v1/users/register`
  - Description: Allows new users to register by providing their details.
  - Request Body:
    ```json
    {
      "username": "usertest-1",
      "password": "1234Abc",
      "email": "test-1@example.com",
      "phone": "645632568",
      "address": "Street example, 1",
      "birthdate": "1984-04-17"
    }
    ```
  - Response:
    ```json
    {
      "message": "User registered successfully",
      "user": {
          "address": "Street example, 1",
          "birthdate": "1984-04-17",
          "email": "test-1@example.com",
          "id": 2,
          "phone": "645632568",
          "username": "usertest-1"
      }
    }
    ```
- Login: `POST /api/v1/users/login`
  - Description: Allows users to login by providing their username and password.
  - Request Body:
    ```json
    {
      "username": "usertest-1",
      "password": "1234Abc"
    }
    ```
  - Response:
    ```json
    {
      "message": "Successfully logged in"
    }
    ```
- Logout: `POST /api/v1/users/logout`
  - Description: Allows users to logout by providing a session cookie stored in client.
  - Response:
    ```json
    {
      "message": "Successfully logged out"
    }
    ```
- Update: `PATCH /api/v1/users/{id}`
  - Description: Allows users to modify their details by providing those fields that are going to change.
  - Request Body:
    ```json
    {
      "username": "usertest-3",
      "password": "12345Abc",
      "email": "test-3@example.com",
      "phone": "0987654321",
      "address": "Street example, 1",
      "birthdate": "1984-04-17"
    }
    ```
  - Response:
    ```json
    {
      "message": "User updated successfully",
      "user": {
          "address": "Street example, 1",
          "birthdate": "1984-04-17",
          "email": "test-3@example.com",
          "id": 1,
          "phone": "0987654321",
          "username": "usertest-3"
      }
    }
    ```

### Products
- Get all products: `GET /api/v1/products`
  - Description: Fetch all products of the application.
  - Response:
    ```json
    [
      {
          "animal_species": "Dog",
          "brand": "Nature's Variety",
          "category": "Food",
          "description": "High-quality dog food for all sterilized breeds",
          "discount": "0.00",
          "id": 85,
          "name": "Dog Sterilized Food",
          "price": "29.99",
          "stock": 100,
          "url_image": "assets/product_1.jpg"
      },
      {
          "animal_species": "Cat",
          "brand": "Wellness Core",
          "category": "Food",
          "description": "Nutritious cat food for healthy sterilized cats",
          "discount": "0.00",
          "id": 86,
          "name": "Cat Sterilized Food",
          "price": "24.99",
          "stock": 50,
          "url_image": "assets/product_2.jpg"
      }
    ]
    ```
- Get product by id: `GET /api/v1/products/{id}`
  - Description: Fetch a product by its identifier.
  - Response:
    ```json
    {
        "animal_species": "Dog",
        "brand": "Nature's Variety",
        "category": "Food",
        "description": "High-quality dog food for all sterilized breeds",
        "discount": "0.00",
        "id": 85,
        "name": "Dog Sterilized Food",
        "price": "29.99",
        "stock": 100,
        "url_image": "assets/product_1.jpg"
    }
    ```

### Carts
- Get all carts: `GET /api/v1/carts`
  - Description: Fetch all carts purchased by the user who is identified by the session cookie.
  - Response:
    ```json
    [
      {
        "id": 7,
        "product_id": 97,
        "quantity": 4,
        "user_id": 2
      },
      {
        "id": 8,
        "product_id": 97,
        "quantity": 4,
        "user_id": 2
      },
      {
        "id": 9,
        "product_id": 101,
        "quantity": 1,
        "user_id": 2
      }
    ]
    ```
- Get cart by id: `GET /api/v1/carts/{id}`
  - Description: Fetch a cart details purchased by the user who is identified by the session cookie.
  - Response:
    ```json
    {
      "id": 8,
      "product_id": 97,
      "quantity": 4,
      "user_id": 2
    }
    ```
- Create carts: `POST /api/v1/carts`
  - Description: Fetch a product by its identifier.
  - Request Body:
    ```json
    {
      "products": [
        {
          "product_id": 97,
          "quantity": 4
        },
        {
          "product_id": 101,
          "quantity": 1
        }
      ]
    }
    ```
  - Response:
    ```json
    [
      {
        "id": 8,
        "product_id": 97,
        "quantity": 4,
        "user_id": 2
      },
      {
        "id": 9,
        "product_id": 101,
        "quantity": 1,
        "user_id": 2
      }
    ]
    ```
- Cancel cart: `POST /api/v1/carts/{id}/cancel`
  - Description: Cancels a cart that was purchased by user who is identified by the session cookie.
  - Response:
    ```json
    {
      "created_at": "2025-06-16T17:49:17",
      "id": 43,
      "product_id": 109,
      "quantity": 4,
      "status": "CANCELLED",
      "user_id": 2
    }
    ```

### Health Check
- Health: `GET /health`

## Database Migrations
- Migrations are managed using Flyway.
- Migration scripts are located in `database/migrations`.
- Rollback scripts are located in `database/rollback`.

## Setup mocked data
- There is a utility script to create initial data for the products table in database.
- This utility is located in: `database/import_data`.
- Initial data values are stored in file `products_csv`.
- To use it, you must run service `import_data` in `docker-compose.yml`.

## Environment Variables
The following environment variables are used in the project:

- `APP_PORT`: Port for the Flask application (default: 5000).
- `ENCRYPT_SECRET_KEY`: Secret key for session management.
- `DATABASE_URL`: Database connection URL.

## Postman Collection
A Postman collection is included in the project: `petopia-collection.postman_collection.json`. Import it into Postman to test the API endpoints.