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
    echo "
            <div class='graph-interface'>
            <div class='dropdown'>
                    <button class='btn-process btn btn-default dropdown-toggle' type='button' data-toggle='dropdown'>$process_active
                    <span class='caret'></span></button>
                        <ul class='dropdown-menu dropdown-scrollable'>";

                        for($i = 0; $i < count($select); $i++){
                            $process_select = str_replace("'","",$select[$i]);
                            if(strcmp($select[$i], $select_active) != 0){
                                echo "<li onclick='showGraph(0 ,this)'><a href='#'>$process_select</a></li>";
                            }else{
                                echo "<li class = 'disabled'><a href='#'>$process_select</a></li>";
                            }
                        }
                        echo "</ul>
            </div>";
    //It creates body of graph
    echo "<div expand = 'false' id='graph-container' dir='$file_name'></div>
            <div id='info-node-link' class='container-full'>
            <button  class='btn btn-xs btn-primary btn-block' onclick='clickSizeToggle()'>Change graph's size</button>
                <h2> <small id='node'>Node:  <strong><span id='node'></small></span></strong><h2>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                            <tr>
                                <td><small><strong>Target</strong></small></td>
                                <td><small><strong>Label</strong></small></td>
                            </tr>
                        </thead>
                        <tbody id='target'>
                        </tbody>
                    </table>  
        </div>
        </div>";
?>
<!DOCTYPE html>
<html lang="en">
<head> 

</head>



