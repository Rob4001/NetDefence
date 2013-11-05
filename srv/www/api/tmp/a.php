<?php
echo "sjdbbj";

include("csvreader.php");
$CSVreader = new CSVreader();
$array = $CSVreader->setSource(file_get_contents("data.csv"))->parse();
var_dump($array);
echo "lskndnk";
?>