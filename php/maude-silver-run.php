<?php
//Main function
function createFile($COMMAND, $DIR_MAUDE, $DIR_FILE_MAUDE, $MODF){
    $COMMAND = escapeshellarg($COMMAND);

    //Run
    $result =  shell_exec("echo $COMMAND | $DIR_MAUDE $DIR_FILE_MAUDE $MODF 2>&1 ");

    //Break the lines to array
    $cutOutputString = outputCut($result);
    $cutOutputArray = explode(';', $cutOutputString);

    $nodes = simplifyStringNode($cutOutputArray);

    //Create a file
    $tmpfname = tempnam("./../output", "maudetmp_");
    $temp = fopen($tmpfname, "w");
    fwrite($temp, "{    \"nodes\": [");
    //Create nodes
    createJsonNode($nodes, $temp);
    fwrite($temp, "  ],");

    fwrite($temp, "    \"links\": [");
    //Create Links
    createJsonLink($cutOutputArray, $nodes, $temp);
    fwrite($temp, "  ]}");

    //Close file
    fseek($temp, 0);
    fclose($temp);
    chmod($tmpfname, 0444); // PERMISSIONS
    
    //Send the file's name
    return "./output/" . basename($tmpfname);
}

//It cuts result's string
function outputCut($output) {
    $begin = stripos($output, "result") + 15;
    $end = stripos($output, "Bye") - $begin - 8;
    return substr($output , $begin, $end);
}

//It separates node and links 
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

// It creates an array of nodes
function createJsonNode($arrayNodes, $temp){
    $obj = new stdClass();
    for($i=0; $i<count($arrayNodes) - 1; $i++){
        
        //It creates a json model
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

// It creates an array of links
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


            //It creates a json model
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

