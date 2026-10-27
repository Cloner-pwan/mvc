<?php

class API
{
    public static function GET(
        string $tableName,
        ?int $limit = null,
        int $offset = 0,
        ?int $id = null,
    ) {
        header('Content-Type: application/json');

        $model = new ApiModel();

        $data = $model->GET($tableName, $limit, $offset, $id);
        return json_encode($data);
    }

    public static function POST($tableName, $colsName = [], $data = [])
    {
        $model = new ApiModel();
        $insert = $model->POST($tableName, $colsName, $data);
        return $insert;

    }

    public static function PATCH(string $tableName, int $id, array $colsName = [], array $data = [], string $idName)
    {
        $model = new ApiModel();
        $update = $model->PATCH($tableName, $id, $colsName, $data, $idName);
        return $update;

    }

    public static function DELETE(string $tableName, int $id, string $idName = "id")
    {

        $model = new ApiModel();
        $delete = $model->DELETE($tableName, $id, $idName);
        return $delete;

    }

}