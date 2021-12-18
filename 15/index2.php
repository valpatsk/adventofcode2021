<?php
$start = microtime(true);
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("../dBug.php");
require_once("../functions.php");
$rows = file('input.txt');

$the_matrix = [];

foreach($rows as $row_id=>$row){
    for($i=0;$i<strlen(trim($row));$i++){
        $the_matrix[$row_id][$i]=$row[$i];
    }
}

$the_size_xy = count($the_matrix);
$big_matrix = [];

for($i=0; $i <5; $i++){
    for($j=0; $j <5; $j++){
        for($a=0;$a<count($the_matrix);$a++){
            for($b=0;$b<count($the_matrix[$a]);$b++){
                $new_val = $the_matrix[$a][$b] + $i+ $j;
                if($new_val>9)$new_val = $new_val-9;
                $big_matrix[$the_size_xy*$i + $a][$the_size_xy*$j + $b]=$new_val;
            }
        }
    }
}

$the_matrix = $big_matrix;

$the_size_xy = count($the_matrix);
$sum_matrix=array_fill(0,$the_size_xy,array_fill(0,$the_size_xy,999999));
$total_steps=0;
//the risk of first element is 0 , we already there
$sum_matrix[0][0]=0;
$visited[0][0]=1;

$steps_to_go = [0=>[0=>[0,0]]];
while(!empty($steps_to_go)){
    //take the node(s)!!! from the query with smallest weight!!! - means we continue the cheapest way(s)
    ksort($steps_to_go);
    foreach($steps_to_go as $weight=>$steps_of_same_weight_to_do){
        break;
    }
    unset($steps_to_go[$weight]);

    $ret=array();
    foreach($steps_of_same_weight_to_do as $id=>$step_coords){
        unset($steps_of_same_weight_to_do[$id]);
        $ret = nextStep($step_coords[0],$step_coords[1]);
        foreach($ret as $weight=>$coords){
            foreach($coords as $coord){
                $steps_to_go[$weight][]=$coord;
            }
        }
    }
    if(isset($visited[$the_size_xy-1][$the_size_xy-1]))break;
}


function nextStep($i,$j){
    if(isset($visited[$i][$j]))return [];
    global $sum_matrix,$the_matrix,$total_steps;
    $total_steps++;
    $ret = array();
    
    //if can go right 
    if(isset($the_matrix[$i][$j+1]) ){
        if($sum_matrix[$i][$j+1] > $sum_matrix[$i][$j] + $the_matrix[$i][$j+1]){
            $sum_matrix[$i][$j+1] = $sum_matrix[$i][$j] + $the_matrix[$i][$j+1];
            $ret[$sum_matrix[$i][$j+1]][]=[$i,$j+1];
        }
    }
    //if can go left
    if(isset($the_matrix[$i][$j-1]) ){
        if($sum_matrix[$i][$j-1] > $sum_matrix[$i][$j] + $the_matrix[$i][$j-1]){
            $sum_matrix[$i][$j-1] = $sum_matrix[$i][$j] + $the_matrix[$i][$j-1];
            $ret[$sum_matrix[$i][$j-1]][]=[$i,$j-1];
        }
    }
    //if can go down
    if(isset($the_matrix[$i+1][$j]) ){
        if($sum_matrix[$i+1][$j] > $sum_matrix[$i][$j] + $the_matrix[$i+1][$j]){
            $sum_matrix[$i+1][$j] = $sum_matrix[$i][$j] + $the_matrix[$i+1][$j];
            $ret[$sum_matrix[$i+1][$j]][]=[$i+1,$j];
        }
    }
    //if can go up
    if(isset($the_matrix[$i-1][$j]) ){
        if($sum_matrix[$i-1][$j] > $sum_matrix[$i][$j] + $the_matrix[$i-1][$j]){
            $sum_matrix[$i-1][$j] = $sum_matrix[$i][$j] + $the_matrix[$i-1][$j];
            $ret[$sum_matrix[$i-1][$j]][]=[$i-1,$j];
        }
    }
    $visited[$i][$j]=1;
    return $ret;
}
echo '$total_steps: '.$total_steps.'<br>';
$end = microtime(true);
echo '<br>Time spent: '.($end-$start).'<br>';

echo '<br>!!!<b>';
echo intval($sum_matrix[count($sum_matrix)-1][count($sum_matrix[0])-1]) - intval($sum_matrix[0][0]) ;
echo '</b>';
echo '<hr>';
echo echo_matrix($sum_matrix,' ');
exit;




//part 1 was made in this way:

$sum_matrix=array();

for($i=0; $i<count($the_matrix); $i++){
    for($j=0; $j<count($the_matrix[$i]); $j++){
        if($i==0 || $j==0){
            /*
            if($i==0 && $j==0){
                $sum_matrix[$i][$j]=0;
            }else{
            */
                if($i==0){
                    $sum_matrix[$i][$j]=(isset($sum_matrix[$i][$j-1])?$sum_matrix[$i][$j-1]:0) + $the_matrix[$i][$j];
                }
                if($j==0){
                    $sum_matrix[$i][$j]=(isset($sum_matrix[$i-1][$j])?$sum_matrix[$i-1][$j]:0) + $the_matrix[$i][$j];
                }
            //}
        }else{
            
            $left_cell = isset($sum_matrix[$i][$j-1])?$sum_matrix[$i][$j-1]:0;
            $top_cell = isset($sum_matrix[$i-1][$j])?$sum_matrix[$i-1][$j]:0;

            $right_cell = isset($sum_matrix[$i][$j+1])?$sum_matrix[$i][$j+1]:0;
            $bottom_cell = isset($sum_matrix[$i+1][$j])?$sum_matrix[$i+1][$j]:0;

            if($left_cell<$top_cell)$the_min=$left_cell;
            else $the_min = $top_cell;
            
            $sum_matrix[$i][$j] = $the_min + $the_matrix[$i][$j];
        }

    }
}
echo '<hr>';
echo echo_matrix($sum_matrix,' ');

echo '<br>!!!<b>';
echo intval($sum_matrix[count($sum_matrix)-1][count($sum_matrix[0])-1]) - intval($sum_matrix[0][0]) ;
echo '</b>';

