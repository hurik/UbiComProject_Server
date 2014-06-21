<?php

// Response json for errors
$json = array();

/**
 * Send position to allowed devices
 */
if (isset($_GET["message"]) && isset($_GET["allowed"])) {
    $message = $_GET["message"];
    $allowed = explode(";", $_GET["allowed"]);
    
    // Include db connect class
    require_once __DIR__ . '/db_connect.php';
    
    // Connecting to db
    $db = new DB_CONNECT();
    
    // Include gcm class
    include_once './gcm.php';
    
    // Get all users
    $users = mysql_query("SELECT * FROM users");
    
    // Check if we got an result
    if ($users) {
        // Get all rows
        $no_of_users = mysql_num_rows($users);
        
        // Array for the gcm ids of the allowed users 
        $receivers_gcm_ids = array();
        
        // Go throw every row and check if the user was allowed to get the update
        while ($row = mysql_fetch_array($users)) {
            if (array_search($row["number"], $allowed) !== false) {
                // Add the users gcm id to the receivers
                array_push($receivers_gcm_ids, $row["gcm"]);
            }
        }
        
        // When there more than on receiver send the update to google cloud messaging 
        if (count($receivers_gcm_ids) > 0) {
            // Add the message
            $message = array(
                "message" => $message
            );
            
            // Send it!
            echo GCM::send_notification($receivers_gcm_ids, $message);
        }
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
