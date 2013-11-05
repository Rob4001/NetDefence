<?php
include_once('./api.php');

$api = new DataAPI();
//include 'virus-logic.php';

$ownDevice = 100;
$baseResVal = 50;


function fileOpen()
{
        $pos = json_decode('virus.json');
}
        
function fileWrite()
{
        file_put_contents('virus.json',json_encode($pos));
}

function recalculateResources(){

for($i = 3; $i < $api->getNumUsers();$i++){
 $numAPNone = $api->getAccessPointsCountSecurity($i,"None");
        $numAPWep = $api->getAccessPointsCountSecurity($i,"WEP");
        $numAPWpa = $api->getAccessPointsCountSecurity($i,"WPA");
        $numAPWpa2 = $api->getAccessPointsCountSecurity($i,"WPA2");
        $numAP = $api->getAccessPointCount($i);
        
        
        $baseRes = ($ownDevice + ($numAP * $baseResVal));
        $x = ($numAPNone * $baseRes) * 0.6;
        $y = ($numAPWep * $baseRes) * 0.4;
        $z = ($numAPWpa * $baseRes) * 0.2;
                
        $APDebufs = $baseRes - ($x + $y + $z);
        
        $api->modifyUserResources($i, $baseRes - $APDebuffs);
        }
}



//virus.run();
$orders = $api->getOrders();
foreach($orders as $order){
  $api->setAccessPointOwner($orders['apid'],$orders['uid']);
}

recalculateResources();



?>
