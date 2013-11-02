<?php
// example to use database class

include("class.database.php");


try {
	$database = new PDODB("localhost", "username", "password", "dbname");
}
catch (Exception $e) {
	die("Fatal error: " . $e->getMessage());
}

// Simple sql query
$database->query("SELECT * FROM TABLE");
$database->execute();

// get 1 result
$result1 = $database->fetchResult();

// get all results
$resultsAll = $database->fetchResultSet();


// advanced query

$database->query("SELECT * FROM table WHERE id = :id, somethingElse = :something");
$database->bind(":id", $id);
$database->bind(":something", $something);

?>
