<?php
require_once("../dBug.php");
$rows = file('input.txt');

$the_numbers = explode(",",$rows[0]);
unset($rows[0]);
unset($rows[1]);

$matrs=array();
$matr_id=0;
$matr_row=0;
//new dBUg($rows);
foreach($rows as $row){
    if(trim($row)==''){
        $matr_id++;
        $matr_row=0;
        continue;
    }
    $numbers = preg_split("/\s+/",trim($row));
    $matrs[$matr_id][$matr_row]=$numbers;
    $matr_row++;
}

$tmp_matrs=$matrs;
foreach($the_numbers as $the_number){
    foreach($matrs as $the_matr_id=>$the_matr){
        foreach($the_matr as $the_row_id =>$the_row){
            foreach($the_row as $the_cold_id => $the_col){
                if($the_col == $the_number){
                    $filled_matrs[$the_matr_id][$the_row_id][$the_cold_id]=$the_number;
                    //?
                    $matrs[$the_matr_id][$the_row_id][$the_cold_id]=-1;
                }   
            }
        }
    }


    foreach($matrs as $the_matr_id=>$matr){
        $res = check_filled_matr($matr);
        if(!empty($res)){
            echo $the_matr_id.' won <br>';
            $the_last_matr = $matrs[$the_matr_id];
            unset($matrs[$the_matr_id]);
            if(count($matrs)==1){
                echo 'the number when 1 left'.$the_number;
                new dBUg($matrs);
                $the_last_matr = $matrs[$the_matr_id];
            }
            if(count($matrs)==0){
                echo 'the number when 0 left'.$the_number;
                new dBUg($matrs);
                break(2);
            }
        }
    }

    

}


foreach($the_last_matrs as $the_matr_id=>$the_last_matr){

}

$the_found_matr = $tmp_matrs[$the_matr_id];
new dBUg($the_last_matr);
$not_selected_sum = 0;
new dBUg($the_found_matr);
foreach($the_found_matr  as $row_id => $row){
    foreach($row as $col_id => $col){
        if($the_last_matr[$row_id][$col_id]!=-1){
            echo $col.' ';
            $not_selected_sum+=$col;

        }
    }
}


echo '!!!'.$the_number;
echo '<hr>';
echo $not_selected_sum* $the_number;


function check_filled_matr($matr=array()){
    $in_row=[];
    $in_col=[];
    for($i=0; $i<count($matr); $i++){
        for($j=0; $j<count($matr[$j]); $j++){
            if($matr[$i][$j]==-1){
                $in_col[$j]++;
                $in_row[$i]++;
            }
        }
    }
    $ret = array();
    foreach($in_col as $col_num => $col_filled){
        if($col_filled==5)$ret['filled_col']=$col_num;
    }

    foreach($in_row as $row_num => $row_filled){
        if($row_filled==5)$ret['filled_row']=$row_num;
    }

    return $ret;
}