<?php

header('Access-Control-Allow-Origin: http://geeksoc-hackathon.tk');
include_once('./api.php');

$api = new DataAPI();

$response ="";
if(isset($_POST['id'])&& isset($_POST['user'])){
attackNode($_POST['id'],$_POST['user']);
}else{
$response="No Post Data";
}

var_dump($_POST);
function attackNode($nodeID,$userID)
{
$node = $api->getAP($nodeID);

        
        if ($node['OWNER'] == $userID)
        {
                $secT = $node['SECURITY'];
                //$secState = ($con,"SELECT "secured" FROM ap_table WHERE bssid = $nodeBSS");
                $secState= true;
                $y = nodeAttackCost($secT,$secState);
                if ($y == false){
                  $response="Attack Failed : An error occured";
                }
                //array returned time,cost
        

                if ($y <= $api->getUserResources($userID))
                {
                    $api->modifyUserResources($userID,$y);
                    $api->addHack($nodeID,$userID);
                    $response="Attack Success : The node will be yours in "+$y[0] + " seconds";
                    
                }
                else
                {
                        $response="Attack Failed : Not enough Resources";
                        return;
                }
        }
        else
        {
                $response="Attack Failed : You already own this node";
                return;
        }
}

function nodeAttackCost($sT,$sS)
{
        //holds values for cost in time and resources for attacking a node
        //called from attackNode()
        
        //values for user unsecured APs, order, null,none,WEP,WPA,WPA2
        $baseUnsecCost = 100;
        //values for user secured APs, order, null,none,WEP,WPA,WPA2
        $userSecAPCost = array(200,300,600,1200);
        
        //determines and provides value of resource to attack a node
        if ($sS == false)
        {
                
                {
                        return 100;
                }
        }
        else
        {
                if (isset($sT))
                {
                        return 100;
                }
                elseif ($sT == "None")
                {
                        return 100;
                }
                elseif ($sT == "WEP")
                {
                        return 200;
                }
                elseif ($sT == "WPA")
                {
                        return 300;
                }
                elseif ($sT == "WPA2")
                {
                        return 600;
                }
                else
                {
                        return false;
                }
        }
}





?>


