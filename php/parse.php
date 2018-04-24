<?php

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
$DIR_MAUDE = "/usr/bin/maude";  //<- YOU MUST CHANGE HERE
$DIR_FILE_MAUDE = "../system/semantics.maude";
$MODF = "-no-banner";

$result =  shell_exec("echo $COMMAND | $DIR_MAUDE $DIR_FILE_MAUDE $MODF 2>&1 ");
echo $result;

?>