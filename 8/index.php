<?php
require_once("../dBug.php");
$rows = file('input.txt');

$clear =array();
$clear[7]=3;
$clear[1]=2;
$clear[4]=4;
$clear[8]=7;




$summ = 0;

foreach($rows as $row_id => $row){
    $twos = explode('|',trim($row));
    $nums_str = array();
    

    $seconds = explode(" ",trim($twos[1]));
    $firsts = explode(" ",trim($twos[0]));

    $firsts = sort_by_digit_amount($firsts);
    new dBUg($firsts);

    $numbers=array();
    $numbers[1]=$firsts[2][0];
    $numbers[4]=$firsts[4][0];
    $numbers[7]=$firsts[3][0];
    $numbers[8]=$firsts[7][0];

    foreach($firsts[6] as $id=>$the_six){
        if(!check_symbols_exist_in_array($numbers[1],$the_six)){
            $numbers[6]=$the_six;
            unset($firsts[6][$id]);
        }
    }

    $one_four_diff=mkstr(array_diff(mkarr($numbers[4]),mkarr($numbers[1])));
    foreach($firsts[6] as $id=>$the_six){
        if(!check_symbols_exist_in_array($one_four_diff,$the_six)){
            $numbers[0]=$the_six;
        }else{
            $numbers[9]=$the_six;
        }
    }

    foreach($firsts[5] as $id=>$the_five){
        if(check_symbols_exist_in_array($numbers[1],$the_five)){
            $numbers[3]=$the_five;
            unset($firsts[5][$id]);
        }
    }
    foreach($firsts[5] as $id=>$the_five){
        if(!check_symbols_exist_in_array($one_four_diff,$the_five)){
            $numbers[2]=$the_five;
        }else{
            $numbers[5]=$the_five;
        }
    }


    $the_numbers = array_flip($numbers);
    $str='';
    foreach($seconds as $the_second){
        $the_second = sort_alphabet($the_second);
        $str.=$the_numbers[$the_second];
    }
    $summ += intval($str);
}

echo $summ;

function sort_alphabet($str) {
    $array = array();
    for($i = 0; $i < strlen($str); $i++) {
        $array[] = $str{$i};
    }
    sort($array);
    return implode($array);
}

function sort_by_digit_amount($tmp){
    new dBUg($tmp);
    $res=array();
    foreach($tmp as $tp){
        $tp=sort_alphabet($tp);
        if(strlen($tp)==2){
            $res[2][]=$tp;
        }
        if(strlen($tp)==3){
            $res[3][]=$tp;
        }
        if(strlen($tp)==4){
            $res[4][]=$tp;
        }
        if(strlen($tp)==5){
            $res[5][]=$tp;
        }
        if(strlen($tp)==6){
            $res[6][]=$tp;
        }
        if(strlen($tp)==7){
            $res[7][]=$tp;
        }
    }
    return $res;
}

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
    return sort_alphabet($ret);
}