<?php
//Maude's directory
$DIR_MAUDE = exec('which maude');  //<- YOU MUST CHANGE HERE
$DIR_FILE_MAUDE = "../system/semantics.maude";
$MODF = "-no-banner";


//$input = $_GET["sendTxt"];
$input = "'F_0 =d= tau \ 'u_0_R . tau \ 'd_0 .{ 'F_0 }+ 'u_0_L 4\ tau . 'd_0 \ tau .{ 'F_0 }; 'F_1 =d= tau \ 'u_1_R . tau \ 'd_1 .{ g'F_1 }+ 'u_1_L \ tau . 'd_1 \ tau .{ 'F_1 }; 'dF_2 =d= tau \ 'u_2_R . tau \ 'd_2 .{ 'F_2 }+ 'u_2_L \ tau . 'd_2 \ tau .{ 'F_2 }; 'P_0 =d= tau \ 'think_0 .{ 'P_0 }+ 'u_0_R \ 'u_1_L .{ 'eat_0 }; 'P_1 =d= tau \ 'think_1 .{ 'P_1 }+ 'u_1_R \ 'u_2_L .{ 'eat_1 }; 'P_2 =d= tau \ 'think_2 .{ 'P_2 }+ 'u_2_R \ 'u_0_L .{ 'eat_2 }; 'eat_0 =d= tau \ 'eat_0 .{ 'release_0 }; 'eat_1 =d= tau \ 'eat_1 .{ 'release_1 }; 'eat_2 =d= tau \ 'eat_2 .{ 'release_2 }; 'release_0 =d= 'd_0 \ 'd_1 .{ 'P_0 }; 'release_1 =d= 'd_1 \ 'd_2 .{ 'P_1 }; 'release_2 =d= 'd_2 \ 'd_0 .{ 'P_2 }; 'System =d= [ 'd_0 , 'd_1 , 'd_2 , 'u_0_L , 'u_0_R , 'u_1_L , 'u_1_R , 'u_2_L , 'u_2_R ]{ 'P_2 }|({ 'F_2 }|({ 'P_1 }|({ 'F_1 }|({ 'P_0 fd}|{ 'F_0 }))))";
$array_input = explode(";", $input);


for ($i = 0; $i<count($array_input);$i++){
    $equal = stripos($array_input[$i], "=");
    $process = substr($array_input[$i], 0, $equal);
    $COMMAND = "parse generateDot( { ". $process ." } , " . $array_input[$i] . " ) . " ;
    $COMMAND = escapeshellarg($COMMAND);
    $result =  shell_exec("echo $COMMAND | $DIR_MAUDE $DIR_FILE_MAUDE $MODF 2>&1 ");
    if(preg_match("/Warning/i" , $result)){
        echo "line " . $i . " => " . $result . "<br>";
    }
}


$result =  shell_exec("echo $COMMAND | $DIR_MAUDE $DIR_FILE_MAUDE $MODF 2>&1 ");
//echo $cleanResult;


?>