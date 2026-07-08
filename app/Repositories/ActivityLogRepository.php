<?php

namespace App\Repositories;

use App\Contracts\ActivityLogRepositoryInterface;
use App\Factories\ActivityLogFactory;
use App\Models\ActivityLog;

class ActivityLogRepository
    extends BaseRepository
    implements ActivityLogRepositoryInterface
{
    public function create(
        ActivityLog $log
    ): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO activity_logs
            (
                user_id,
                action,
                entity,
                entity_id,
                description
            )
            VALUES
            (
                :user_id,
                :action,
                :entity,
                :entity_id,
                :description
            )
        ");

        $stmt->execute([

            ':user_id' => $log->getUserId(),

            ':action' => $log->getAction(),

            ':entity' => $log->getEntity(),

            ':entity_id' => $log->getEntityId(),

            ':description' => $log->getDescription()

        ]);

        return (int)$this->conn->lastInsertId();
    }

    public function getAll(): array
    {
        $stmt = $this->conn->query("
            SELECT *
            FROM activity_logs
            ORDER BY created_at DESC
        ");

        $rows = $stmt->fetchAll(
            \PDO::FETCH_ASSOC
        );

        $logs = [];

        foreach ($rows as $row) {

            $logs[] =
                ActivityLogFactory::create(
                    $row
                );
        }

        return $logs;
    }

    public function getByUserId(
        int $userId
    ): array
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM activity_logs
            WHERE user_id = :user_id
            ORDER BY created_at DESC
        ");

        $stmt->execute([

            ':user_id' => $userId

        ]);

        $rows = $stmt->fetchAll(
            \PDO::FETCH_ASSOC
        );

        $logs = [];

        foreach ($rows as $row) {

            $logs[] =
                ActivityLogFactory::create(
                    $row
                );
        }

        return $logs;
    }
}