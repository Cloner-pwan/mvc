<?php

class Schema
{
    // Cache: the config file is read once per request, then reused
    private static ?array $tables = null;

    /* ---------- 1. Loading ---------- */

    private static function load(): array
    {
        if (self::$tables === null) {
            // a PHP file can "return" an array; require gives it back to us
            self::$tables = require __DIR__ . '/../app/config/schema.php';
        }
        return self::$tables;
    }

    // The ONLY place that decides "this table doesn't exist"
    private static function table(string $name): array
    {
        $tables = self::load();

        if (!isset($tables[$name])) {
            throw new InvalidArgumentException('Table not allowed');
        }
        return $tables[$name];
    }

    /* ---------- 2. Getters ---------- */

    public static function pk(string $table): string
    {
        return self::table($table)['pk'];
    }

    // $mode is 'read' or 'write'
    public static function columns(string $table, string $mode = 'read'): array
    {
        return self::table($table)[$mode] ?? [];   // missing key = nothing allowed
    }

    /* ---------- 3. Checks ---------- */

    // Returns true/false, for use inside an if
    public static function can(string $table, string $action): bool
    {
        try {
            $rules = self::table($table);
        } catch (InvalidArgumentException $e) {
            return false;
        }
        return in_array($action, $rules['allow'] ?? [], true);
    }

    // Throws, for use as a guard at the top of a model method
    public static function assertCan(string $table, string $action): void
    {
        if (!self::can($table, $action)) {
            throw new InvalidArgumentException('Operation not allowed');
        }
    }

    public static function assertColumns(string $table, array $cols, string $mode = 'write'): void
    {
        if (empty($cols)) {
            throw new InvalidArgumentException('No columns given');
        }

        $allowed = self::columns($table, $mode);

        foreach ($cols as $col) {
            if (!in_array($col, $allowed, true)) {
                throw new InvalidArgumentException('Column not allowed');
            }
        }
    }

    /* ---------- 4. Validation ---------- */

    // $data = ['Price' => '20', 'ProductName' => 'Tea']
    // Returns the cleaned values (cast to the right PHP type)
    public static function validate(string $table, array $data, bool $isCreate): array
    {
        $rules = self::table($table);
        $required = $rules['required'] ?? [];
        $types = $rules['types'] ?? [];

        // On create, every required column must be present
        if ($isCreate) {
            foreach ($required as $col) {
                if (!array_key_exists($col, $data)) {
                    throw new InvalidArgumentException("$col is required");
                }
            }
        }

        $clean = [];

        foreach ($data as $col => $value) {
            // a required column can't be set to empty (create or update)
            if (in_array($col, $required, true) && ($value === null || $value === '')) {
                throw new InvalidArgumentException("$col cannot be empty");
            }

            $clean[$col] = self::cast($col, $value, $types[$col] ?? 'string:255');
        }

        return $clean;
    }

    private static function cast(string $col, $value, string $type)
    {
        if ($value === null) {
            return null;                      // NULL is fine for optional columns
        }

        // "string:255" -> type "string", max 255
        [$type, $max] = array_pad(explode(':', $type, 2), 2, null);

        switch ($type) {
            case 'int':
                if (is_int($value) || (is_string($value) && preg_match('/^-?\d+$/', $value))) {
                    return (int) $value;
                }
                throw new InvalidArgumentException("$col must be an integer");

            case 'float':
                if ((is_int($value) || is_float($value) || is_numeric($value)) && is_finite((float) $value)) {
                    return (float) $value;
                }
                throw new InvalidArgumentException("$col must be a number");

            case 'date':
                $d = is_string($value) ? DateTime::createFromFormat('Y-m-d', $value) : false;
                if ($d && $d->format('Y-m-d') === $value) {
                    return $value;
                }
                throw new InvalidArgumentException("$col must be a date (YYYY-MM-DD)");

            case 'text':
                if (is_string($value)) {
                    return $value;
                }
                throw new InvalidArgumentException("$col must be text");

            case 'string':
                if (!is_string($value)) {
                    throw new InvalidArgumentException("$col must be text");
                }
                if ($max !== null && mb_strlen($value) > (int) $max) {
                    throw new InvalidArgumentException("$col is too long (max $max)");
                }
                return $value;
        }

        throw new InvalidArgumentException("Unknown type for $col");   // schema mistake, fail closed
    }
}