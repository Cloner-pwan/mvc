<?php

class API
{
    public static function GET(
        string $tableName,
        ?int $limit = null,
        int $offset = 0,
        ?int $findByID = null,
        ?string $idName = "id"
    ) {
        header('Content-Type: application/json');

        $model = new ApiModel();

        $id = $findByID;

        if ($id !== null) {
            $data = $model->GET($tableName, null, 0, $id, $idName);
        } else {
            $data = $model->GET($tableName, $limit, $offset);
        }


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