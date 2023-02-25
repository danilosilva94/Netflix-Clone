<?php
class CategoryContainers {
    //Variables
    private $con, $username;

    //Constructor
    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    //Show all categories
    public function showAllCategories() {
        //Get all categories
        $query = $this->con->prepare("SELECT * FROM categories");
        //Execute query
        $query->execute();

        //Create html
        $html = "<div class='previewCategories'>";

        //Loop through all categories
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            //Get category and add to html
            $html .= $this->getCategoryHtml($row, null, true, true);
        }

        //Return html
        return $html . "</div>";
    }

    //Show all categories
    public function showTVShowCategories() {
        //Get all categories
        $query = $this->con->prepare("SELECT * FROM categories");
        //Execute query
        $query->execute();

        //Create html
        $html = "<div class='previewCategories'>
                    <h1>TV Shows</h1>";

        //Loop through all categories
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            //Get category and add to html
            $html .= $this->getCategoryHtml($row, null, true, false);
        }

        //Return html
        return $html . "</div>";
    }

    //Show all categories
    public function showMoviesCategories() {
        //Get all categories
        $query = $this->con->prepare("SELECT * FROM categories");
        //Execute query
        $query->execute();

        //Create html
        $html = "<div class='previewCategories'>
                    <h1>Movies</h1>";

        //Loop through all categories
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            //Get category and add to html
            $html .= $this->getCategoryHtml($row, null, false, true);
        }

        //Return html
        return $html . "</div>";
    }

    //Show specific category
    public function showCategory($categoryId, $title = null) {
        //Get category
        $query = $this->con->prepare("SELECT * FROM categories WHERE id=:id");
        //Bind value
        $query->bindValue(":id", $categoryId);
        //Execute query
        $query->execute();

        //Create html
        $html = "<div class='previewCategories noScroll'>";

        //Iterate through all categories
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            //Get category and add to html
            $html .= $this->getCategoryHtml($row, $title, true, true);
        }

        //Return html
        return $html . "</div>";
    }

    //Get category html
    private function getCategoryHtml($sqlData, $title, $tvShows, $movies) {
        //Get category id
        $categoryId = $sqlData["id"];
        //If title is null, set title to category name
        $title = $title == null ? $sqlData["name"] : $title;

        //Check if tv shows and movies are true
        if($tvShows && $movies) {
            //Get entities and add to entities array
            $entities = EntityProvider::getEntities($this->con, $categoryId, 30);
        }
        else if($tvShows) {
            // Get tv show entities
            $entities = EntityProvider::getTVShowEntities($this->con, $categoryId, 30);
        }
        else {
            // Get movie entities
            $entities = EntityProvider::getMoviesEntities($this->con, $categoryId, 30);
        }

        //If there are no entities, return
        if(sizeof($entities) == 0) {
            return;
        }

        //Create html
        $entitiesHtml = "";

        //Create preview provider object
        $preview = new PreviewProvider($this->con, $this->username);

        //Loop through all entities
        foreach($entities as $entity) {
            //Add entity name to html
            $entitiesHtml .= $preview->createEntityPreviewSquare($entity);
        }

        //Return html
        return "<div class='category'>
                    <a href='category.php?id=$categoryId'>
                        <h3>$title</h3>
                    </a>

                    <div class='entities'>
                        $entitiesHtml
                    </div>
                </div>";
    }
}
