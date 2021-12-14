<?php
require_once("../dBug.php");
require_once("../functions.php");
$rows = file('input.txt');


ini_set('memory_limit', '1024M');

$dots = [];
$commands=array();
$do_dots=1;

foreach($rows as $row){
    $row=trim($row);
    if($row==''){
        $do_dots=false;
        continue;
    }
    if($do_dots){
        $tmp=explode(',',$row);
        $dots[$tmp[0]][$tmp[1]]=1;
    }else{
        $tmp = explode(' ',$row);
        $tmp2=explode('=',$tmp[2]);

        $commands[]=$tmp2;
    }
}

$max_j = max(array_keys($dots));
$max_i=0;
foreach($dots as $row_id=>$row){
    if(max(array_keys($row)) > $max_i){
        $max_i = max(array_keys($row));
    }
}
ksort($dots);
echo $max_i .' '.$max_j; 
echo '<hr>';
$matrix=[];

for($i=0; $i<=$max_i;$i++){
    for($j=0;$j<=$max_j; $j++){
        $matrix[$i][$j]=0;
    }
}

foreach($dots as $col_id=>$col){
    foreach($col as $row_id=>$row){
        $matrix[$row_id][$col_id]=1;
    }
}



$tmp_matrix = $matrix;
foreach($commands as $command){
    new dBUg($command);
    $new_matrix = [];
    if($command[0]=='y'){
        $maxes = get_max_sizes($matrix);

        for($i=0; $i<intval($command[1]);$i++){
            for($j=0;$j<$maxes['max_j'];$j++){
                $new_matrix[$i][$j]=$matrix[$i][$j];
            }
        }
        $back=1;
        for($i=$command[1]+1; $i<$maxes['max_i'];$i++){
            for($j=0;$j<$maxes['max_j'];$j++){
                $new_matrix[$command[1]-$back][$j]+=$matrix[$i][$j];
                if($new_matrix[$command[1]-$back][$j]>0)$new_matrix[$command[1]-$back][$j]=1;
            }
            $back++;
        }
        
    }


    if($command[0]=='x'){
        $maxes = get_max_sizes($matrix);

        for($i=0; $i<$maxes['max_i'];$i++){
            for($j=0;$j<$command[1];$j++){
                $new_matrix[$i][$j]=$matrix[$i][$j];
            }
        }

        
        for($i=0; $i<$maxes['max_i'];$i++){
            $back=1;
            for($j=$command[1]+1;$j<$maxes['max_j'];$j++){
                //echo $i.'-'.$j.' = '.$i.'-'.($command[1]-$back).'<br>';
                $new_matrix[$i][$command[1]-$back]+=$matrix[$i][$j];
                if($new_matrix[$i][$command[1]-$back] > 0 )$new_matrix[$i][$command[1]-$back]=1;
                $back++;
            }
        }
        
    }
    
    //echo_matrix($new_matrix);
    echo '<hr>';
    echo 'Dots: '.count_dots($new_matrix);

    $matrix=$new_matrix;
}
echo '<hr>';
echo_matrix($new_matrix);
echo '<hr>';
echo_matrix_nice($new_matrix);


function get_max_sizes($matrix){
    $max_i = count($matrix);
    $max_j=0;
    foreach($matrix as $row_id=>$row){
        if(count($row) > $max_j){
            $max_j = count($row);
        }
    }
    return array('max_i'=>$max_i, 'max_j'=>$max_j);
}

function count_dots($matrix){
    $dots=0;
    foreach($matrix as $row){
        foreach($row as $col){
            if($col>0)$dots++;
        }
    }
    return $dots;
}




