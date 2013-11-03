<!DOCTYPE html>
<html>
<body>

<?php
error_reporting(E_ALL);

include 'game-logic.php';

//start location

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


function run($l1,$l2)
{
	
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