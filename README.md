# Task Management System API

A backend API for a task management system built with Laravel. This API allows users to manage tasks, users, and generate reports.

## Features

- **User Management**: Register, log in, and manage user accounts.
- **Task Management**: Create, update, delete, and assign tasks.
- **Reports**: Export tasks to Excel or PDF formats.
- **Admin Functions**: Admin users can manage all tasks and users.
- **Email Notifications**: Notifications for task updates and reports.

## Setup Instructions

1. **Clone the repository**:
    ```bash
    git clone https://github.com/1970Mr/task-management-system-api.git
    cd task-management-system-api
    ```

2. **Install dependencies**:
    ```bash
    composer install
    ```

3. **Copy the `.env` file**:
    ```bash
    cp .env.example .env
    ```

4. **Configure environment settings**:
    - Open the `.env` file and set up your database and mail server configurations.
    - Add the following lines to your `.env` file to configure the admin user:
    ```env
    ADMIN_NAME=admin
    ADMIN_EMAIL=admin@example.com
    ADMIN_PASSWORD=password
    ```

5. **Generate application key**:
    ```bash
    php artisan key:generate
    ```

6. **Create an admin user and run migrations**:
    ```bash
    php artisan migrate --seed
    ```

7. **Start the queue worker** (if using queues):
    ```bash
    php artisan queue:work
    ```

8. **Serve the application**:
    ```bash
    php artisan serve
    ```

## Usage

1. **Register and login**:
    - Use the provided API endpoints to register a new user or log in with existing credentials.
    - Use the admin credentials specified in the `.env` file to access admin functionalities.

2. **Manage tasks**:
    - Use the API endpoints to create, update, delete, and assign tasks.

3. **Generate reports**:
    - Use the endpoints for exporting task data in Excel or PDF formats.

4. **Admin functionalities**:
    - Admin users can manage all tasks and users via the API.

## Frontend

For the frontend of this project, please refer to the [Task Management System UI](https://github.com/1970Mr/task-management-system-ui) repository.

## Contributing

Contributions are welcome! Please fork the repository and submit pull requests.

## License

This project is open-source and available under the [MIT License](LICENSE).
