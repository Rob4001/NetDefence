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
	
}

function squareMovement($l1,$l2)
{
	
}

function targetNode()
{
	//todo list APs in currentLocation
	//target weakest first
	
	
}

function run($l1,$l2)
{
	
	if ($currentSqInf < 0.6)
	{
		targetNode();
	}
	else
	{
		x$ = rand(0,1);
		if ($x=1)
		{
			squareMovement();
		}
		else
		{
			$x = rand(0,10);
			if (x < 8)
			{
				updateNodeResources();
				if (resources > 90)
				{
					targetNode();
				}
			}
		}
	}

}
?>

</body>
</html>