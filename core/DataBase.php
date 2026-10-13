<?php

class DataBase
{
    private static $conn = null;

    public static function connect()
    {
        if (self::$conn === null) {
            self::$conn = new PDO(
                "mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=utf8mb4",
                USERNAME,
                PASSWORD,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        }

        return self::$conn;
    }

}