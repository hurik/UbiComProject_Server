<?php

// Response json
$json = array();

/**
 * Registering a user device
 * Store number and GCM Registration ID (gcm) in users table
 */
if (isset($_GET["number"]) && isset($_GET["gcm"])) {
    $number = $_GET["number"];
    $gcm    = $_GET["gcm"]; // GCM Registration ID
    
    // Include db connect class
    require_once __DIR__ . '/db_connect.php';
    
    // Connecting to db
    $db = new DB_CONNECT();
    
    // Insert or update user into database
    $result = mysql_query("REPLACE INTO users SET number = '$number', gcm = '$gcm'");
    
    // Check if row inserted or not
    if ($result) {
        // Successfully updated
        $response["success"] = 1;
        $response["message"] = "User successfully created or updated.";
        
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
