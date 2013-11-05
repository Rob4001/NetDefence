
<?php

header('Access-Control-Allow-Origin: http://geeksoc-hackathon.tk');

include("api.php");
$api = new DataAPI();

if(isset($_GET['currentLocation'])) { 
?>
	<body onload="getLocation()">
	<script>
	function getLocation() {
 		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);
    		}
 		 else {
			x.innerHTML="Geolocation is not supported by this browser.";
		}
	}
	function showPosition(position) {
  		var lat = position.coords.latitude;
  		var lon = position.coords.longitude;
		window.location.href = "http://api.geeksoc-hackathon.tk/data/map.php?lat=" + lat + "&lon=" + lon;	
  	}
	</script>
<?php } 
else if(isset($_GET['lat']) && is_numeric($_GET['lat']) && isset($_GET['lon']) && is_numeric($_GET['lon'])) {

$_GET['lat'] = round($_GET['lat'], 3);
$_GET['lon'] = round($_GET['lon'], 3);

if(isset($_GET['scale'])) {
	if(is_numeric($_GET['scale'])) {
		$min = -floor($_GET['scale'] / 2);
		$max = ceil($_GET['scale'] / 2);
		// set x
		// set y
	}
	else {
		$min = -2;
		$max = 3;
	}
}
else {
	$min = -2;
	$max = 3;
}

$json = array();
$i = 0;
for($x = $min; $x < $max; $x++) {
	for($y = $min; $y < $max; $y++) {
		$json[$i] = $api->nodesOnAxis($_GET['lat'] + ($y * 0.001), $_GET['lon'] + ($x * 0.001));
		$i++;
	}
}

echo json_encode($json);

}
else {
	return "no data allowed";
}