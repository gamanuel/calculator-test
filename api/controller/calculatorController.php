<?php

require_once 'historyController.php';
require_once 'controller.php';

/**
 * CalculatorController instance
 */
class CalculatorController extends Controller {

    /**
     * Perform  and persist math operation
     */
    public function mathOperation(): void
    {
        try {
            $first_number = $_POST['first_number'];
            $second_number = $_POST['second_number'];
            $operator = $_POST['operator'];
            $result = $this->getOperation($first_number,$second_number,$operator);
            (new HistoryController())->save($first_number,$second_number,$operator,$result);
            $this->response->result = $result;
            $status = 200;
        } catch (\Throwable $th) {
            $status = $th->getCode();
            $this->response->message = $th->getMessage();
        }

        $this->returnData($this->response,$status);
    }

    /**
     * Perform math operation
     *
     * @param int    $first_number
     * @param int    $second_number
     * @param string $operator
     */
    private function getOperation(int $first_number,int $second_number,string $operator): int {
        switch ($operator) {
            case "+":
                $operation = $first_number + $second_number;
                break;
            case "-":
                $operation = $first_number - $second_number;
                break;
            case "*":
                $operation = $first_number * $second_number;
                break;
            case "/":
                $operation = $first_number / $second_number;
                break;
            default:
                throw new Exception("Invalid operator", 400);
        }

        return $operation;
    }
}