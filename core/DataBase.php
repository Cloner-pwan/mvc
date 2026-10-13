<?php
class DataBase
{
    public static function connect()
    {
        try {

            $conn = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=utf8mb4", USERNAME, PASSWORD);

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;

        } catch (PDOException $e) {
            die("Could not connect to the Database. Error: " . $e->getMessage());
        }
    }
}