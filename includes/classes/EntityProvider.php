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

}
?>