<?php

namespace App\Controllers;

use App\Services\SupplierService;
use App\Utils\Response;
use App\Validation\Validator;

class SupplierController
{
    public static function index()
    {
        $service = new SupplierService();

        Response::json(
            $service->getAll()
        );
    }

    public static function show($id)
    {
        $service = new SupplierService();

        $supplier =
            $service->getById(
                (int)$id
            );

        if (!$supplier) {

            Response::error(
                'Supplier not found',
                404
            );

            return;
        }

        Response::json(
            $supplier
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

        $errors = Validator::required(
            $data ?? [],
            ['name']
        );

        if (!empty($errors)) {

            Response::json(
                [
                    'errors' => $errors
                ],
                400
            );

            return;
        }

        $service =
            new SupplierService();

        Response::json(
            $service->create($data),
            201
        );
    }

    public static function update($id)
    {
        $data = json_decode(
            file_get_contents(
                'php://input'
            ),
            true
        );

        $errors = Validator::required(
            $data ?? [],
            ['name']
        );

        if (!empty($errors)) {

            Response::json(
                [
                    'errors' => $errors
                ],
                400
            );

            return;
        }

        $service =
            new SupplierService();

        $supplier =
            $service->getById(
                (int)$id
            );

        if (!$supplier) {

            Response::error(
                'Supplier not found',
                404
            );

            return;
        }

        $service->update(
            (int)$id,
            $data
        );

        Response::json([
            'message' =>
                'Supplier updated successfully'
        ]);
    }

    public static function destroy($id)
    {
        try {

            $service =
                new SupplierService();

            $supplier =
                $service->getById(
                    (int)$id
                );

            if (!$supplier) {

                Response::error(
                    'Supplier not found',
                    404
                );

                return;
            }

            $service->delete(
                (int)$id
            );

            Response::json([
                'message' =>
                    'Supplier deleted successfully'
            ]);

        } catch (\Exception $e) {

            Response::error(
                $e->getMessage(),
                400
            );
        }
    }
}