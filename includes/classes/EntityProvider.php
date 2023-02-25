<?php
class EntityProvider {

    // Get all entities
    public static function getEntities($con, $categoryId, $limit) {
        // Create sql query
        $sql = "SELECT * FROM entities ";

        // Check if category id is not null
        if($categoryId != null) {
            // Add category id to sql query
            $sql .= "WHERE categoryId=:categoryId ";
        }

        // Add limit to sql query
        $sql .= "ORDER BY RAND() LIMIT :limit";

        // Prepare sql query
        $query = $con->prepare($sql);

        // Check if category id is not null
        if($categoryId != null) {
            // Bind category id to sql query
            $query->bindValue(":categoryId", $categoryId);
        }

        // Bind limit to sql query
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        // Execute sql query
        $query->execute();

        // Create result array
        $result = array();
        // Loop through all rows
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            // Add new entity to result array
            $result[] = new Entity($con, $row);
        }

        // Return result array
        return $result;
    }

    // Get all entities for tv shows
    public static function getTVShowEntities($con, $categoryId, $limit) {
        // Create sql query
        $sql = "SELECT DISTINCT(entities.id) FROM entities
        INNER JOIN videos ON entities.id = videos.entityId
        WHERE videos.isMovie = 0 ";

        // Check if category id is not null
        if($categoryId != null) {
            // Add category id to sql query
            $sql .= "AND categoryId=:categoryId ";
        }

        // Add limit to sql query
        $sql .= "ORDER BY RAND() LIMIT :limit";

        // Prepare sql query
        $query = $con->prepare($sql);

        // Check if category id is not null
        if($categoryId != null) {
            // Bind category id to sql query
            $query->bindValue(":categoryId", $categoryId);
        }

        // Bind limit to sql query
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        // Execute sql query
        $query->execute();

        // Create result array
        $result = array();
        // Loop through all rows
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            // Add new entity to result array
            $result[] = new Entity($con, $row["id"]);
        }

        // Return result array
        return $result;
    }

    // Get all entities for movies
    public static function getMoviesEntities($con, $categoryId, $limit) {
        // Create sql query
        $sql = "SELECT DISTINCT(entities.id) FROM entities
        INNER JOIN videos ON entities.id = videos.entityId
        WHERE videos.isMovie = 1 ";

        // Check if category id is not null
        if($categoryId != null) {
            // Add category id to sql query
            $sql .= "AND categoryId=:categoryId ";
        }

        // Add limit to sql query
        $sql .= "ORDER BY RAND() LIMIT :limit";

        // Prepare sql query
        $query = $con->prepare($sql);

        // Check if category id is not null
        if($categoryId != null) {
            // Bind category id to sql query
            $query->bindValue(":categoryId", $categoryId);
        }

        // Bind limit to sql query
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        // Execute sql query
        $query->execute();

        // Create result array
        $result = array();
        // Loop through all rows
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            // Add new entity to result array
            $result[] = new Entity($con, $row["id"]);
        }

        // Return result array
        return $result;
    }

    // Get all entities for movies
    public static function getSearchEntities($con, $term) {
        // Create sql query
        $sql = "SELECT * FROM entities 
        WHERE name LIKE CONCAT('%', :term, '%')
        LIMIT 30";

        // Prepare sql query
        $query = $con->prepare($sql);

        // Bind limit to sql query
        $query->bindValue(":term", $term);
        // Execute sql query
        $query->execute();

        // Create result array
        $result = array();
        // Loop through all rows
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            // Add new entity to result array
            $result[] = new Entity($con, $row);
        }

        // Return result array
        return $result;
    }
}
?>