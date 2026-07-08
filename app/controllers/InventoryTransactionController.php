<?php

namespace App\Controllers;

use Exception;
use App\Services\InventoryTransactionService;

class InventoryTransactionController
{
    private static InventoryTransactionService $service;

    private static function service(): InventoryTransactionService
    {
        if (!isset(self::$service)) {

            self::$service =
                new InventoryTransactionService();
        }

        return self::$service;
    }

    /**
     * GET /inventory
     */
    public static function index(): void
    {
        echo json_encode(
            self::service()->getAll()
        );
    }

    /**
     * GET /inventory/product/{id}
     */
    public static function byProduct(
        int $id
    ): void
    {
        echo json_encode(
            self::service()
                ->getByProductId($id)
        );
    }

    /**
     * POST /inventory/stock-in
     */
    public static function stockIn(): void
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
                    ->stockIn($data);

            http_response_code(201);

            echo json_encode(
                $result
            );

        } catch (Exception $e) {

            http_response_code(400);

            echo json_encode([
                'message' =>
                    $e->getMessage()
            ]);
        }
    }

    /**
     * POST /inventory/stock-out
     */
    public static function stockOut(): void
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
                    ->stockOut($data);

            echo json_encode(
                $result
            );

        } catch (Exception $e) {

            http_response_code(400);

            echo json_encode([
                'message' =>
                    $e->getMessage()
            ]);
        }
    }
}