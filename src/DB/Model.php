<?php
/**
 * Created by PhpStorm.
 * User: company
 * Date: 2019/3/7
 * Time: 16:04
 */

namespace Simple\DB;

class Model
{
    protected $connection;

    public function __construct()
    {
        $this->connection = MySQL::getSingleMysqliConnection();
    }

    public function getConnection(): \mysqli
    {
        return $this->connection;
    }

    public function prepare(string $sql): \mysqli_stmt
    {
        $stmt = $this->connection->prepare($sql);
        if ($stmt === false) {
            throw new \mysqli_sql_exception($this->connection->error);
        }
        return $stmt;
    }

    public function query(\mysqli_stmt $stmt)
    {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $stmt->free_result();
                return $result->fetch_assoc();
            }
            $stmt->free_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            throw new \mysqli_sql_exception($stmt->error);
        }
    }

    public function executeOriginSql($sql)
    {
        $result = $this->connection->query($sql);
        if ($result === false) {
            throw new \mysqli_sql_exception($this->connection->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

}