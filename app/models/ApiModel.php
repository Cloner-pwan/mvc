<?php

class ApiModel
{
    public function GET(
        string $tableName,
        ?int $limit = null,
        int $offset = 0,
        ?int $findByID = null,
        ?string $idName = "id"
    ) {
        $dsn = DataBase::connect();
        $query = "SELECT * FROM $tableName";

        if ($limit !== null) {
            $query .= " LIMIT $limit OFFSET $offset";
            $stmt = $dsn->query($query);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        if ($findByID !== null) {
            $query .= " WHERE $idName = $findByID";
            $stmt = $dsn->query($query);
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        $stmt = $dsn->query($query);
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }
}