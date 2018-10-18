<?php
/**
 * 
 */

 class User {
     public $id;
     public $username;
     public $password;
     public $phone;
     public $birth_date;

     const LOADABLES = ['id', 'username'];

     public function __construct($id = NULL, $username = NULL, $password = NULL, $phone = NULL, $birth_date = NULL) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->phone = $phone;
        $this->birth_date = $birth_date;
     }

     /**
      * Inserts the user into the database.
      */
     public function insert($pdo) {
        if(!empty($this->id)) {
            return "User can not be inserted.";
        }

        if ($this->isPasswordValid()) {
            $this->password = hash("sha256", $this->password);

            $query = 
            "INSERT INTO users
                (`id`, `username`, `password`, `phone`, `birth_date`)
            VALUES
                (NULL, :username, :password, :phone, :birth_date)";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":birth_date", $this->birth_date);

            try {
                $stmt->execute();
            }
            catch (Exception $e) {
                return "Something went very wrong.";
            }

            if(empty($this->id = $pdo->lastInsertId())) {
                return "Duplicate username.";
            }

            return TRUE;
        }
        else {
            return "The password is not valid. User can not be saved.";
        }
    }

    /**
     * Checks whether the passwrod is valid ot not. A password is considered as valid if:
     *  - is longer than 6 characters.
     *  - contains uppercase letter and lowercase letter.
     */
    public function isPasswordValid() {
        if(strlen($this->password) < 6 ) {
            return FALSE;
        }

        if(preg_match('/[A-Z]/', $this->password) == FALSE && preg_match('/[a-z]/', $this->password) == FALSE) {
			return FALSE;
		}

        return TRUE;        
    }

    /**
     * 
     */
    public function checkPassword($password) {
        if($this->password == hash("sha256", $password)) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * 
     */
    public function loadUser($pdo, $param, $value) {
        if(!in_array($param, self::LOADABLES)) {
            return FALSE;
        }

        $query = "SELECT * FROM users WHERE `{$param}` = :{$param}";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":{$param}", $value);
        $stmt->execute();

        $userData = $stmt->fetchAll();

        if(!empty($userData[0])) {
            $this->id = $userData[0]['id'];
            $this->username = $userData[0]['username'];
            $this->password = $userData[0]['password'];
            $this->phone = $userData[0]['phone'];
            $this->birth_date = $userData[0]['birth_date'];

            return $this;
        }

        return FALSE;
    }
 }
 