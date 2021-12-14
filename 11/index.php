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

$flashes=0;

for($step=0; $step<1000;$step++){
    //echo_matrix($the_matrix);
    //echo '<hr>';
    //1, just increase
    for($i=0;$i<count($the_matrix);$i++){
        for($j=0; $j<count($the_matrix[$i]); $j++){
            $the_matrix[$i][$j]++;
            if($the_matrix[$i][$j]>9)$the_matrix[$i][$j]=10;
        }
    }
    


    //2
    while(check_if_tens_inside($the_matrix)){
        for($i=0;$i<count($the_matrix);$i++){
            for($j=0; $j<count($the_matrix[$i]); $j++){
                if($the_matrix[$i][$j]==10){
                    $flashes++;
                    increase_around($i,$j);
                    $the_matrix[$i][$j]=-1;
                }
            }
        }
    }

    //3, make 10th zeros
    for($i=0;$i<count($the_matrix);$i++){
        for($j=0; $j<count($the_matrix[$i]); $j++){
            if($the_matrix[$i][$j]==-1)$the_matrix[$i][$j]=0;
        }
    }

    if(check_all_flash($the_matrix)){
        echo_matrix($the_matrix);
        echo '<hr>';
        echo $step+1;
        exit;
    }
    
}

//echo $flashes;

function check_if_tens_inside($the_matrix){
    for($i=0;$i<count($the_matrix);$i++){
        for($j=0; $j<count($the_matrix[$i]); $j++){
            if($the_matrix[$i][$j]==10)return true;
        }
    }
    return false;
}



function check_all_flash($the_matrix){
    for($i=0;$i<count($the_matrix);$i++){
        for($j=0; $j<count($the_matrix[$i]); $j++){
            if($the_matrix[$i][$j]!=0)return false;
        }
    }
    return true;
}



function increase_around($i,$j){
    //echo 'around '.$i.' '.$j;;
    global $the_matrix;
    for($ii=$i-1;$ii<$i+2;$ii++){
        for($jj=$j-1;$jj<$j+2;$jj++){
            if($jj==$j && $ii==$i)continue;
            if(!isset($the_matrix[$ii][$jj]))continue;
            if($the_matrix[$ii][$jj]==-1)continue;
            $the_matrix[$ii][$jj]++;
            if($the_matrix[$ii][$jj]>9)$the_matrix[$ii][$jj]=10;
        }
    }
}