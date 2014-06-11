<?php
 
/*
 * Following code will list all positions
 */
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '/db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
 
// get all positions from positions table
$result = mysql_query("SELECT * FROM positions") or die(mysql_error());
 
// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["positions"] = array();
 
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $position = array();
        $position["number"] = $row["number"];
        $position["latitude"] = $row["latitude"];
        $position["longitude"] = $row["longitude"];
        $position["updated"] = $row["updated"];

        // push single position into final response array
        array_push($response["positions"], $position);
    }
    // success
    $response["success"] = 1;
 
    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No positions found.";
 
    // echo no users JSON
    echo json_encode($response);
}
?>