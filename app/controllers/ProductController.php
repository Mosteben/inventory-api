<?php

namespace App\Controllers;

use App\Services\ProductService;
use App\Utils\Response;
use App\Validation\Validator;

class ProductController
{
    public static function index()
    {
        $service = new ProductService();

        $products = $service->getAll( $_GET);

        Response::json($products);
    }

    public static function store()
    {
        $data = json_decode(
            file_get_contents('php://input'),
            true
        );

        $errors = Validator::required(
            $data ?? [],
            ['name', 'sku']
        );

        if (!empty($errors)) {
            Response::json([
                'errors' => $errors
            ], 400);

            return;
        }

        $service = new ProductService();

        $product = $service->create($data);

        Response::json($product, 201);
    }

    public static function show($id)
    {
        $service = new ProductService();

        $product = $service->getById((int)$id);

        if (!$product) {
            Response::error(
                'Product not found',
                404
            );

            return;
        }

        Response::json($product);
    }

    public static function update($id)
    {
        $data = json_decode(
            file_get_contents('php://input'),
            true
        );

        $service = new ProductService();

        $product = $service->getById((int)$id);

        if (!$product) {
            Response::error(
                'Product not found',
                404
            );

            return;
        }

        $errors = Validator::required(
            $data ?? [],
            ['name', 'sku']
        );

        if (!empty($errors)) {
            Response::json([
                'errors' => $errors
            ], 400);

            return;
        }

        $service->update((int)$id, $data);

        Response::json([
            'message' => 'Updated successfully'
        ]);
    }

    public static function destroy($id)
    {
        $service = new ProductService();

        $product = $service->getById((int)$id);

        if (!$product) {
            Response::error(
                'Product not found',
                404
            );

            return;
        }

        $service->delete((int)$id);

        Response::json([
            'message' => 'Deleted successfully'
        ]);
    }
    public static function lowStock()
{
    $limit = isset($_GET['limit'])
        ? (int)$_GET['limit']
        : 5;

    $service = new ProductService();

    $products = $service->getLowStock($limit);

    Response::json($products);
}
public static function search()
{
    $keyword =
        $_GET['q'] ?? '';

    $service =
        new ProductService();

    Response::json(

        $service->search(
            $keyword
        )

    );
}
}
