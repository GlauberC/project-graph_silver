<?php
//Maude's directory
$DIR_MAUDE = exec('which maude');
$DIR_FILE_MAUDE = "../system/modelchecking.maude";
$MODF = "-no-banner";


$input = $_GET["txt"];
$COMMAND = $input;
$COMMAND = escapeshellarg($COMMAND);
$result =  shell_exec("echo $COMMAND | $DIR_MAUDE $DIR_FILE_MAUDE $MODF 2>&1 ");
echo $result;



?>
