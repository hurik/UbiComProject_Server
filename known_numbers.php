<?php

/*
 * ...
 */

if (isset($_GET["numbers"])) {
    $numbers = explode(";", $_GET["numbers"]);
    
    // array for JSON response
    $response = array();
    
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
    
    // connecting to db
    $db = new DB_CONNECT();
    
    // get all positions from positions table
    $result = mysql_query("SELECT * FROM users") or die(mysql_error());
    
    // check for empty result
    if (mysql_num_rows($result) > 0) {
        // looping through all results
        $response["knownNumbers"] = array();
        while ($row = mysql_fetch_array($result)) {
            if (array_search($row["number"], $numbers) !== false) {
                $position           = array();
                $position["number"] = $row["number"];
                
                array_push($response["knownNumbers"], $position);
            }
        }
        // success
        $response["success"] = 1;
        
        // echoing JSON response
        echo json_encode($response);
    }
}

?>
