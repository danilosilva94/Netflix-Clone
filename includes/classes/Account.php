<?php
class Account {

    private $con;
    private $errorArray = array();

    // Constructor
    public function __construct($con) {
        $this->con = $con;
    }

    // Register
    public function register($fn, $ln, $un, $em, $em2, $pw, $pw2) {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUsername($un);
        $this->validateEmails($em, $em2);
        $this->validatePasswords($pw, $pw2);

        //Check if there are no errors
        if(empty($this->errorArray)) {
            // Insert into database
            return $this->insertUserDetails($fn, $ln, $un, $em, $pw);
        } else {
            return false;
        }
    }

    // Insert user details into database
    private function insertUserDetails($fn, $ln, $un, $em, $pw) {
        // Encrypt password
        $encryptedPw = md5($pw);
        // Default profile picture

        $query = $this->con->prepare("INSERT INTO users (firstName, lastName, username, email, password) VALUES (:fn, :ln, :un, :em, :pw)");
        // Fill in the placeholders
        $query->bindValue(":fn", $fn);
        $query->bindValue(":ln", $ln);
        $query->bindValue(":un", $un);
        $query->bindValue(":em", $em);
        $query->bindValue(":pw", $encryptedPw);

        // Execute the query
        return $query->execute();
    }

    // Validate first name
    private function validateFirstName($fn) {
        if(strlen($fn) < 2 || strlen($fn) > 25) {
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    //Validate last name
    private function validateLastName($ln) {
        if(strlen($ln) < 2 || strlen($ln) > 25) {
            array_push($this->errorArray, Constants::$lastNameCharacters);
        }
    }

    //Validate username
    private function validateUsername($un) {
        if(strlen($un) < 5 || strlen($un) > 25) {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }

        // Check if username exists
        $query = $this->con->prepare("SELECT * FROM users WHERE username = :un");
        //Fill in the placeholder
        $query->bindValue(":un", $un);
        //Execute the query
        $query->execute();

        //Count the number of rows returned
        if($query->rowCount() != 0) {
            //Username already exists
            array_push($this->errorArray, Constants::$usernameTaken);
        }
    }

    //Validate emails
    private function validateEmails($em, $em2) {
        if($em != $em2) {
            array_push($this->errorArray, Constants::$emailsDoNotMatch);
            return;
        }

        // Check if email is valid
        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        // Check if email exists
        $query = $this->con->prepare("SELECT * FROM users WHERE email = :em");
        //Fill in the placeholder
        $query->bindValue(":em", $em);
        //Execute the query
        $query->execute();

        //Count the number of rows returned
        if($query->rowCount() != 0) {
            //Email already exists
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    //Validate passwords
    private function validatePasswords($pw, $pw2) {
        if($pw != $pw2) {
            array_push($this->errorArray, Constants::$passwordsDoNotMatch);
            return;
        }

        if(preg_match('/[^A-Za-z0-9]/', $pw)) {
            array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
            return;
        }

        if(strlen($pw) < 5 || strlen($pw) > 30) {
            array_push($this->errorArray, Constants::$passwordCharacters);
            return;
        }
    }

    // Get error
    public function getError($error) {
        if(in_array($error, $this->errorArray)) {
            return "<span class='errorMessage'>$error</span>";
        }
    }

}
?>