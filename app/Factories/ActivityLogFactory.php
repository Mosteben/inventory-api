<?php

namespace App\Factories;

use App\Models\ActivityLog;

class ActivityLogFactory
{
    public static function create(
        array $data
    ): ActivityLog
    {
        $log = new ActivityLog();

        if (isset($data['id'])) {

            $log->setId(
                (int)$data['id']
            );
        }

        if (isset($data['user_id'])) {

            $log->setUserId(
                (int)$data['user_id']
            );
        }

        if (isset($data['action'])) {

            $log->setAction(
                $data['action']
            );
        }

        if (isset($data['entity'])) {

            $log->setEntity(
                $data['entity']
            );
        }

        if (isset($data['entity_id'])) {

            $log->setEntityId(
                (int)$data['entity_id']
            );
        }

        $log->setDescription(
            $data['description'] ?? null
        );

        $log->setCreatedAt(
            $data['created_at'] ?? null
        );

        return $log;
    }
}