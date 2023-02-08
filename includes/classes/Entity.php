<?php
    class Entity{
        //Variables
        private $con, $sqlData;

        //Constructor
        public function __construct($con, $input){
            $this->con = $con;

            //Check if input is array
            if(is_array($input)){
                //Assign input to array
                $this->sqlData = $input;
            } else{
                //If input is not an array, get input from database
                $query = $this->con->prepare("SELECT * FROM entities WHERE id=:id");
                //Bind value
                $query->bindValue(":id", $input);
                //Execute query
                $query->execute();
                //Assign input to array
                $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
            }
        }

        //Get entity id
        public function getId(){
            //Return id
            return $this->sqlData["id"];
        }

        //Get entity name
        public function getName(){
            //Return name
            return $this->sqlData["name"];
        }

        //Get entity thumbnail
        public function getThumbnail(){
            //Return thumbnail
            return $this->sqlData["thumbnail"];
        }

        //Get entity preview
        public function getPreview(){
            //Return preview
            return $this->sqlData["preview"];
        }
    }
?>