<!DOCTYPE html>
<html>
<body>

<?php
error_reporting(E_ALL);


function getOwnedAP()
{
	//call database, get APs owned by user
	$con = mysqli_connect(host,username,password,dbname);
	
	if (mysqli_connect_errno($con))
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	static $numAPNone = ($con,"SELECT COUNT(DISTINCT security) FROM table_name WHERE security = "None" OR null");
	static $numAPWep = ($con,"SELECT COUNT (DISTINCT security) FROM table_name WHERE security = "WEP"");
	static $numAPWpa ($con,"SELECT COUNT (DISTINCT security) FROM table_name WHERE security = "WPA"");
	static $numAPWpa2 ($con,"SELECT COUNT (DISTINCT security) FROM table_name WHERE security = "WPA2"");
	static $numAP ($con,"SELECT "AP Count" FROM User WHERE username = username");
	
	mysqli_close($con);
}

function calcBaseResource()
{
	//res value of user dev and 
	$ownDevice = 100;
	static $baseResVal = 50;
	
	static $baseRes = ($ownDevice + ($numAP * $baseResVal));
}

function calcAPDebuffs()
{
	//calculates the penalties involved in owned APs not WPA2
	$x = ($numAPNone * $baseRes) * 0.6;
	$y = ($numAPWep * $baseRes) * 0.4;
	$z = ($numAPWpa * $baseRes) * 0.2;
		
	static $APDebufs = $baseRes - ($x - $y - $z);
}

function calcAvailRes()
{
	getOwnedAP();
	calcBaseResource();
	calcAPDebuffs();
	$baseRes - $APDebuffs;
	
	static $availRes = $baseRes - $APDebuffs;
}

function nodeAttack($sT,$sS)
{
	//determines and provides value of resource to attack a node
	
}

function attackNode($nodeBSS)
{
	$con = mysqli_connect(host,username,password,dbname);	

	if (mysqli_connect_errno($con))
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	//check owner
	$nodeOwnerCheck = ($con,"SELECT "AP Count" FROM User WHERE username = username")
	
	if ($nodeOwnerCheck == $nodeBSS)
	{
		$secT = ($con,"SELECT "security" FROM ap_table WHERE bssid = $nodeBSS");
		$secState = ($con,"SELECT "secured" FROM ap_table WHERE bssid = $nodeBSS");
		
		nodeAttack($secT,$secState);
	}
	else
	{
		//attack fail
	}
	
	mysqli_close($con);
}

?>

</body>
</html>