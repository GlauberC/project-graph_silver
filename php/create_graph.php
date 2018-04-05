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
    $DIR_MAUDE = "/usr/bin/maude";  //<- YOU MUST CHANGE HERE
    $DIR_FILE_MAUDE = "/opt/lampp/htdocs/project-graph_silver/data/semantics.maude";    //<- YOU MUST CHANGE HERE
    $MODF = "-no-banner";

    //It runs the SiLVer on Maude from maude-silver-run.php File
    require_once ("maude-silver-run.php");
    $file_name = createFile($COMMAND, $DIR_MAUDE, $DIR_FILE_MAUDE, $MODF);
    //Add the list of options
    /*
    echo "<select onchange='showGraph()'>";
    echo "<option>$select_active</option>";
    for($i = 0; $i < count($select); $i++){
        if(strcmp($select[$i], $select_active) != 0){
            echo "<option>$select[$i]</option>";
        }
        
    }
    echo "</select>";
    */
    echo "<div class='dropdown'>
        <button class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown'>$select_active
        <span class='caret'></span></button>
            <ul class='dropdown-menu'>";

            for($i = 0; $i < count($select); $i++){
                if(strcmp($select[$i], $select_active) != 0){
                    echo "<li onclick='showGraph(0 ,this)'><a href='#'>$select[$i]</a></li>";
                }else{
                    echo "<li class = 'disabled'><a href='#'>$select[$i]</a></li>";
                }
            }
            echo "</ul>
        </div>";
    //It creates body of graph
    echo "<div id='graph-container' dir='$file_name'>
    
    </div>
    <div id='info-node-link' class='container-full'>
        <h2> <small id='node'>Node:  <strong><span id='node'></small></span></strong><h2>
        <table class='table table-striped table-condensed'>
            <thead>
                <tr>
                    <td><small><strong>Target</strong></small></td>
                    <td><small><strong>Label</strong></small></td>
                </tr>
            </thead>
            <tbody id='target'>
            </tbody>
        </table> 
    
    </div>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style type="text/css">

        .link {stroke: rgba(0, 0, 0, .8); stroke-opacity: .4; stroke-width: 1.2px;}
        div#info-node-link{
            margin: 2em;
        }
        small#node{
            font-size: .6em
        }
        td{
            font-size: .8em
        }
        svg{
            box-shadow: 1px 1px 1px 2px rgba(222,222,222,0.2);
        }
    </style>
  

</head>



