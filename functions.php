<?php
function check_symbols_exist_in_array($symbols,$arr){
    //вернет что есть в первом и втором
    if(count(mkarr($symbols)) == count(array_intersect(mkarr($symbols),mkarr($arr))))return true;
    //вернет то что расходится (нету в каждом)
    //array_diff();
    return false;
}

function mkarr($str){
    $ret=array();
    for($i=0; $i<strlen($str);$i++){
        $ret[]=$str[$i];
    }
    return $ret;
}

function mkstr($str){
    $ret='';
    foreach($str as $st){
        $ret.=$st;
    }
    return $ret;
}

function sort_alphabet($str) {
    $array = array();
    for($i = 0; $i < strlen($str); $i++) {
        $array[] = $str{$i};
    }
    sort($array);
    return implode($array);
}

function echo_matrix($arr){
    foreach($arr as $row){
        echo mkstr($row);
        echo '<br>';
    }
}

function echo_matrix_nice($arr){
    foreach($arr as $row){
        //echo mkstr($row);
        foreach($row as $col){
            if($col!=0) echo "<b>" ;

            if($col==0)echo ' _ ';
            else echo ' # ' ;
            
            if($col!=0) echo "</b>" ;
        }
        echo '<br>';
    }
}

function checkUppercase($str){
    if($str==strtoupper($str)){
        return true;
    }else{
        return false;
    }
}