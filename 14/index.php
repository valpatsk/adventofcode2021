<?php
require_once("../dBug.php");
require_once("../functions.php");
$rows = file('input.txt');
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

ini_set('memory_limit', '9000M');
set_time_limit(300);

$polimer = [];
$commands=array();
$do_commands=0;

foreach($rows as $row){
    $row=trim($row);
    if($row==''){
        $do_commands=1;
        continue;
    }
    if($do_commands){
        $tmp = explode(" -> ",$row);
        $commands[$tmp[0]]=$tmp[1];
    }else{
        $polimer = $row;
    }
}

new dBUg($polimer);
new dBUg($commands);

$pairs=[];
for($j=0;$j<strlen($polimer)-1;$j++){
    $pairs[$polimer[$j].$polimer[$j+1]]++;
}


//new dBUg($pairs);


for($i=0;$i<40;$i++){
    $new_pairs=array();
    $the_letters = [];
    foreach($pairs as $pair=>$pair_amount){
        $the_letters[$pair[0]]+=$pair_amount;
        $the_letters[$commands[$pair]]+=$pair_amount;
        $new_pairs[$pair[0].$commands[$pair]]+=$pair_amount;
        $new_pairs[$commands[$pair].$pair[1]]+=$pair_amount;
    }
    $pairs=$new_pairs;
    //last letter of the string is taken from first polimer
    $the_letters[substr($polimer, -1)]++;
}



new dBUg($pairs);
new dBUg($the_letters);

$max = max($the_letters);
$min=min($the_letters);

echo $max-$min;








/*

//prepared commands too slow

$prepared_commands=[];

//substr('a,b,c,d,e,', 0, -1);

for($i=0;$i<1;$i++){
    //echo '<br><br>';
    $new_polimer="";
    for($j=0;$j<strlen($polimer);$j+=7){
        
        if(!isset($polimer[$j+1])){
            //echo '1';
            $the_command = $polimer[$j]; //one letter
            $add = commands_result($the_command);
        }elseif(!isset($polimer[$j+2])){
            //echo '2';
            $the_command = $polimer[$j].$polimer[$j+1];//two letters
            $add = commands_result($the_command);
        }elseif(!isset($polimer[$j+3])){
            $the_command = $polimer[$j].$polimer[$j+1].$polimer[$j+2];//3
            $add = commands_result($the_command);
        }elseif(!isset($polimer[$j+4])){
            $the_command = $polimer[$j].$polimer[$j+1].$polimer[$j+2].$polimer[$j+3];//4
            $add = commands_result($the_command);
        }elseif(!isset($polimer[$j+5])){
            $the_command = $polimer[$j].$polimer[$j+1].$polimer[$j+2].$polimer[$j+3].$polimer[$j+4];//5
            $add = commands_result($the_command);
        }elseif(!isset($polimer[$j+6])){
            $the_command = $polimer[$j].$polimer[$j+1].$polimer[$j+2].$polimer[$j+3].$polimer[$j+4].$polimer[$j+5];//6
            $add = commands_result($the_command);
        }else{
            //echo '!';
            $the_command = $polimer[$j].$polimer[$j+1].$polimer[$j+2].$polimer[$j+3].$polimer[$j+4].$polimer[$j+5].$polimer[$j+6];
            if(!isset($prepared_commands[$the_command])){
                $prepared_commands[$the_command] = commands_result($the_command);
            }
            $add = $prepared_commands[$the_command];
        }

        //glue part
        if($j>0){
            $new_polimer .=  $commands[substr($new_polimer, -1).$add[0]];
        }
        $new_polimer .= $add;

    }
    

    $polimer = $new_polimer;
    echo "<br>".$polimer;
    echo '<hr>';
}
new dBUg($prepared_commands);


$amunts = [];
echo 'Counting:<br>';
for($c=0;$c<strlen($polimer);$c++){
    $amounts[$polimer[$c]]++;
}


exit;



//$flipped_amounts = array_flip($amounts);
$max = max($amounts);
$min=min($amounts);

echo $max-$min;
new dBug($amounts);
// /new dBug($flipped_amounts);
*/




function commands_result($str){
    global $commands;
    $result = '';
    for($j=0;$j<strlen($str)-1;$j++){
        $result.=$str[$j].$commands[$str[$j].$str[$j+1]];
    }
    $result.=$str[$j];
    return $result;
}