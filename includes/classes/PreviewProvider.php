<?php
    class PreviewProvider{
        //Variables
        private $con, $username;

        //Constructor
        public function __construct($con, $username){
            $this->con = $con;
            $this->username = $username;
        }

        //Function to create preview video
        public function createPreviewVideo($entity){
            //Check if does not exist
            if($entity == null){
                //Get random entity
                $entity = $this->getRandomEntity();
            }
        }

        //Get random entity
        private function getRandomEntity(){
            //Get random entity through random id
            $query = $this->con->prepare("SELECT * FROM entities ORDER BY RAND() LIMIT 1");
            //Execute query
            $query->execute();
            //Fetch query
            $row = $query->fetch(PDO::FETCH_ASSOC);
            echo $row["name"];
        }
    }
?>  