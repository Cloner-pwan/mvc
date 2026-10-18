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

    public function POST(string $tableName, array $colsName = [], array $data = [])
    {
        $dsn = DataBase::connect();

        if (count($colsName) !== count($data)) {
            return false;
        }

        $tableCols = '`' . implode('`,`', $colsName) . "`";
        $placeholders = implode(',', array_fill(0, count($colsName), '?'));

        $values = [];
        foreach ($colsName as $i => $col) {
            $values[] = $data[$col] ?? $data[$i] ?? null;
        }

        $stmt = $dsn->prepare("INSERT INTO `$tableName` ($tableCols) VALUES ($placeholders)");
        return $stmt->execute($values);

    }
}