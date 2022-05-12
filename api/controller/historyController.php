<?php

require_once 'model/historyModel.php';
require_once 'controller.php';

/**
 * HistoryController instance
 */
class HistoryController extends Controller {

    /**
     * History model instance
     */
    private $historyModel;

    /**
     * Initialize the class
     */
    function __construct()
    {
        parent::__construct();
        $this->historyModel = new HistoryModel();
    }

    /**
     * Save a new History record
     *
     * @param int    $first_number
     * @param int    $second_number
     * @param string $operator
     * @param int    $result
     */
    public function save(int $first_number,int $second_number,string $operator,int $result): void
    {
        try {
            $this->historyModel->beginTransaction();
            $this->historyModel->saveOperation($first_number,$second_number,$operator,$result);
            $this->historyModel->commitTransaction();
        } catch (\Throwable $th) {
            $this->historyModel->rollbackTransaction();
            $this->response->message = 'Unexpected error';
            $this->returnData($this->response,$th->getCode());
        }
    }

    /**
     * Get all records
     */
    public function index(): void
    {
        try {
            $history = $this->historyModel->history();
            $this->response->history = $history;
            $status = 200;
        } catch (\Throwable $th) {
            $status = $th->getCode();
            $this->response->message = 'Unexpected error';
        }

        $this->returnData($this->response,$status);
    }
}