# Simple Blog Using Laravel 9 Framework

## Requirements

-   MySQL installed
-   PHP (Minimum PHP version of 8.0)

## Installation

-   Clone this repo

```bash
git clone https://github.com/arcenme/simple-blog-laravel.git
```

-   Change Directory

```bash
cd simple-blog-laravel
```

-   Initiate `.env` file

```bash
cp .env.example .env
```

-   Modify `.env` file with your correct database credentials
-   Install Third-party libraries

```
composer install
```

-   Generate new key

```
php artisan key:generate
```

-   Migrate database

```
php artisan migrate:fresh --seed
```

**P.s** if you are seeding the 'blogs' table then temporarily disable Blameable in the 11th row of Blog Models (`app\Models\Blog.php`). This is important because Blameable requires login user authentication.

-   Enable to access public disk

```
php artisan storage:link
```

-   Start Laravel's local development server

```
php artisan serve
```

## Features

### Landing page

-   List of blog entry
-   Comments for each blog entry

### Dashboard

-   Login with multiple role. (Admin and general User).
-   Entries Admin
-   Comment Management
-   User profile
