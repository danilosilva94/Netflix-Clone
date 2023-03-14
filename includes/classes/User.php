<?php
    class User{
        //Declare private variables
        private $con, $sqlData;

        //Constructor
        public function __construct($con, $username){
            $this->con = $con;

            //Get user data
            $query = $this->con->prepare("SELECT * FROM users WHERE username=:username");
            $query->bindValue(":username", $username);
            $query->execute();

            //Set sql data
            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }

        //Get first name
        public function getFirstName(){
            return $this->sqlData["firstName"];
        }

        //Get last name
        public function getLastName(){
            return $this->sqlData["lastName"];
        }

        //Get username
        public function getUsername(){
            return $this->sqlData["username"];
        }

        //Get email
        public function getEmail(){
            return $this->sqlData["email"];
        }

        //Get is subscribed
        public function getIsSubscribed(){
            return $this->sqlData["isSubscribed"];
        }

        //Update subscription column in database
        public function setIsSubscribed($value){
            //Prepare query
            $query = $this->con->prepare("UPDATE users SET isSubscribed=:isSubscribed WHERE username=:username");

            //Bind values
            $query->bindValue(":isSubscribed", $value);
            $query->bindValue(":username", $this->getUsername());

            //Execute query
            if($query->execute()){
                //Update sql data
                $this->sqlData["isSubscribed"] = $value;
                return true;
            } else {
                return false;
            }
        }
    }
?>