<?php
//Read command from index.html text
$input = $_GET["txt"];
echo "Comando:<br>" . $input;
$COMMAND = $input;
// $COMMAND = "red in SLML_MC :  modelCheck({'A} , 'A =d= 'a \ 'b . {'A } + 'c \ 'd . 0 , [] (<< 'a \ 'b >> tt)) .";

//Maude's directory
$DIR_MAUDE = exec('which maude');  //<- YOU MUST CHANGE HERE
$DIR_FILE_MAUDE = "../system/modelchecking.maude";
$MODF = "-no-banner";
$COMMAND = escapeshellarg($COMMAND);

//It runs the SiLVer on Maude from maude-silver-run.php File
$result =  shell_exec("echo $COMMAND | $DIR_MAUDE $DIR_FILE_MAUDE $MODF 2>&1 ");
echo "<br><br>Saida:<br>" . $result;

// $equal = stripos($result, "result Bool:");
// $response = substr($result, $equal + 13, 5);
//
// if(preg_match("/false/i" , $response)){
//   echo "<span class='glyphicon glyphicon-remove text-danger'></span>";
// }else{
//   echo "<span class='glyphicon glyphicon-ok text-success'></span>";
// }
?>
