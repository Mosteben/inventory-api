<?php

namespace App\Services;

use Exception;
use App\Models\Order;
use App\Enums\OrderStatus;
use App\Factories\OrderFactory;
use App\Validation\OrderValidator;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Security\AuthContext;
use App\Factories\InventoryTransactionFactory;
use App\Repositories\InventoryTransactionRepository;
use App\Services\ActivityLogService;
use App\Enums\ActivityAction;

class OrderService extends BaseService
{
    private OrderRepository $orderRepository;
    private ProductRepository $productRepository;
    private InventoryTransactionRepository $inventoryRepository;
    private ActivityLogService $activityLogService;

    public function __construct()
    {
        parent::__construct();

        $this->orderRepository = new OrderRepository($this->conn);
        $this->productRepository = new ProductRepository($this->conn);
        $this->inventoryRepository = new InventoryTransactionRepository($this->conn);
        $this->activityLogService =  new ActivityLogService();
    }

    public function getAll(): array
    {
        return $this->orderRepository->getAll();
    }

    public function getById(int $id): ?Order
    {
        return $this->orderRepository->getById($id);
    }

    public function create(array $data): array
    {
        OrderValidator::validate($data);

        try {
            $this->conn->beginTransaction();

            $order = OrderFactory::createForCreate($data);
            $user = AuthContext::user();
            $order->setUserId( (int)$user['id']);

            $total = 0;
            $items = [];

            foreach ($order->getItems() as $item) {

                $product = $this->productRepository->getById(
                    $item->getProduct()->getId()
                );

                if (!$product) {
                    throw new Exception('Product not found');
                }

                if ($product->getQuantity() < $item->getQuantity()) {
                    throw new Exception('Insufficient stock');
                }

                $total += $product->getPrice() * $item->getQuantity();

                $items[] = [
                    'product_id' => $product->getId(),
                    'quantity' => $item->getQuantity(),
                    'price' => $product->getPrice()
                ];
            }

            $orderId = $this->orderRepository->create([
                'user_id' => $order->getUserId(),
                'total' => $total,
                'status' => OrderStatus::PENDING
            ]);

            foreach ($items as $item) {

                $this->orderRepository->createOrderItem([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                $this->productRepository->reduceStock(
                    $item['product_id'],
                    $item['quantity']
                );
            }
            $this->inventoryRepository->create(

    InventoryTransactionFactory::create([

        'product_id' => $item['product_id'],

        'user_id' => $order->getUserId(),

        'type' => 'OUT',

        'quantity' => $item['quantity'],

        'note' => 'Order #' . $orderId

    ])

);
$this->activityLogService->log([

    'user_id' => $order->getUserId(),

    'action' => ActivityAction::CREATE,

    'entity' => 'ORDER',

    'entity_id' => $orderId,

    'description' =>
        'Created Order #' . $orderId

]);

            $this->conn->commit();

            return [
                'order_id' => $orderId,
                'total' => $total,
                'message' => 'Order created successfully'
            ];

        } catch (Exception $e) {

            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }

            throw $e;
        }
    }

    public function cancel(int $id): bool
    {
        try {
            $this->conn->beginTransaction();

            $order = $this->orderRepository->getById($id);

            if (!$order) {
                throw new Exception('Order not found');
            }

            $items = $this->orderRepository->getOrderItems($id);

            foreach ($items as $item) {
                $this->productRepository->restoreStock(
                    $item['product_id'],
                    $item['quantity']
                );
            }
            $this->inventoryRepository->create(

    InventoryTransactionFactory::create([

        'product_id' => $item['product_id'],

        'user_id' => $order->getUserId(),

        'type' => 'IN',

        'quantity' => $item['quantity'],

        'note' => 'Cancel Order #' . $id

    ])

);

            $result = $this->orderRepository->update($id, [
                'status' => OrderStatus::CANCELLED
            ]);
            $this->activityLogService->log([

    'user_id' => $order->getUserId(),

    'action' => ActivityAction::UPDATE,

    'entity' => 'ORDER',

    'entity_id' => $id,

    'description' =>
        'Cancelled Order #' . $id

]);

            $this->conn->commit();

            return $result;

        } catch (Exception $e) {

            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }

            throw $e;
        }
    }
}

