<?php
/**
 * @file
 *  Main class file for the REST api.
 */

/**
 * Class API.
 */
abstract class API {
    protected $pdo;
    protected $method;
    protected $table;
    protected $input;
    protected $data;
    protected $status; // TODO: thik of HTTP status code implementation.

    protected abstract function isPOSTDataValid(array $data);
    
    public abstract function insert();

    /**
     * 
     */
    public function __construct (PDO $pdo, string $method, array $input = NULL) {
        $this->pdo = $pdo;
        $this->method = $method;

        if($this->method == "POST" && !$this->isPOSTDataValid($input)) {
            $this->setError("Input data is not valid.");
            return;
        }

        $this->input = $input;
    }

    /**
     * 
     */
    protected function setError($message) {
        $this->status = 'error';
        $this->data = $message;
    }

    /**
     * 
     */
    protected function setData($data) {
        $this->status = 'ok';
        $this->data = $data;
    }

    /**
     * 
     */
    public function getItems($id = NULL) {
        $query = "SELECT * FROM {$this->table}";

        $condition = "";
        if($id !== NULL) {
            $condition = " WHERE id = :id";
        }

        $query .= $condition;

        $statement = $this->pdo->prepare($query);
        $statement->bindParam(":id", $id);
        try {
            $statement->execute();
        }
        catch(Exception $e) {
            $this->setError("MySQL returned an error " . $e->getMessage());
            return $this;
        }

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(empty($result)) {
            $this->setError("Nothing to return. Empty result set.");
            return $this;
        }

        if(count($result) == 1 && $id !== NULL) {
            $this->setData(reset($result));
        }
        else {
            $this->setData($result);
        }

        return $this;
    }

    /**
     * 
     */
    public function getJSON() {
        $resultArray = [
            'status' => $this->status,
            'data' => $this->data,
        ];

        return json_encode($resultArray);
    }
}