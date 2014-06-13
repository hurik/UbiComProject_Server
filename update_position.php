<?php

if (isset($_GET["message"])) {
    $message = $_GET["message"];
    
    require_once __DIR__ . '/db_connect.php';
    $db = new DB_CONNECT();
    
    include_once './gcm.php';
    $gcm = new GCM();
    
    // get all users
    $users       = mysql_query("select * FROM users");
    $no_of_users = mysql_num_rows($users);
    
    while ($row = mysql_fetch_array($users)) {
        $registatoin_ids = array(
            $row["gcm"]
        );
        $message = array(
            "message" => $message
        );
        
		$gcm->send_notification($registatoin_ids, $message);
    }
}

?>
