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

}