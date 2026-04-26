<?php
/**
 * Base Model with PDO database methods
 */
class Model
{
    protected ?PDO $db = null;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function query(string $sql, array $params = []): PDOStatement|bool
    {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            if (APP_DEBUG) {
                die('Query Error: ' . $e->getMessage() . '<br>SQL: ' . $sql);
            }
            return false;
        }
    }

    public function findAll(string $table, array $where = [], string $order = '', int $limit = 0, int $offset = 0): array
    {
        $sql = "SELECT * FROM `{$table}`";
        $params = [];

        if (!empty($where)) {
            $conditions = [];
            foreach ($where as $col => $val) {
                $conditions[] = "`{$col}` = ?";
                $params[] = $val;
            }
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        if ($order) {
            $sql .= " ORDER BY {$order}";
        }

        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
            if ($offset > 0) {
                $sql .= " OFFSET {$offset}";
            }
        }

        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function findOne(string $table, array $where): ?array
    {
        $conditions = [];
        $params = [];
        foreach ($where as $col => $val) {
            $conditions[] = "`{$col}` = ?";
            $params[] = $val;
        }
        $sql = "SELECT * FROM `{$table}` WHERE " . implode(' AND ', $conditions) . " LIMIT 1";
        $stmt = $this->query($sql, $params);
        $row = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;
        return $row ?: null;
    }

    public function findById(string $table, int $id): ?array
    {
        return $this->findOne($table, ['id' => $id]);
    }

    public function insert(string $table, array $data): int|false
    {
        $cols   = implode(', ', array_map(fn($c) => "`{$c}`", array_keys($data)));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql    = "INSERT INTO `{$table}` ({$cols}) VALUES ({$placeholders})";
        $stmt   = $this->query($sql, array_values($data));
        return $stmt ? (int)$this->db->lastInsertId() : false;
    }

    public function update(string $table, array $data, array $where): bool
    {
        $sets = [];
        $params = [];
        foreach ($data as $col => $val) {
            $sets[]   = "`{$col}` = ?";
            $params[] = $val;
        }
        $conditions = [];
        foreach ($where as $col => $val) {
            $conditions[] = "`{$col}` = ?";
            $params[]     = $val;
        }
        $sql  = "UPDATE `{$table}` SET " . implode(', ', $sets) . " WHERE " . implode(' AND ', $conditions);
        $stmt = $this->query($sql, $params);
        return $stmt !== false;
    }

    public function delete(string $table, array $where): bool
    {
        $conditions = [];
        $params     = [];
        foreach ($where as $col => $val) {
            $conditions[] = "`{$col}` = ?";
            $params[]     = $val;
        }
        $sql  = "DELETE FROM `{$table}` WHERE " . implode(' AND ', $conditions);
        $stmt = $this->query($sql, $params);
        return $stmt !== false;
    }

    public function count(string $table, array $where = []): int
    {
        $sql    = "SELECT COUNT(*) FROM `{$table}`";
        $params = [];
        if (!empty($where)) {
            $conditions = [];
            foreach ($where as $col => $val) {
                $conditions[] = "`{$col}` = ?";
                $params[]     = $val;
            }
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }
        $stmt = $this->query($sql, $params);
        return $stmt ? (int)$stmt->fetchColumn() : 0;
    }

    public function rawCount(string $sql, array $params = []): int
    {
        $stmt = $this->query($sql, $params);
        return $stmt ? (int)$stmt->fetchColumn() : 0;
    }

    public function rawFetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function rawFetchOne(string $sql, array $params = []): ?array
    {
        $stmt = $this->query($sql, $params);
        $row  = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;
        return $row ?: null;
    }
}
