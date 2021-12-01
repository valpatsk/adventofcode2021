<?php
require_once("../dBug.php");
$the_file = file('input.txt');

$increased = 0;
$previous=0;
foreach($the_file as $line_number => $line){
    $current = intval($line);
    if($line_number >0 && $current > $previous){
        $increased++;
    }
    $previous = $current;
}

echo 'Single: '.$increased;
echo '<hr>';

$increased = 0;
$previous = array();
$current = array();
foreach($the_file as $line_number => $line){
    array_push($current,intval($line));
    //new dBUg($current);
    if(count($current) > 3){
        array_shift($current);
    }
    //new dBUg($current);
    //new dBUg($previous);
    if(count($previous)==3 && array_sum($current) > array_sum($previous))$increased++;
    $previous = $current;
}

echo 'Tripple: '.$increased;