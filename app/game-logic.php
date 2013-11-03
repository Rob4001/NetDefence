<!DOCTYPE html>
<html>
<body>

<?php
error_reporting(E_ALL);


function getOwnedAP($u)
{
	//call database, get APs owned by user, and stored resource vars
	$con = mysqli_connect(host,username,password,dbname);
	
	if (mysqli_connect_errno($con))
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	static $numAPNone = ($con,"SELECT COUNT(DISTINCT security) FROM table_name WHERE security = "None" AND owner = $u");
	static $numAPWep = ($con,"SELECT COUNT (DISTINCT security) FROM table_name WHERE security = "WEP" AND owner = $u");
	static $numAPWpa = ($con,"SELECT COUNT (DISTINCT security) FROM table_name WHERE security = "WPA" AND owner = $u");
	static $numAPWpa2 = ($con,"SELECT COUNT (DISTINCT security) FROM table_name WHERE security = "WPA2" AND owner = $u");
	static $numAP = ($con,"SELECT "AP Count" FROM User WHERE username = username");
	static $reducedRes = ($con,"SELECT "ResReductions" FROM User WHERE username = username");
	
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
	$r = ($reducedRes);
		
	static $APDebufs = $baseRes - ($x - $y - $z - $r);
}

function calcAvailRes()
{
	getOwnedAP();
	calcBaseResource();
	calcAPDebuffs();
	$baseRes - $APDebuffs;
	
	static $availRes = $baseRes - $APDebuffs;
}

function nodeAttackCost($sT,$sS)
{
	//holds values for cost in time and resources for attacking a node
	//called from attackNode()
	
	//values for user unsecured APs, order, null,none,WEP,WPA,WPA2
	$userUnsecAPTime = array(20,30,60,120);
	$baseUnsecCost = 100;
	//values for user secured APs, order, null,none,WEP,WPA,WPA2
	$userSecAPTime = array(40,60,120,240);
	$userSecAPCost = array(200,300,600,1200);
	
	//determines and provides value of resource to attack a node
	if ($sS == false)
	{
		if ($sT == 'null' )
		{
			return x=array($userUnsecAPTime[0],$baseUnsecCost);
		}
		elseif ($sT == "None")
		{
			return x=array($userUnsecAPTime[0],$baseUnsecCost);
		}
		elseif ($sT == "WEP")
		{
			return x=array($userUnsecAPTime[1],$baseUnsecCost);
		}
		elseif ($sT == "WPA")
		{
			return x=array($userUnsecAPTime[2],$baseUnsecCost);
		}
		elseif ($sT == "WPA2")
		{
			return x=array($userUnsecAPTime[3],$baseUnsecCost);
		}
		else
		{
			//failed
		}
	}
	else
	{
		if ($sT == 'null')
		{
			return x=array($userSecAPTime[0],$userSecAPCost[0]);
		}
		elseif ($sT == "None")
		{
			return x=array($userSecAPTime[0],$userSecAPCost[0]);
		}
		elseif ($sT == "WEP")
		{
			return x=array($userSecAPTime[1],$userSecAPCost[1]);
		}
		elseif ($sT == "WPA")
		{
			return x=array($userSecAPTime[2],$userSecAPCost[2]);
		}
		elseif ($sT == "WPA2")
		{
			return x=array($userSecAPTime[3],$userSecAPCost[3]);
		}
		else
		{
			//failed
		}
	}
}

function attackNode($nodeBSS)
{
	//checks ownership of node that user wants to attack
	//gets cost for user of attacking node
	//passes cost onto reduceRes to reduce available resources to user
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
		
		$y = array(nodeAttackCost($secT,$secState));
		//array returned time,cost
		$z = y[1]
		
		if ($z <= calcAvailRes())
		{
			reduceRes($y);
		}
		else
		{
			//fail
		}
	}
	else
	{
		//attack fail
	}
	
	mysqli_close($con);
}

function reduceRes($array)
{
	//array is time,cost
	$a = $array[0];
	$b = $array[1];
	
	//increment ResourceReductions
	$reducedRes = $reducedRes + $b;
	updateUserReduce();
	//don't know how we want to approach time in php
}

function updateUserReduce();
{
	$con = mysqli_connect(host,username,password,dbname);
	
	if (mysqli_connect_errno($con))
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	$reducedRes;
	
	mysqli_close($con);

}
?>

</body>
</html>