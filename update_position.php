<?php
 
/*
 * Following code will update the user position
 */
 
// array for JSON response
$response = array();
 
// check for required fields
if (isset($_GET['number']) && isset($_GET['latitude']) && isset($_GET['longitude'])) {
    $number = $_GET['number'];
    $latitude = $_GET['latitude'];
    $longitude = $_GET['longitude'];
 
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
 
    // mysql replace or update the users position
    $result = mysql_query("REPLACE INTO positions SET number = '$number', latitude = '$latitude', longitude = '$longitude'");
 
    // check if row inserted or not
    if ($result) {
        // successfully updated
        $response["success"] = 1;
        $response["message"] = "Position successfully updated.";
 
        // echoing JSON response
        echo json_encode($response);
    } else {
    // required field is missing
		$response["success"] = 0;
		$response["message"] = "Database error!";
	 
		// echoing JSON response
		echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing!";
 
    // echoing JSON response
    echo json_encode($response);
}
?>