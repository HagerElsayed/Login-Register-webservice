<?php
 

 
class DatabaseModel {
 
    private $conn;
    private $id;
    private $username;
    private $password;
    private $email;
    private $mobile;
 
    // constructor
    // function __construct($id, $username, $password, $email,$mobile) {
    //      require_once 'databaseConnection.php';
    //     $this->id = isset($this->id) ? $this->id : $id;
    //     $this->username = isset($this->username) ? $this->username : $username;
    //     $this->password = isset($this->password) ? $this->password : $password;
    //     $this->email = isset($this->email) ? $this->email : $email;
    //     $this->mobile = isset($this->mobile) ? $this->mobile : $mobile;
    //     $db = new DatabaseConnection();
    //     $this->conn = $db->connect();
    // }//end of Constructor

     function __construct() {
        require_once 'databaseConnection.php';
        $db = new DatabaseConnection();
        $this->conn = $db->connectToDB();
    }//end of Constructor

    function __get($attr) {
        return $this->$attr;
    }

    function __set($attr, $value) {
        $this->$attr = $value;
    }
  
    public function insertUser($name, $email,$mobile, $password) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
 
        $stmt = $this->conn->prepare("INSERT INTO users(unique_id, name, email,mobile, encrypted_password,salt, created_at) VALUES(? , ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssss", $uuid, $name, $email,$mobile , $encrypted_password, $salt);
        $result = $stmt->execute();

        if (!$result) {
            echo 'binding failed' . $stmt->error;
            return false;
            exit;
        }
        if (!$stmt->execute()) {
            echo 'execuation failed' . "<br />" . $stmt->error;
            return false;
            exit;
        }

        $stmt->close();
 
        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            return $user;
        } else {
            return false;
        }
    }//end of Insert User

    //======= Encrypting password =====
    public function hashSSHA($password) {
 
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
    //======== Decrypting password ==========
    public function checkhashSSHA($salt, $password) {
 
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
 
        return $hash;
    }

    //=============== Retrieve User =============================
    public function getUserByEmailAndPassword($email, $password) {
 
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
 
        $stmt->bind_param("s", $email);
 
        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            // verifying user password
            $salt = $user['salt'];
            $encrypted_password = $user['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }//end of getUserByEmailAndPassword

     public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from users WHERE email = ?");
 
        $stmt->bind_param("s", $email);
 
        $stmt->execute();
 
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }//end of func
 


}
 