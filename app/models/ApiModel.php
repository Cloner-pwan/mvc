<?php

class ApiModel
{
    public function GET(
        string $tableName,
        ?int $limit = null,
        int $offset = 0,
        ?int $id = null,
    ) {
        Schema::assertCan($tableName, $id === null ? 'list' : 'show');
        $cols = "`" . implode("`,`", Schema::columns($tableName, 'read')) . "`";
        $pk = Schema::pk($tableName);
        $pdo = DataBase::connect();

        if ($id !== null) {
            $stmt = $pdo->prepare("SELECT $cols FROM `$tableName` WHERE `$pk` = :id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
        }

        if ($limit < 1 || $limit === null) {
            $limit = 50;
        }

        if ($limit > 100) {
            $limit = 100;
        }

        if ($offset < 0) {
            $offset = 0;
        }


        $stmt = $pdo->prepare("SELECT $cols FROM `$tableName` LIMIT :limit OFFSET :offset");
        $stmt->bindValue(":limit", $limit);
        $stmt->bindValue(":offset", $offset);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);

        // $dsn = DataBase::connect();
        // $query = "SELECT * FROM $tableName";

        // if ($limit !== null) {
        //     $query .= " LIMIT $limit OFFSET $offset";
        //     $stmt = $dsn->query($query);
        //     return $stmt->fetchAll(PDO::FETCH_OBJ);
        // }

        // if ($findByID !== null) {
        //     $query .= " WHERE $idName = $findByID";
        //     $stmt = $dsn->query($query);
        //     return $stmt->fetch(PDO::FETCH_OBJ);
        // }

        // $stmt = $dsn->query($query);
        // return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    public function POST(string $tableName, array $data = [])
    {
        Schema::assertCan($tableName, 'create');
        Schema::assertColumns($tableName, array_keys($data));
        $clean = Schema::validate($tableName, $data, true);

        $cols = '`' . implode('`,`', array_keys($clean)) . '`';
        $placeholders = implode(',', array_fill(0, count($clean), '?'));

        $pdo = DataBase::connect();
        $stmt = $pdo->prepare("INSERT INTO `$tableName` ($cols) VALUES ($placeholders)");
        $stmt->execute(array_values($clean));

        return $pdo->lastInsertId();

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