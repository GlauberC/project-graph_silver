<?php
//Maude's directory
$DIR_MAUDE = exec('which maude');  //<- YOU MUST CHANGE HERE
$DIR_FILE_MAUDE = "../system/semantics.maude";
$MODF = "-no-banner";


$input = $_GET["txt"];
$array_input = explode(";", $input);
$warning = 0;
$line = 0;
for ($i = 0; $i<count($array_input);$i++){
    $equal = stripos($array_input[$i], "=");
    $process = substr($array_input[$i], 0, $equal);
    $COMMAND = "parse generateDot( { ". $process ." } , " . $array_input[$i] . " ) . " ;
    $COMMAND = escapeshellarg($COMMAND);
    $result =  shell_exec("echo $COMMAND | $DIR_MAUDE $DIR_FILE_MAUDE $MODF 2>&1 ");
    $line++;
    if(preg_match("/Warning/i" , $result)){
        echo "line $line " . $result . "<br>";
        $warning++;
    }
}
if($warning == 0){
    echo 'success';
}


?>