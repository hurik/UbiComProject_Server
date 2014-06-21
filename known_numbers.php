<?php

// Array for JSON response
$response = array();

/**
 * Needs a lot of numbers and returns known numbers
 */
if (isset($_GET["numbers"])) {
    $numbers = explode(";", $_GET["numbers"]);
    
    // Include db connect class
    require_once __DIR__ . '/db_connect.php';
    
    // Connecting to db
    $db = new DB_CONNECT();
    
    // Get all positions from positions table
    $result = mysql_query("SELECT * FROM users") or die(mysql_error());
    
    // Check for empty result
    if (mysql_num_rows($result) > 0) {
        // Looping through all results
        $response["knownNumbers"] = array();
        while ($row = mysql_fetch_array($result)) {
            // Check if the current number from the db was provided
            if (array_search($row["number"], $numbers) !== false) {
                $position           = array();
                $position["number"] = $row["number"];
                
                array_push($response["knownNumbers"], $position);
            }
        }
        // Success
        $response["success"] = 1;
        
        // Echoing JSON response
        echo json_encode($response);
    } else {
        // Database error
        $response["success"] = 0;
        $response["message"] = "Database error!";
        
        // Echoing JSON response
        echo json_encode($response);
    }
} else {
    // Required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing!";
    
    // Echoing JSON response
    echo json_encode($response);
}

?>
