<?php
include("api.php");

$api = new DataAPI();

echo "Num users: {$api->getNumUsers()}<br />";

echo "Access points user ID 3:";
var_dump($api->getAccessPoints(3));
echo "<br />";


echo "Num access points user id 1 : ". $api->getAccessPointCount(1) ."<br />";
echo "Num access points user id 2 : ". $api->getAccessPointCount(2) ."<br />";
echo "Num access points user id 3 : ". $api->getAccessPointCount(3) ."<br />";


echo "Number of users: {$api->getNumUsers()}<br />";

echo "Number of resources of user ID 2: {$api->getUserResources(2)}<br />";
$api->modifyUserResources(2, -20);
echo "change number of resources of user id 2 by -20 resources, current resources: {$api->getUserResources(2)}<br />";

echo "Number of access points owned by user id 1 (no body) with security type WEP: {$api->getUserAccessPointsSecurity(1, "WEP")}<br />";



echo "getting data of access point id of 73169<br />";

var_dump($api->getAP(73169));


echo "setting AP id 73169 to owner id 3<br />";

$api->setAccessPointOwner(73169, 3);

echo "access point info of id 73169<br />";
var_dump($api->getAP(73169));


