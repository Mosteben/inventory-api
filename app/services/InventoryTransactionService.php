<?php

namespace App\Services;

use Exception;
use App\Factories\InventoryTransactionFactory;
use App\Repositories\ProductRepository;
use App\Repositories\InventoryTransactionRepository;
use App\Services\ActivityLogService;
use App\Security\AuthContext;
use App\Enums\ActivityAction;

class InventoryTransactionService extends BaseService
{
    private ProductRepository $productRepository;

    private InventoryTransactionRepository $transactionRepository;
    private ActivityLogService $activityLogService;

    public function __construct()
    {
        parent::__construct();

        $this->productRepository =new ProductRepository($this->conn );

        $this->transactionRepository =new InventoryTransactionRepository( $this->conn);
        $this->activityLogService =new ActivityLogService();
    }

    public function stockIn(
        array $data
    ): array
    {
        $this->conn->beginTransaction();

        try {

            $product =
                $this->productRepository
                    ->getById(
                        $data['product_id']
                    );

            if (!$product) {

                throw new Exception(
                    'Product not found'
                );
            }

            $this->productRepository
                ->increaseStock(
                    $data['product_id'],
                    $data['quantity']
                );

            $transaction =
                InventoryTransactionFactory::create(
                    $data
                );

            $id =
                $this->transactionRepository
                    ->create(
                        $transaction
                    );
                    $user =
    AuthContext::user();

$this->activityLogService->log([

    'user_id' => (int)$user['id'],

    'action' => ActivityAction::STOCK_IN,

    'entity' => 'PRODUCT',

    'entity_id' => $data['product_id'],

    'description' =>
        'Stock In: +' .
        $data['quantity'] .
        ' for product ' .
        $product->getName()

]);

            $this->conn->commit();

            return [

                'id' => $id,

                'message' =>
                    'Stock added successfully'

            ];

        } catch (Exception $e) {

            $this->conn->rollBack();

            throw $e;
        }
    }

    public function stockOut(
        array $data
    ): array
    {
        $this->conn->beginTransaction();

        try {

            $product =
                $this->productRepository
                    ->getById(
                        $data['product_id']
                    );

            if (!$product) {

                throw new Exception(
                    'Product not found'
                );
            }

            if (
                $product->getQuantity() <
                $data['quantity']
            ) {

                throw new Exception(
                    'Insufficient stock'
                );
            }

            $this->productRepository
                ->reduceStock(
                    $data['product_id'],
                    $data['quantity']
                );

            $transaction =
                InventoryTransactionFactory::create(
                    $data
                );

            $id =
                $this->transactionRepository
                    ->create(
                        $transaction
                    );
                    $user =
    AuthContext::user();

$this->activityLogService->log([

    'user_id' => (int)$user['id'],

    'action' => ActivityAction::STOCK_OUT,

    'entity' => 'PRODUCT',

    'entity_id' => $data['product_id'],

    'description' =>
        'Stock Out: -' .
        $data['quantity'] .
        ' for product ' .
        $product->getName()

]);

            $this->conn->commit();

            return [

                'id' => $id,

                'message' =>
                    'Stock removed successfully'

            ];

        } catch (Exception $e) {

            $this->conn->rollBack();

            throw $e;
        }
    }

    public function getAll(): array
    {
        return
            $this->transactionRepository
                ->getAll();
    }

    public function getByProductId(
        int $productId
    ): array
    {
        return
            $this->transactionRepository
                ->getByProductId(
                    $productId
                );
    }
}