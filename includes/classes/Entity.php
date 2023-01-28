<?php
    class Entity{
        //Variables
        private $con, $sqlData;

        //Constructor
        public function __construct($con, $sqlData){
            $this->con = $con;

            //Check if input is array
            if(is_array($sqlData)){
                //Assign input to array
                $this->sqlData = $sqlData;
            } else{
                //If input is not an array, get input from database
                $query = $this->con->prepare("SELECT * FROM entities WHERE id=:id");
                //Bind value
                $query->bindValue(":id", $sqlData);
                //Execute query
                $query->execute();
                //Assign input to array
                $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
            }

            $this->sqlData = $sqlData;
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