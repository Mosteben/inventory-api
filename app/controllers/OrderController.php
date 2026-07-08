<?php

namespace App\Controllers;

use Exception;
use App\Services\OrderService;

class OrderController
{
    private static OrderService $service;

    private static function service(): OrderService
    {
        if (!isset(self::$service)) {
            self::$service =
                new OrderService();
        }

        return self::$service;
    }

    public static function index(): void
    {
        echo json_encode(
            self::service()->getAll()
        );
    }

    public static function show(
        int $id
    ): void
    {
        $order =
            self::service()
                ->getById($id);

        if (!$order) {

            http_response_code(404);

            echo json_encode([
                'message' =>
                    'Order not found'
            ]);

            return;
        }

        echo json_encode($order);
    }

    public static function store(): void
    {
        try {

            $data =
                json_decode(
                    file_get_contents(
                        'php://input'
                    ),
                    true
                );

            $result =
                self::service()
                    ->create($data);

            http_response_code(201);

            echo json_encode(
                $result
            );

        } catch (
            Exception $e
        ) {

            http_response_code(400);

            echo json_encode([
                'message' =>
                    $e->getMessage()
            ]);
        }
    }

    public static function cancel(
        int $id
    ): void
    {
        $success =
            self::service()
                ->cancel($id);

        if (!$success) {

            http_response_code(404);

            echo json_encode([
                'message' =>
                    'Order not found'
            ]);

            return;
        }

        echo json_encode([
            'message' =>
                'Order cancelled successfully'
        ]);
    }
}
