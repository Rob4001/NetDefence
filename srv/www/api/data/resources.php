<?php

header('Access-Control-Allow-Origin: http://geeksoc-hackathon.tk');

include("api.php");
$api = new DataAPI();

if(isset($_GET['uid'])) {
echo json_encode($api->getUserResources($_GET['uid']));


}


?>
