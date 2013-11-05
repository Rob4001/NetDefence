<?php
echo "hello";

error_reporting(E_ALL);
register_shutdown_function( "fatal_handler" );

$lines = str_getcsv(file_get_contents("data.csv"));

foreach($lines as $line) {
	$values = str_getcsv($line);
	
	print_r($values);
}


/*include("class.database.php");

try {
	$database = new PDODB("localhost", "root", "geeksoc", "loaded");
}
catch (Exception $e) {
	die("Fatal error: " . $e->getMessage());
}
*/

/*
echo "<br />getting csv data";
$csv = file_get_contents("data.csv");
echo "<br />csv = gotten<br />Converting to array";

$rawdata = str_getcsv($csv);
echo "<br />array created";

var_dump($rawdata);


$numberOfRecords = count($rawdata) / 12;
echo "Number of records: " . $numberOfRecords;

$records = array();



for($i = 1; $i < $numberOfRecords; $i++) {
	$records[$i] = array_slice($rawdata, ($i * 12), 12);
}

for($j = 0; $j < 10; $j++) {
	var_dump($records[$j]);
}
	*/
	
/*
$database->beginTransaction();

$database->query("INSERT INTO networks (ID,HORIZONTAL_ACCURACY,RSSI,SSID,CHANNEL,SECURITY,LATITUDE,LONGITUDE,CREATED_AT,BSSID,NUM_SSID,QUALITY) 
	VALUES (:id, :ha, :rssi, :ssid, :channel, :security, :lat, :long, :created, :bssid, :numssid, :quality)");
	

foreach($records as $record){

    // now loop through each inner array to match binded values
    foreach($insertRow as $column => $value){
        $stmt->bindParam(":{$column}", value);
        $stmt->execute();
    }
}


$dbh->commit();
*/



function fatal_handler() {
	global $headers,$server;
	$errfile = "unknown file";
	$errstr  = "shutdown";
	$errno   = E_CORE_ERROR;
	$errline = 0;
	$error = error_get_last();
	
	if($error !== NULL) {
		$errno   = $error["type"];
		$errfile = $error["file"];
		$errline = $error["line"];
		$errstr  = $error["message"];
		$errmsg = format_error($errno, $errstr, $errfile, $errline);
	}
}

function format_error( $errno, $errstr, $errfile, $errline ) {
	$trace = print_r( debug_backtrace( false ), true );
	$content  = "<table><thead bgcolor='#c8c8c8'><th>Item</th><th>Description</th></thead><tbody>";
	$content .= "<tr valign='top'><td><b>Error</b></td><td><pre>$errstr</pre></td></tr>";
	$content .= "<tr valign='top'><td><b>Errno</b></td><td><pre>$errno</pre></td></tr>";
	$content .= "<tr valign='top'><td><b>File</b></td><td>$errfile</td></tr>";
	$content .= "<tr valign='top'><td><b>Line</b></td><td>$errline</td></tr>";
	$content .= "<tr valign='top'><td><b>Trace</b></td><td><pre>$trace</pre></td></tr>";
	$content .= '</tbody></table>';
	return $content;
}

