# Laravel 11 Project Setup

## Introduction

This project integrates with a third-party API to keep user attributes up to date. The API has the following limits:
- Up to 50 batch requests per hour (each batch can contain up to 1,000 records).
- Up to 3,600 individual requests per hour.

We aim to handle up to 40,000 user attribute updates per hour efficiently.

## Prerequisites

- PHP 8.2
- Composer
- MySQL database

## Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/codetec-info/laravel-vue-school.git
    cd your-project
    ```

2. **Install dependencies:**

    ```bash
    composer install
    ```

3. **Copy the `.env` file and configure your environment variables:**

    ```bash
    cp .env.example .env
    ```

   Update the following variables in your `.env` file:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password

    CACHE_DRIVER=database
    QUEUE_CONNECTION=database
    ```

4. **Generate an application key:**

    ```bash
    php artisan key:generate
    ```

5. **Run the database migrations:**

    ```bash
    php artisan migrate
    ```

## Configuration

### Caching

We are using the file cache driver. Ensure the `CACHE_DRIVER` in your `.env` file is set to `database`.

### Queue

We are using the database queue driver. Ensure the `QUEUE_CONNECTION` in your `.env` file is set to `database`.


