# Health Information System

A comprehensive health information system for managing clients and health programs/services.

## Features

-   Create and manage health programs (TB, Malaria, HIV, etc.)
-   Register and manage clients in the system
-   Enroll clients in one or more health programs
-   Search for clients from a list of registered clients
-   View client profiles, including the programs they are enrolled in
-   RESTful API for external system integration

## Technologies Used

-   **Backend**: Laravel 10 with PHP 8.2
-   **Database**: SQLite (for simplicity and easy setup)
-   **Authentication**: Laravel Sanctum for API authentication
-   **Testing**: PHPUnit for automated tests

## Requirements

-   PHP 8.1 or higher
-   Composer
-   Node.js and NPM (for frontend)

## Installation

1. Clone the repository

    ```bash
    git clone https://github.com/yourusername/health-information-system.git
    cd health-information-system
    ```

2. Install PHP dependencies

    ```bash
    composer install
    ```

3. Create the environment file

    ```bash
    cp .env.example .env
    ```

4. Configure your environment file for SQLite

    ```
    DB_CONNECTION=sqlite
    ```

5. Create the SQLite database file

    ```bash
    touch database/database.sqlite
    ```

6. Generate application key

    ```bash
    php artisan key:generate
    ```

7. Run migrations and seed the database

    ```bash
    php artisan migrate --seed
    ```

8. Start the development server
    ```bash
    php artisan serve
    ```

## API Documentation

### Authentication

-   **POST /api/register**: Register a new user
-   **POST /api/login**: Login and get access token
-   **GET /api/user**: Get authenticated user
-   **POST /api/logout**: Logout (revoke token)

### Health Programs

-   **GET /api/health-programs**: List all health programs
-   **POST /api/health-programs**: Create a new health program (admin only)
-   **GET /api/health-programs/{id}**: View a specific health program
-   **PUT /api/health-programs/{id}**: Update a health program (admin only)
-   **DELETE /api/health-programs/{id}**: Delete a health program (admin only)
-   **GET /api/health-programs/{id}/clients**: Get clients enrolled in a specific program

### Clients

-   **GET /api/clients**: List all clients
-   **POST /api/clients**: Register a new client
-   **GET /api/clients/{id}**: View a specific client
-   **PUT /api/clients/{id}**: Update a client
-   **DELETE /api/clients/{id}**: Delete a client
-   **GET /api/clients/search?query={searchTerm}**: Search for clients
-   **GET /api/clients/{id}/programs**: Get programs the client is enrolled in

### Enrollments

-   **GET /api/enrollments**: List all enrollments
-   **POST /api/enrollments**: Create a new enrollment
-   **GET /api/enrollments/{id}**: View a specific enrollment
-   **PUT /api/enrollments/{id}**: Update an enrollment
-   **DELETE /api/enrollments/{id}**: Delete an enrollment
-   **POST /api/enroll-client**: Enroll a client in multiple programs at once

## Testing

Run the automated tests with:

```bash
php artisan test
```

## Security Considerations

-   API authentication using Laravel Sanctum
-   Input validation for all requests
-   Role-based access control (admin vs. doctor)
-   Protection against common web vulnerabilities

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
