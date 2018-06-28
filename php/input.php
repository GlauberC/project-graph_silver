<?php
//Read command from index.html text
$input = $_GET["txt"];
    //[0] => Type, [1] => Option, [2] => Command
$select_option = explode("=>", $input);
$array_input = explode(";", $select_option[2]);
$select = array();

for($i = 0; $i < count($array_input) ; $i++){
    $options = explode("=", $array_input[$i]);
    $select[$i] = $options[0];
}
$select_active = (strcmp($select_option[0], "EXPLORE") == 0?$select[0]:$select_option[1]);

$COMMAND = "red generateDot( { ".$select_active ."} , (" . implode(" , " ,$array_input) . ") ) .";


//Maude's directory
$DIR_MAUDE = exec('which maude');  //<- YOU MUST CHANGE HERE
$DIR_FILE_MAUDE = "../system/semantics.maude";
$MODF = "-no-banner";

//It runs the SiLVer on Maude from maude-silver-run.php File
require_once ("maude-silver-run.php");
$file_name = createFile($COMMAND, $DIR_MAUDE, $DIR_FILE_MAUDE, $MODF);
//Add the list of options with dropmenu
$process_active = str_replace("'","",$select_active);
?>
