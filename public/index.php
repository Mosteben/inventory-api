<?php
header("Access-Control-Allow-Origin: http://localhost:5173");

header("Access-Control-Allow-Headers: Content-Type, Authorization");

header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}



require_once "../vendor/autoload.php";

use App\Router\Router;

use App\Controllers\AuthController;
use App\Controllers\ProductController;
use App\Controllers\CategoryController;
use App\Controllers\SupplierController;
use App\Controllers\OrderController;
use App\Controllers\DashboardController;
use App\Controllers\InventoryTransactionController;

$router = new Router();

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

$router->post(
    '/auth/register',
    [AuthController::class, 'register']
);

$router->post(
    '/auth/login',
    [AuthController::class, 'login']
);

/*
|--------------------------------------------------------------------------
| Products
|--------------------------------------------------------------------------
*/

$router->get(
    '/products',
    [ProductController::class, 'index']
);
$router->get(
    '/products/low-stock',
    [ProductController::class, 'lowStock'],
    [
        'auth',
        'role:admin,employee'
    ]
);
$router->get(
    '/products/search',
    [ProductController::class, 'search']
);

$router->get(
    '/products/{id}',
    [ProductController::class, 'show']
);

$router->post(
    '/products',
    [ProductController::class, 'store'],
    [
        'auth',
        'role:admin,employee'
    ]
);

$router->put(
    '/products/{id}',
    [ProductController::class, 'update'],
    [
        'auth',
        'role:admin,employee'
    ]
);

$router->delete(
    '/products/{id}',
    [ProductController::class, 'destroy'],
    [
        'auth',
        'role:admin'
    ]
);

/*
|--------------------------------------------------------------------------
| Categories
|--------------------------------------------------------------------------
*/

$router->get(
    '/categories',
    [CategoryController::class, 'index']
);

$router->get(
    '/categories/{id}',
    [CategoryController::class, 'show']
);

$router->post(
    '/categories',
    [CategoryController::class, 'store'],
    [
        'auth',
        'role:admin,employee'
    ]
);

$router->put(
    '/categories/{id}',
    [CategoryController::class, 'update'],
    [
        'auth',
        'role:admin,employee'
    ]
);

$router->delete(
    '/categories/{id}',
    [CategoryController::class, 'destroy'],
    [
        'auth',
        'role:admin'
    ]
);

/*
|--------------------------------------------------------------------------
| Suppliers
|--------------------------------------------------------------------------
*/

$router->get(
    '/suppliers',
    [SupplierController::class, 'index'],
    [
        'auth',
        'role:admin,employee'
    ]
);

$router->get(
    '/suppliers/{id}',
    [SupplierController::class, 'show'],
    [
        'auth',
        'role:admin,employee'
    ]
);

$router->post(
    '/suppliers',
    [SupplierController::class, 'store'],
    [
        'auth',
        'role:admin,employee'
    ]
);

$router->put(
    '/suppliers/{id}',
    [SupplierController::class, 'update'],
    [
        'auth',
        'role:admin,employee'
    ]
);

$router->delete(
    '/suppliers/{id}',
    [SupplierController::class, 'destroy'],
    [
        'auth',
        'role:admin'
    ]
);

/*
|--------------------------------------------------------------------------
| Orders
|--------------------------------------------------------------------------
*/

$router->get(
    '/orders',
    [OrderController::class, 'index'],
    [
        'auth',
        'role:admin,employee'
    ]
);

$router->get(
    '/orders/{id}',
    [OrderController::class, 'show'],
    [
        'auth',
        'role:admin,employee,customer'
    ]
);

$router->post(
    '/orders',
    [OrderController::class, 'store'],
    [
        'auth',
        'role:customer'
    ]
);

$router->put(
    '/orders/{id}/cancel',
    [OrderController::class, 'cancel'],
    [
        'auth',
        'role:admin,employee'
    ]
);


$router->get(
    '/dashboard',
    [DashboardController::class, 'index'],
    [
        'auth',
        'role:admin,employee'
    ]
);

/*
|--------------------------------------------------------------------------
| Inventory Transactions
|--------------------------------------------------------------------------
*/

$router->get(
    '/inventory',
    [InventoryTransactionController::class, 'index'],
    [
        'auth',
        'role:admin,employee'
    ]
);

$router->get(
    '/inventory/product/{id}',
    [InventoryTransactionController::class, 'byProduct'],
    [
        'auth',
        'role:admin,employee'
    ]
);

$router->post(
    '/inventory/stock-in',
    [InventoryTransactionController::class, 'stockIn'],
    [
        'auth',
        'role:admin,employee'
    ]
);

$router->post(
    '/inventory/stock-out',
    [InventoryTransactionController::class, 'stockOut'],
    [
        'auth',
        'role:admin,employee'
    ]
);

/*
|--------------------------------------------------------------------------
| Start Router
|--------------------------------------------------------------------------
*/

$router->resolve();