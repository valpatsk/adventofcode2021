<?php
require_once("../dBug.php");
require_once("../functions.php");
$rows = file('input.txt');

$the_matrix = [];

foreach($rows as $row_id=>$row){
    for($i=0;$i<strlen(trim($row));$i++){
        $the_matrix[$row_id][$i]=$row[$i];
    }
}

//ew dBug($the_matrix);


$risk_level=0;
$lows=array();
for($i=0;$i<count($the_matrix);$i++){
    for($j=0; $j<count($the_matrix[$i]); $j++){
        //t
        if(isset($the_matrix[$i][$j-1])){
            if($the_matrix[$i][$j]>=$the_matrix[$i][$j-1])continue;
        }
        //b
        if(isset($the_matrix[$i][$j+1])){
            if($the_matrix[$i][$j]>=$the_matrix[$i][$j+1])continue;
        }
        //r
        if(isset($the_matrix[$i+1][$j])){
            if($the_matrix[$i][$j]>=$the_matrix[$i+1][$j])continue;
        }
        //l
        if(isset($the_matrix[$i-1][$j])){
            if($the_matrix[$i][$j]>=$the_matrix[$i-1][$j])continue;
        }
        //echo $the_matrix[$i][$j].'<br>';
        $risk_level += ($the_matrix[$i][$j]+1);
    }
}
//echo $risk_level.'<br>';
for($i=0;$i<count($the_matrix);$i++){
    for($j=0; $j<count($the_matrix[$i]); $j++){
        if($the_matrix[$i][$j]==9)continue;
        $the_matrix[$i][$j]=0;
    }
}

echo_matrix($the_matrix);
echo '<br>';
$bass=[];

for($i=0;$i<count($the_matrix);$i++){
    for($j=0; $j<count($the_matrix[$i]); $j++){
        if($the_matrix[$i][$j]!=0)continue;
        $bass[]=colorBass($i,$j);
    }
}
rsort($bass);
new dBug($bass);
echo $bass[0]*$bass[1]*$bass[2];




function colorBass($i,$j){
    //echo 'start: '.$i.' '.$j.'<br>';
    global $the_matrix;
    if(!isset($the_matrix[$i][$j]))return 0;
    if($the_matrix[$i][$j]==9) return 0;
    if($the_matrix[$i][$j]==1) return 0;

    $ret =1;
    if($the_matrix[$i][$j]==1)$ret =0;

    $the_matrix[$i][$j]=1;
    $ret+=colorBass($i,$j+1);
    $ret+=colorBass($i+1,$j);
    $ret+=colorBass($i,$j-1);
    $ret+=colorBass($i-1,$j);
    //echo 'end'.$i.' '.$j.'<br>';
    return $ret;
}