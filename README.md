# Inventory Management System API

Backend REST API built with Native PHP + MySQL.

---

## Requirements

- PHP 8.2+
- Composer
- MySQL / MariaDB
- Apache (XAMPP)

---

## Installation

Clone project

```bash
git clone https://github.com/Mosteben/inventory-api.git
```

Enter project

```bash
cd inventory-api
```

Install packages

```bash
composer install
```

---

## Database

Import

```
database/inventory.sql
```

---

## Environment

Update

```
config/database.php
```

Example

```php
host = localhost

database = inventory

username = root

password =
```

---

## Start

Apache

MySQL

Visit

```
http://localhost/inventory-api/public
```

---

## Authentication

Login

```
POST /auth/login
```

Take token

```
Authorization: Bearer YOUR_TOKEN
```

---

## API Modules

- Authentication
- Products
- Categories
- Suppliers
- Orders
- Inventory
- Dashboard

---

## Technologies

- PHP 8
- PDO
- MySQL
- JWT
- Composer
- REST API

---

Developed by

Mostafa Alaaeldin
