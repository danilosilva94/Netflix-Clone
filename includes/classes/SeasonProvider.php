<?php
    class SeasonProvider{
        //Variables
        private $con, $username;

        //Constructor
        public function __construct($con, $username){
            $this->con = $con;
            $this->username = $username;
        }
    }
?>