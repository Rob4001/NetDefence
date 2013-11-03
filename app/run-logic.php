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

$virusUsername = virus;


function fileOpen()
{
	//file structure
	//run bit
	//current lat
	//current lon
	$temp=array(0,0,0);
	$file = fopen("welcome.txt", "r") or exit("Unable to open file!");
	while(!feof($file))
	{
		temp[$i]fgets($file). "<br>";
		$i++;
	}
	fclose($file);
}
?>

</body>
</html>