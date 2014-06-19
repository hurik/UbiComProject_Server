<?php

if (isset($_GET["message"]) && isset($_GET["allowed"])) {
    $message = $_GET["message"];
    $allowed = explode(";", $_GET["allowed"]);
    
    require_once __DIR__ . '/db_connect.php';
    $db = new DB_CONNECT();
    
    include_once './gcm.php';
    $gcm = new GCM();
    
    // get all users
    $users       = mysql_query("select * FROM users");
    $no_of_users = mysql_num_rows($users);
    
    $registatoin_ids = array();
    
    while ($row = mysql_fetch_array($users)) {
        if (array_search($row["number"], $allowed) !== false) {
            array_push($registatoin_ids, $row["gcm"]);
        }
    }
    
    if (count($registatoin_ids) > 0) {
        $message = array(
            "message" => $message
        );
        
        echo $gcm->send_notification($registatoin_ids, $message);
    }
}

?>
