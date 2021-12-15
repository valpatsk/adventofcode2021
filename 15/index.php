<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

ini_set('memory_limit', '9000M');
set_time_limit(18000);

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
//echo '<hr>';
//echo echo_matrix($the_matrix);
//echo echo_matrix($big_matrix);
//echo '<hr>';
//exit;

$the_matrix = $big_matrix;
echo echo_matrix($the_matrix);



//part 2 :


$the_size_xy = count($the_matrix);
$sum_matrix=array_fill(0,$the_size_xy,array_fill(0,$the_size_xy,999999));

//the risk of first element is 0 , we already there
$sum_matrix[0][0]=0;

//echo '<hr>';
//echo echo_matrix($sum_matrix,' ');

//next_step([0=>[0,0]]);
nextStep(0,0);

echo '<hr>';
echo echo_matrix($sum_matrix,' ');




function nextStep($i,$j){
    global $sum_matrix,$the_matrix;
    //$steps_to_check=array();
    //echo '<br>';
    //echo echo_matrix($the_matrix);
    
    //if can go right
    if(isset($the_matrix[$i][$j+1])){
        //echo 'right<br>';
        //if sum of going to right cell will be less then it was before
        if($sum_matrix[$i][$j+1] > $sum_matrix[$i][$j] + $the_matrix[$i][$j+1]){
            //echo 'inRight<br>';
            //change the summ in down cell
            $sum_matrix[$i][$j+1] = $sum_matrix[$i][$j] + $the_matrix[$i][$j+1];
            //the sum in this way has been changed, need to recalculate next possible ways to go
            nextStep($i,$j+1);
        }
    }

    //if can go left
    if(isset($the_matrix[$i][$j-1])){
        //echo 'left<br>';
        //if sum of going left will be less then it was before
        if($sum_matrix[$i][$j-1] > $sum_matrix[$i][$j] + $the_matrix[$i][$j-1]){
            //echo 'inLeft<br>';
            //change the summ in left cell
            $sum_matrix[$i][$j-1] = $sum_matrix[$i][$j] + $the_matrix[$i][$j-1];
            //the sum in this way has been changed, need to recalculate next possible ways to go
            nextStep($i,$j-1);
        }
    }

    //if can go down
    if(isset($the_matrix[$i+1][$j])){
        //echo 'down<br>';
        if($sum_matrix[$i+1][$j] > $sum_matrix[$i][$j] + $the_matrix[$i+1][$j]){
            //echo 'inDown<br>';
            //change the summ in down cell
            $sum_matrix[$i+1][$j] = $sum_matrix[$i][$j] + $the_matrix[$i+1][$j];
            //the sum in this way has been changed, need to recalculate next possible ways to go
            nextStep($i+1,$j);
        }
    }

    //if can go up
    if(isset($the_matrix[$i-1][$j])){
        //if sum of going down will be less then it was before
        if($sum_matrix[$i-1][$j] > $sum_matrix[$i][$j] + $the_matrix[$i-1][$j]){
            //change the summ in up cell
            $sum_matrix[$i-1][$j] = $sum_matrix[$i][$j] + $the_matrix[$i-1][$j];
            //the sum in this way has been changed, need to recalculate next possible ways to go
            nextStep($i-1,$j);
        }
    }
}

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

function reverse_matrix($arr){
    $new_arr=[];
    $size = count($arr);
    for($i=0; $i<$size; $i++){
        for($j=0;$j<$size;$j++){
            $new_arr[$i][$j]=$arr[$size-$i-1][$size-$j-1];
        }
    }
    return $new_arr;
}



/*
$step=0;
$i=0;
$j=0;
while($step<20){
    
    echo 'STEP '.$step;
    $direction = getDirrection($the_matrix,$i,$j);
    echo ' DIRECTION FOUND: '.$direction;
    if($direction=='right')$j++;
    else $i++;

    echo ' NEXT $i:'.$i.', $j:'.$j;

    echo ' NEXT STEP to <b>'.$the_matrix[$i][$j].'</b>';

    $step++;
    echo '<br>';
    if($i==$j && $i==count($the_matrix))break;
}


function getDirrection($the_matrix,$start_i,$start_j){
    $right=0;
    $down=0;
    $i_left=count($the_matrix)-$start_i;
    $j_left=count($the_matrix)-$start_j;
    $square_size = ($i_left<$j_left)?$i_left:$j_left;

    echo ' start: '.$start_i.' '.$start_j.'!'.$square_size.'! ';
    $jj=$ii=-1;
    for($i=$start_i;$i<($start_i+$square_size);$i++){
        $jj=-1;
        $ii++;
        for($j=$start_j;$j<($start_j+$square_size);$j++){
            $jj++;
            if($ii==$jj)continue;
            if($ii>$jj)$down+=$the_matrix[$i][$j];
            else $right+=$the_matrix[$i][$j];
        }
    }
    echo ' FOUND right: '.$right.' , FOUND down: '.$down;
    if($right>$down)return 'down';
    else return 'right';
}
*/