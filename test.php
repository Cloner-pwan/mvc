<?php

class ApiModel
{
    public function GET(string $table, ?int $limit = null, int $offset = 0, ?int $id = null)
    {
        Schema::assertCan($table, $id === null ? 'list' : 'show');

        $cols = '`' . implode('`,`', Schema::columns($table, 'read')) . '`';
        $pk   = Schema::pk($table);
        $pdo  = DataBase::connect();

        // one row
        if ($id !== null) {
            $stmt = $pdo->prepare("SELECT $cols FROM `$table` WHERE `$pk` = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ) ?: null;     // null = not found
        }

        // list, with a default and a maximum
        $limit  = max(1, min($limit ?? 50, 100));
        $offset = max(0, $offset);

        $stmt = $pdo->prepare("SELECT $cols FROM `$table` LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function POST(string $table, array $data): string
    {
        Schema::assertCan($table, 'create');
        Schema::assertColumns($table, array_keys($data));
        $clean = Schema::validate($table, $data, true);

        $cols         = '`' . implode('`,`', array_keys($clean)) . '`';
        $placeholders = implode(',', array_fill(0, count($clean), '?'));

        $pdo  = DataBase::connect();
        $stmt = $pdo->prepare("INSERT INTO `$table` ($cols) VALUES ($placeholders)");
        $stmt->execute(array_values($clean));

        return $pdo->lastInsertId();
    }

    public function PATCH(string $table, int $id, array $data): int
    {
        Schema::assertCan($table, 'update');
        Schema::assertColumns($table, array_keys($data));
        $clean = Schema::validate($table, $data, false);

        $pk   = Schema::pk($table);
        $sets = array_map(fn($col) => "`$col` = ?", array_keys($clean));

        $params   = array_values($clean);
        $params[] = $id;                                    // the last "?" is the WHERE

        $stmt = DataBase::connect()->prepare(
            "UPDATE `$table` SET " . implode(', ', $sets) . " WHERE `$pk` = ?"
        );
        $stmt->execute($params);

        return $stmt->rowCount();
    }

    public function DELETE(string $table, int $id): int
    {
        Schema::assertCan($table, 'delete');

        $pk   = Schema::pk($table);
        $stmt = DataBase::connect()->prepare("DELETE FROM `$table` WHERE `$pk` = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }
}