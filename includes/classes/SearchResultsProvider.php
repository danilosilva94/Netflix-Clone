<?php
class SearchResultsProvider
{
    //Declare private variables
    private $con, $username;

    //Constructor
    public function __construct($con, $username)
    {
        $this->con = $con;
        $this->username = $username;
    }

    //Get results
    public function getResults($inputText)
    {
        //Get entities
        $entities = EntityProvider::getSearchEntities($this->con, $inputText);
    
        //Get html
        $html = "<div class='previewCategories scrolled'>";

        $html .=  $this->getResultHtml($entities);

        //Return html
        return $html . "</div>";
    }

    private function getResultHtml($entities)
    {
        //If there are no entities, return
        if (sizeof($entities) == 0) {
            return;
        }

        //Create html
        $entitiesHtml = "";

        //Create preview provider object
        $preview = new PreviewProvider($this->con, $this->username);

        //Loop through all entities
        foreach ($entities as $entity) {
            //Add entity name to html
            $entitiesHtml .= $preview->createEntityPreviewSquare($entity);
        }

        //Return html
        return "<div class='category'>
                        <div class='entities'>
                            $entitiesHtml
                        </div>
                    </div>";
    }
}
