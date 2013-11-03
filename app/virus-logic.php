<!DOCTYPE html>
<html>
<body>

<?php
error_reporting(E_ALL);

include 'game-logic.php';

//start location

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
	//$n will indicate initial run or not
	if (n
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