<!DOCTYPE html>
<html>
<body>

<?php
error_reporting(E_ALL);

include 'game-logic.php';

//start location
$startLat = 55.858;
$startLon = -4.259;

$currentLat = 0;
$currentLon = 0;

$virusUsername = virus;

function setStartLoc()
{
	
}

function updateNodeResources()
{
	getOwnedAP($virusUsername);
	calcAvailRes();	
}

function squareInfectionCheck()
{
	// get number of APs in square and calc percent/val between 0-1
	static $currentSqInf;
}

function squareMovement()
{
	
}

function targetNode()
{
	
}


function run($n)
{
	//$n will 
	squareInfectionCheck();
	if ($currentSqInf < 0.6)
	{
		targetNode();
	}
	else
	{
		squareMovement();
	}

}
?>

</body>
</html>