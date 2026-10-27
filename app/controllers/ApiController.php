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
        header("Content-Type: application/json");

        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            return $this->json(['error' => "Method not allowed"], 405);
        }

        $body = json_decode(file_get_contents("php://input"), true);

        if (!isset($body['colsName'], $body['data'])) {
            return $this->json(['error' => "Invalid Body !"], 400);
        }

        try {

            $insert = Api::POST('products', $body['colsName'], $body['data']);
            return $this->json(['success' => true], 201);

        } catch (InvalidArgumentException $e) {

            return $this->json(['error' => $e->getMessage()], 422);

        } catch (PDOException $e) {

            error_log($e->getMessage());
            return $this->json(['error' => 'DataBase Error !'], 500);

        }

        // $colsName = ['ProductName', 'SupplierID', 'CategoryID', 'Unit', 'Price'];
        // $data = ['Iphone 15 PRO MAX', 1, 1, '12 boxes', 20];
        // $insert = Api::POST('products', $colsName, $data);
    }

    public function update($tableName, $id)
    {
        header("Content-Type: application/json");

        if ($_SERVER['REQUEST_METHOD'] !== "PATCH") {
            return $this->json(['error' => "Method not allowed"], 405);
        }

        $body = json_decode(file_get_contents("php://input"), true);

        if (!isset($body['colsName'], $body['data'])) {
            return $this->json(['error' => 'Invalid body !'], 400);
        }

        try {

            $update = API::PATCH($tableName, $id, $body['colsName'], $body['data'], 'ProductID');
            return $this->json(['success' => true], 201);

        } catch (InvalidArgumentException $e) {

            return $this->json(['error' => 'DataBase Error !'], 422);

        } catch (PDOException $e) {

            error_log($e->getMessage());
            return $this->json(['error' => $e->getMessage()], 500);

        }
    }

    public function delete(?int $id)
    {
        header("Content-Type: application/json");

        if ($_SERVER['REQUEST_METHOD'] !== "DELETE") {
            return $this->json(['error' => 'Method not allowed'], 405);
        }

        if ((int) $id < 1 || !ctype_digit((string) $id)) {
            return $this->json(['error' => 'Invalid ID'], 400);
        }

        try {
            $delete = API::DELETE('products', $id, 'ProductID');
            if ($delete === 0) {
                return $this->json(['error' => 'Product not found !'], 404);
            } else {
                return $this->json(['success' => 'Product deleted successfully !'], 200);
            }

        } catch (InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], 422);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return $this->json(['error' => 'Database Error !'], 500);
        }
    }

    public function employee(?int $id = null)
    {
        $limit = isset($_GET['limit']) === true ? (int) $_GET['limit'] : null;
        $offset = isset($_GET['offset']) === true ? (int) $_GET['offset'] : 0;

        $data = API::GET("employees", $limit, $offset, $id);
        echo $data;
    }

    private function json(array $payload, int $status = 200)
    {
        http_response_code($status);
        echo json_encode($payload);
        exit;
    }
}