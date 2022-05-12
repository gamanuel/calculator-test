<?php

require_once 'model.php';

/**
 * HistoryModel instance
 */
class HistoryModel extends Model {

    /**
     * Persist history record
     *
     * @param int    $first_number
     * @param int    $second_number
     * @param string $operator
     * @param int    $result
     */
    public function saveOperation(int $first_number,int $second_number,string $operator,int $result): void 
    {
        $sentencia = $this->dbConnection->prepare("INSERT INTO history (first_number,second_number,operator,result) VALUES(?,?,?,?)");
        $sentencia->execute(array($first_number,$second_number,$operator,$result));

        $sentencia->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Retrieve history
     */
    public function history(): array
    {
        $sentencia = $this->dbConnection->prepare("SELECT * FROM history ORDER BY id DESC");
        $sentencia->execute();

        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }
}
