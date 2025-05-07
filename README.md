# Todo List Application

A modern, feature-rich todo list application built with Laravel and Vue.js. This application allows users to manage their tasks efficiently with a clean and intuitive interface.

## Features

- User authentication and authorization
- Create, read, update, and delete tasks
- Mark tasks as complete/incomplete
- Secure API endpoints
- Real-time task updates
- Responsive design

## Tech Stack

- **Backend**: Laravel 10.x
- **Frontend**: Vue.js 3.x
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **Styling**: Tailwind CSS

## Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js and NPM
- MySQL 5.7 or higher
- Git

## Installation

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd todo-list
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   ```

4. Create a copy of the environment file:
   ```bash
   cp .env.example .env
   ```

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Configure your database in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=todo_list
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

7. Run database migrations:
   ```bash
   php artisan migrate
   ```

8. Start the development server:
   ```bash
   php artisan serve
   ```

9. In a separate terminal, start the Vite development server:
   ```bash
   npm run dev
   ```

## Testing

The application includes a comprehensive test suite using PHPUnit. The tests cover both unit and feature testing:

### Unit Tests
- Task model creation and attributes
- Task completion status
- User relationships
- Required fields validation

### Feature Tests
- Task creation
- Task viewing
- Task updating
- Task deletion
- User authorization

To run the tests:
```bash
php artisan test
```

## API Endpoints

The application provides the following API endpoints:

### Authentication
- `POST /api/register` - Register a new user
- `POST /api/login` - Login user
- `POST /api/logout` - Logout user

### Tasks
- `GET /api/tasks` - Get all tasks for authenticated user
- `POST /api/tasks` - Create a new task
- `GET /api/tasks/{id}` - Get a specific task
- `PUT /api/tasks/{id}` - Update a task
- `DELETE /api/tasks/{id}` - Delete a task

## Project Structure

```
todo-list/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   └── Policies/
├── database/
│   ├── factories/
│   └── migrations/
├── resources/
│   └── js/
├── routes/
│   └── api.php
└── tests/
    ├── Feature/
    └── Unit/
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
