<?php
class ApiController extends Controller
{
    public function customers(?int $id = null)
    {

        $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : null;
        $offset = (int) ($_GET['offset'] ?? 0);

        $data = API::GET("customers", $limit, $offset, $id, "CustomerID");

        echo $data;

    }

    public function products(?int $id = null)
    {
        $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : null;
        $offset = (int) ($_GET['offset'] ?? 0);

        $data = API::GET("products", $limit, $offset, $id, "ProductID");

        echo $data;


    }
}