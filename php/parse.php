<?php

$input = $_GET["sendTxt"];
$process = explode("=", $input)[0];

$array_input = explode(";", $input);
$select = array();
    
$COMMAND = "parse generateDot( { ".$process ."} , (" . implode(", " ,$array_input) . ") ) .";
$COMMAND = escapeshellarg($COMMAND);

//Maude's directory
$DIR_MAUDE = "/usr/bin/maude";  //<- YOU MUST CHANGE HERE
$DIR_FILE_MAUDE = "../system/semantics.maude";
$MODF = "-no-banner";

$result =  shell_exec("echo $COMMAND | $DIR_MAUDE $DIR_FILE_MAUDE $MODF 2>&1 ");
$cleanResult = str_replace("\n", "", $result);
$cleanResult = str_replace("Maude>", "", $cleanResult);
$cleanResult = str_replace("Bye.", "", $cleanResult);
echo $cleanResult;


?>