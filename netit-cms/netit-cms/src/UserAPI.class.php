<?php
/**
 * @file
 *  Main class file for the User API.
 */

 /**
  * Class UserAPI.
  */
class UserAPI extends API {

    public function __construct(PDO $pdo, string $method, array $input = NULL) {
        parent::__construct($pdo, $method, $input);
        $this->table = "users";
    }

    protected function isPOSTDataValid(array $data) {
        return (!empty($data) &&
                !empty($data['username']) &&
                !empty($data['password']) &&
                !empty($data['repeat_password'])
            );
    }

    public function insert() {
        if($this->method == "POST" && !empty($this->input)) {
            if($this->input['password'] != $this->input['repeat_password']) {
                $this->setError("The password should match.");
                return $this;
            }

            $user = new User(
                @$this->input['id'],
                $this->input['username'],
                $this->input['password'],
                $this->input['phone'],
                $this->input['birth_date']
            );

            // Insert the user and fetch error message if somehting is not right.
            $error = $user->insert($this->pdo);
            if(!empty($user->id) && $error === TRUE) {
                $this->setData($user);
            }
            else {
                $this->setError($error);
            }
        }
        else {
            $this->setError("Invalid method or data issued.");
        }

        return $this;
    }
}