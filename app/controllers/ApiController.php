<?php
class ApiController extends Controller
{
    public function customers(?int $id = null)
    {
        header('Content-Type: application/json');

        $limit = isset($_GET['limit']) ? filter_var($_GET['limit'], FILTER_VALIDATE_INT) :
            null;

        $offset = isset($_GET['offset']) ? filter_var($_GET['offset'], FILTER_VALIDATE_INT) : 0;

        $model = new ApiModel();

        if ($id !== null) {
            $data = $model->GET("customers", null, 0, $id, "CustomerID");
        } else {
            $data = $model->GET("customers", $limit, $offset);
        }


        echo json_encode($data);
    }
}