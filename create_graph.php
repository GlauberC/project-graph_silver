<?php
    $COMMAND = $_GET["txt"];
    
/*
    // Test of Script
    echo passthru("./callMaude.sh $COMMAND");
*/  
    
    $DIR_MAUDE = "/usr/bin/maude";
    $DIR_FILE_MAUDE = "/home/glauberca/Documentos/Silver/semantics.maude";
    $MODF = "-no-banner";
    require_once ("maude-silver-run.php");
    $file_name = createFile($COMMAND, $DIR_MAUDE, $DIR_FILE_MAUDE, $MODF);

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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="http://d3js.org/d3.v4.min.js" type="text/javascript"></script>
    <script src="http://d3js.org/d3-selection-multi.v1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">

        .link {stroke: rgba(0, 0, 0, .8); stroke-opacity: .4; stroke-width: 0.8px;} 
        div#info-node-link{
            margin: 2em;
        }
        small#node{
            font-size: .6em
        }
        td{
            font-size: .8em
        }
    </style>    

</head>



