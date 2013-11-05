<?php

header('Access-Control-Allow-Origin: http://geeksoc-hackathon.tk');
include_once('./api.php');

$api = new DataAPI();

if(isset($_GET['user'])) {
echo json_encode($api->getUserID($_GET['user']));


}
