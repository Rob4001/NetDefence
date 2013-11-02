<!DOCTYPE html>
<html>
<body>

<?php
error_reporting(E_ALL);

function l2mconvert($lat, $lon)
{
	$GLat = 55.8580;
	$GLon = -4.2590;

	$R = 6371000; // m
	$dLat = deg2rad($lat - $GLat);
	$dLon = deg2rad($lon - $GLon);
	$GLatR = deg2rad($GLat);
	$latR = deg2rad($lat2);

	$a = sin($dLat/2) * sin($dLat/2) + sin($dLon/2) * sin($dLon/2) * cos($GLatR) * cos($latR); 
	$c = 2 * atan2(sqrt($a), sqrt(1 - $a)); 
	$d = $R * $c; //pure distance to node
	
	//calculating x,y of node
	$y = -($GLat - $lat);
	$x = -($GLon - $lon);
	print "x value $x";
	print "y value $y<br>";
}

print "1<br>";
l2mconvert(56,-5);
print "2<br>";
l2mconvert(56,-3);
print "3<br>";
l2mconvert(54,-5);
print "4<br>";
l2mconvert(54,-3);
/*
function loadDatabase()
{
	$con=mysqli_connect(host,username,password,dbname);

	// Check connection
	if (mysqli_connect_errno($con))
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$dbLatLon = mysqli_query($con,"SELECT latitude, longitude FROM Wifi-Points");
	
	while($row = mysqli_fetch_array($dbLatLon))
	{
		$something = $row['latitude']
	}
	
	mysqli_close($con);
	
	updateDatabase($result);
}
*/
/*
function updateDatabase($distanceUpdate)
{
	$con=mysqli_connect(host,username,password,dbname);

	// Check connection
	if (mysqli_connect_errno($con))
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	
	
	mysqli_close($con);
}
*/
?>

</body>
</html>