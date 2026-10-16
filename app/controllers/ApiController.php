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

    public function addProducts()
    {
        $colsName = ['ProductName', 'SupplierID', 'CategoryID', 'Unit', 'Price'];
        $data = ['Iphone 15 PRO MAX', 1, 1, '12 boxes', 20];
        $insert = Api::POST('products', $colsName, $data);
    }


    public function test()
    {
    }
}