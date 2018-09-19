<?php
//Read command from index.html text
$input = $_GET["txt"];

$COMMAND = $input;

//Maude's directory
$DIR_MAUDE = exec('which maude');  //<- YOU MUST CHANGE HERE
$DIR_FILE_MAUDE = "../system/modelchecking.maude";
$MODF = "-no-banner";
$COMMAND = escapeshellarg($COMMAND);
$result =  shell_exec("echo $COMMAND | $DIR_MAUDE $DIR_FILE_MAUDE $MODF 2>&1 ");
//It runs the SiLVer on Maude from maude-silver-run.php File
if (preg_match("/BISIMULATION/i" , $COMMAND)){
  // echo "<br><br>Saida:<br>" . $result;
  preg_match('/in\s\d+ms/i', $result, $subtime);
  preg_match('/\d+/i', $subtime[0], $time);
  $equal = stripos($result, "result Bool:");
  $response = substr($result, $equal + 13, 5);

  if(preg_match("/false/i" , $response)){
    echo "$time[0] ms;<span class='glyphicon glyphicon-remove text-danger'></span>";
  }else{
    echo "$time[0] ms;<span class='glyphicon glyphicon-ok text-success'></span>";
  }
}else{
  preg_match('/in\s\d+ms/i', $result, $subtime);
  preg_match('/\d+/i', $subtime[0], $time);
  if(preg_match("/Bool:\strue/i" , $result)){
    echo "$time[0] ms;<span class='glyphicon glyphicon-ok text-success'></span>";
  }else{
    echo "$time[0] ms;<span class='glyphicon glyphicon-remove text-danger'></span>";
  }
}




?>
