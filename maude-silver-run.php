<?php
function outputCut($output) {
    $begin = stripos($output, "result") + 15;
    $end = stripos($output, "Bye") - $begin - 8;
    return substr($output , $begin, $end);
}
function simplifyStringNode($output){
    $simplifyOutput = array(); 
    for($i = 1; $i<count($output);$i++){
        if(stripos($output[$i], "->") == false){
            $equal = stripos($output[$i], "=");
            $closeBrackets = stripos($output[$i], '\"]');
            $id = substr($output[$i], $equal+4, $closeBrackets - ($equal+4));
            array_push($simplifyOutput,$id);
        }
    }
    return $simplifyOutput;
}
function createJsonNode($arrayNodes, $temp){
    $obj = new stdClass();
    for($i=0; $i<count($arrayNodes) - 1; $i++){
        
        $obj->id = $arrayNodes[$i];
        $obj->group = $i%20 + 1;
        $myJSON = json_encode($obj);
        $myJSON = str_replace("\\", "", $myJSON);
        
        if($i>count($arrayNodes) - 3){
            fwrite($temp, $myJSON);
        }else{
            fwrite($temp, $myJSON .",");
        }
    }
}
function createJsonLink($output, $nodes, $temp){
    $obj = new stdClass();
    for($i=0; $i<count($output) ; $i++){
        //Separate source, target and label
        if(!(stripos($output[$i], "->")) == false){
            $arrow = stripos($output[$i], "->");
            $S = stripos($output[$i], "S");
            $equal = stripos($output[$i], "=");
            $closeBrackets = stripos($output[$i], '\"]');
            $indexSource =  substr($output[$i], $S+1, $arrow - ($S+2));
            $indexTarget = substr($output[$i], $arrow + 4, $equal - 8 - ($arrow + 4) );
            $label = substr($output[$i], $equal+4, $closeBrackets - ($equal+4));


            //Create JSON
            $obj->source = $nodes[$indexSource];
            $obj->target = $nodes[$indexTarget];
            $obj->type = $label;
            $myJSON = json_encode($obj);
            $myJSON = str_replace("\\", "", $myJSON);
            if($i>count($output)-3){
                fwrite($temp, $myJSON);
            }else{
                fwrite($temp, $myJSON .",");
            } 
        }
    }
}
function createFile($COMMAND, $DIR_MAUDE, $DIR_FILE_MAUDE, $MODF){

    $COMMAND = escapeshellarg($COMMAND);

    $result =  shell_exec("echo $COMMAND | $DIR_MAUDE $DIR_FILE_MAUDE $MODF 2>&1 ");
    $cutOutputString = outputCut($result);
    $cutOutputArray = explode(';', $cutOutputString);

    $nodes = simplifyStringNode($cutOutputArray);
    //Create a file
    
    $tmpfname = tempnam("./output", "maudetmp_");
    $temp = fopen($tmpfname, "w");
    fwrite($temp, "{    \"nodes\": [");
    createJsonNode($nodes, $temp);
    fwrite($temp, "  ],");

    fwrite($temp, "    \"links\": [");
    createJsonLink($cutOutputArray, $nodes, $temp);
    fwrite($temp, "  ]}");


    fseek($temp, 0);
    fclose($temp);
    chmod($tmpfname, 0444); // PERMISSIONS
    return "./output/" . basename($tmpfname);
}























// TEST FUNCTIONS

function simplifyStringNodeTest($output){
    //print_r($output);
    //echo "<br/><br/>";
    $simplifyOutput = array(); 
    for($i = 1; $i<count($output);$i++){
        //echo $output[$i] . "<br/>";
        if(stripos($output[$i], "->") == false){
            //echo $output[$i] . "<br/>";
            $equal = stripos($output[$i], "=");
            //$closeBrackets = stripos($output[$i], "]");
            $closeBrackets = stripos($output[$i], '\"]');
            $id = substr($output[$i], $equal+4, $closeBrackets - 0 - ($equal+4));
            //echo $id . "<br/>";
            array_push($simplifyOutput,$id);
        }
    }
    return $simplifyOutput;
}

function testJsonNode($arrayNodes){
    $obj = new stdClass();
    echo "NODES:<br/>";
    for($i=0; $i<count($arrayNodes) - 1; $i++){
        
        $obj->id = $arrayNodes[$i];
        $obj->group = $i%20 + 1;
        $myJSON = json_encode($obj);
        $myJSON = str_replace("\\", "", $myJSON);
        
        if($i>count($arrayNodes) - 3){
            echo $myJSON . "<br/>";
        }else{
            echo $myJSON . ",<br/>";
        }
    }
    echo "<br/><br/>";
}

function testJsonLink($output, $nodes){
    $obj = new stdClass();
    echo "LINKS:<br/>";
    for($i=0; $i<count($output) ; $i++){
        //Separate source, target and label
        if(!(stripos($output[$i], "->")) == false){
            $arrow = stripos($output[$i], "->");
            $S = stripos($output[$i], "S");
            $equal = stripos($output[$i], "=");
            $closeBrackets = stripos($output[$i], '\"]');
            $indexSource =  substr($output[$i], $S+1, $arrow - ($S+2));
            $indexTarget = substr($output[$i], $arrow + 4, $equal - 8 - ($arrow + 4) );
            $label = substr($output[$i], $equal+4, $closeBrackets - 0 - ($equal+4));


            //Create JSON
            $obj->source = $nodes[$indexSource];
            $obj->target = $nodes[$indexTarget];
            $obj->type = $label;
            $myJSON = json_encode($obj);
            $myJSON = str_replace("\\", "", $myJSON);
            if($i>count($output)-3){
                echo $myJSON . "<br/>";
            }else{
                echo $myJSON . ",<br/>";
            } 
        }
    }
}


function testNodeAndLink($COMMAND, $DIR_MAUDE, $DIR_FILE_MAUDE, $MODF){
    $COMMAND = escapeshellarg($COMMAND);

    $result =  shell_exec("echo $COMMAND | $DIR_MAUDE $DIR_FILE_MAUDE $MODF 2>&1 ");
    //echo $result . "<br/><br/>";
    $cutOutputString = outputCut($result);
    //echo $cutOutputString . "<br/><br/>";
    $cutOutputArray = explode(';', $cutOutputString);
    //print_r($cutOutputArray);
    //echo "<br/><br/>";

    $nodes = simplifyStringNodeTest($cutOutputArray);
    //print_r($nodes);
    //echo "<br/><br/>";
    
    testJsonNode($nodes);
    testJsonLink($cutOutputArray, $nodes);


}
?>