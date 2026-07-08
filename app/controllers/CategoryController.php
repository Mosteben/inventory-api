<?php

namespace App\Controllers;

use App\Services\CategoryService;
use App\Utils\Response;
use App\Validation\Validator;

class CategoryController
{
    public static function index()
    {
        $service = new CategoryService();

        Response::json(
            $service->getAll()
        );
    }

    public static function show(
        $id
    )
    {
        $service = new CategoryService();

        $category =
            $service->getById(
                (int)$id
            );

        if (!$category) {

            Response::error(
                'Category not found',
                404
            );

            return;
        }

        Response::json(
            $category
        );
    }

    public static function store()
    {
        $data = json_decode(
            file_get_contents(
                'php://input'
            ),
            true
        );

        $errors =
            Validator::required(
                $data ?? [],
                ['name']
            );

        if (!empty($errors)) {

            Response::json([
                'errors' => $errors
            ], 400);

            return;
        }

        $service =
            new CategoryService();

        $category =
            $service->create(
                $data
            );

        Response::json(
            $category,
            201
        );
    }

    public static function update(
        $id
    )
    {
        $data = json_decode(
            file_get_contents(
                'php://input'
            ),
            true
        );

        $service =
            new CategoryService();

        $category =
            $service->getById(
                (int)$id
            );

        if (!$category) {

            Response::error(
                'Category not found',
                404
            );

            return;
        }

        $errors =
            Validator::required(
                $data ?? [],
                ['name']
            );

        if (!empty($errors)) {

            Response::json([
                'errors' => $errors
            ], 400);

            return;
        }

        $service->update(
            (int)$id,
            $data
        );

        Response::json([
            'message' =>
                'Updated successfully'
        ]);
    }

    public static function destroy(
        $id
    )
    {
        $service =
            new CategoryService();

        $category =
            $service->getById(
                (int)$id
            );

        if (!$category) {

            Response::error(
                'Category not found',
                404
            );

            return;
        }

        $service->delete(
            (int)$id
        );

        Response::json([
            'message' =>
                'Deleted successfully'
        ]);
    }
}