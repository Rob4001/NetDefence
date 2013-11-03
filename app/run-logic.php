<!DOCTYPE html>
<html>
<body>

<?php
error_reporting(E_ALL);

include 'game-logic.php';
include 'virus-logic.php';

$startLat = 55.858;
$startLon = -4.259;

$currentLat = 0;
$currentLon = 0;

$runPrevious = 0;

$virusUsername = virus;


function fileOpen()
{
	//file structure
	//run bit
	//current lat of virus
	//current lon of virus
	$temp=array(0,0,0);
	$file = fopen("conf.txt", "r") or exit("Unable to open file!");
	$i = 0;
	while(!feof($file))
	{
		temp[$i]fgets($file). "<br>";
		$i++;
	}
	fclose($file);
	
	$runPrevious = $temp[0];
	$currentLat = $temp[1];
	$currentLon = $temp[2];
}
	
function fileWrite()
{
	//make sure fileOpen() matches this file structure
	$temp=array($runPrevious,$currentLat,$currentLon);
	$file = fopen("conf.txt", "w") or exit("Unable to open file!");
	$i = 0;
	while(!feof($file))
	{
		temp[$i]fgets($file). "<br>";
		$i++;
	}
	fclose($file);

}

function checkRun()
{
	if ($runPrevious == 0)
	{
		$currentLat = $startLat;
		$currentLon = $startLon;
	}
}

fileOpen();
checkRun();
virus.run($currentLat,$currentLon);
fileWrite();
?>

</body>
</html>