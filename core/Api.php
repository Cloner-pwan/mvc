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

    public static function POST($tableName, $data = [])
    {
        $model = new ApiModel();
        $insert = $model->POST($tableName, $data);
        return $insert;
    }

    public static function PATCH(string $tableName, int $id, array $data = [])
    {
        $model = new ApiModel();
        $update = $model->PATCH($tableName, $id, $data);
        return $update;
    }

    public static function DELETE(string $tableName, int $id)
    {
        $model = new ApiModel();
        $delete = $model->DELETE($tableName, $id);
        return $delete;
    }

}