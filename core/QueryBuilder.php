<?php
class QueryBuilder
{
    protected $pdo;
    protected $table;
    protected $where = [];

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function where($column, $operator, $value)
    {
        $this->where[] = [$column, $operator, $value];
        return $this;
    }

    public function get()
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];

        if (count($this->where)) {
            $sql .= " WHERE ";
            $conditions = [];

            foreach ($this->where as $clause) {
                [$column, $operator, $value] = $clause;
                $conditions[] = "$column $operator ?";
                $params[] = $value;
            }

            $sql .= implode(" AND ", $conditions);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
