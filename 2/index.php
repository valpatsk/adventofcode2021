<?php
require_once("../dBug.php");
$the_file = file('input.txt');

$x=0;
$y=0;
$a=0;

foreach($the_file as $row){
    $tmp = explode(' ',$row);
    
    if($tmp[0]=='down')$a+=$tmp[1];
    if($tmp[0]=='up')$a-=$tmp[1];

    if($tmp[0]=='forward'){
        $x+=$tmp[1];
        $y+=$a*$tmp[1];
    }
}

echo $x*$y;