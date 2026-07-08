<?php

namespace App\Services;

use App\Factories\ProductFactory;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\ActivityLogService;
use App\Security\AuthContext;
use App\Enums\ActivityAction;

class ProductService extends BaseService
{
    private ProductRepository $repository;
    private ActivityLogService $activityLogService;

    public function __construct()
    {
        parent::__construct();

        $this->repository =new ProductRepository($this->conn);
        $this->activityLogService = new ActivityLogService();
    }

    public function getAll(
    array $filters = []
): array
{
    return $this->repository
        ->getAll(
            $filters
        );
}

    public function getById(
        int $id
    ): ?Product
    {
        return $this->repository
            ->getById($id);
    }

    public function create(
        array $data
    ): array
    {
        $product =
            ProductFactory::create(
                $data
            );

        $id =
            $this->repository->create(
                $product
            );
            $user = AuthContext::user();
            $this->activityLogService->log([

    'user_id' => (int)$user['id'],

    'action' => ActivityAction::CREATE,

    'entity' => 'PRODUCT',

    'entity_id' => $id,

    'description' =>
        'Created product: ' .
        $product->getName()

]);

        return [
            'id' => $id,
            'message' =>
                'Product created successfully'
        ];
    }

   public function update(
    int $id,
    array $data
): bool
{
    $product =
        ProductFactory::create(
            $data
        );

    $result =
        $this->repository->update(
            $id,
            $product
        );

    if ($result) {

        $user =
            AuthContext::user();

        $this->activityLogService->log([

            'user_id' => (int)$user['id'],

            'action' => ActivityAction::UPDATE,

            'entity' => 'PRODUCT',

            'entity_id' => $id,

            'description' =>
                'Updated product: ' .
                $product->getName()

        ]);
    }

    return $result;
}

public function delete(
    int $id
): bool
{
    $product =
        $this->repository->getById(
            $id
        );

    if (!$product) {
        return false;
    }

    $result =
        $this->repository->delete(
            $id
        );

    if ($result) {

        $user =
            AuthContext::user();

        $this->activityLogService->log([

            'user_id' => (int)$user['id'],

            'action' => ActivityAction::DELETE,

            'entity' => 'PRODUCT',

            'entity_id' => $id,

            'description' =>
                'Deleted product: ' .
                $product->getName()

        ]);
    }

    return $result;
}
    public function getLowStock(
    int $limit = 5
): array
{
    return
        $this->repository
            ->getLowStock(
                $limit
            );
}
public static function lowStock()
{
    $limit =
        isset($_GET['limit'])
        ? (int)$_GET['limit']
        : 5;

    $service =
        new ProductService();

    $products =
        $service->getLowStock(
            $limit
        );

    Response::json(
        $products
    );
}
public function search(
    string $keyword
): array
{
    return
        $this->repository
            ->search(
                $keyword
            );
}
}