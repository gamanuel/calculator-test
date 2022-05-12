<?php

/**
 * Controller instance
 */
class Controller {

    /**
     * The response object
     */
    protected stdClass $response;

    /**
     * Initialize the class
     */
    public function __construct()
    {
        $this->response = new stdClass;
    }

    /**
     * Parse and return data
     *
     * @param object  $data
     * @param integer $httpCode
     */
    protected function returnData($data,$httpCode = 200): void
    {
        http_response_code($httpCode);
        print_r(json_encode($data));
        die();
    }


}