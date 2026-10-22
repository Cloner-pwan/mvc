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

    public function PATCH(
        string $tableName,
        int $id,
        array $colsName = [],
        array $data = [],
        ?string $idName = "id"
    ) {
        $dsn = DataBase::connect();

        $save = [];

        if (count($colsName) !== count($data) || empty($colsName) || empty($data)) {
            return false;
        }

        foreach ($colsName as $col => $value) {
            $col = "`" . $value . "`";
            array_push($save, $col);
        }

        $counter = 0;
        $dump = "";

        foreach ($save as $i => $value) {
            $dump .= $value . " = " . ":value$counter" . ",";
            $counter++;
        }

        $dump = substr($dump, 0, -1);



        $stmt = $dsn->prepare("UPDATE $tableName SET $dump WHERE $idName = :id");

        foreach ($data as $i => $value) {
            $stmt->bindValue(":value$i", $value);
        }

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();

    }

    public function DELETE(string $tableName, int $id, ?string $idName = "id"): int
    {

        $dsn = DataBase::connect();
        $stmt = $dsn->prepare("DELETE FROM $tableName WHERE `$idName` = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        
        // if the row is deleted , rowCount returns 1 else returns 0;
        return $stmt->rowCount();
        
    }
}