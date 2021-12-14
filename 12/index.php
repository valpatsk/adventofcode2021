<?php
require_once("../dBug.php");
require_once("../functions.php");
$rows = file('input.txt');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('memory_limit', '1024M');

$from = [];
foreach($rows as $row  ){
    $row = trim($row);
    $tmp = explode('-',$row);

    if($tmp[1]=='start'){

    }elseif($tmp[0]=='start'){
       $from['start'][]=$tmp[1];
    }elseif($tmp[0]=='end'){
        //$from_s[$tmp[1]][]='end';
    }else{
        $from[$tmp[0]][]=$tmp[1];
    }

    //reverse
    if($tmp[0]=='start'){

    }elseif($tmp[1]=='start'){
        $from['start'][]=$tmp[0];
     }elseif($tmp[1]=='end'){
        //$from_s[$tmp[0]][]='end';
     }else{
        $from[$tmp[1]][]=$tmp[0];
     }
}


//new dBUg($from);
$tmp_from = $from;
$tmp=[];
$tmp['start'] = [];

$possible_visit_twice = array();
foreach(array_keys($from) as $the_key){
    if($the_key=='end' || $the_key=='start' || checkUppercase($the_key))continue;
    $possible_visit_twice[]=$the_key;
}

new dBug($possible_visit_twice);

new dBUg($from);

$strings=array();

foreach($possible_visit_twice as $skip_delete){
    $tmp[$skip_delete] = array();
    foreach($from['start'] as $go_to){
        $i=0;
        $from= $tmp_from;
        
        $tmp[$skip_delete]['start'][$go_to] = goToCave($go_to,$from,'start',$skip_delete);
        
        //new dBUg($tmp[$skip_delete]['start'][$go_to]);

        $strings = array_merge($strings,returnStrings($tmp[$skip_delete]));
        
    }
}

//new dBug($strings);
//new dBug(array_values(array_unique($strings)));
echo count(array_values(array_unique($strings)));
//new dbug($tmp);

//new dBug(returnStrings($tmp));



function goToCave($cave_id,$from,$delete_backpath='',$skip_delete=''){
    //echo 'start '.$cave_id.'<br>';
    $the_skip_delete = $skip_delete;
    //echo 'Skip: '.$skip_delete.'!<br>';
    if($delete_backpath!='' && isset($from[$delete_backpath])){
        
        if( $skip_delete == $delete_backpath){
            //echo 'skip delete '.$delete_backpath.'<br>';
            $the_skip_delete='';
        }else{
            //echo 'delete '.$delete_backpath.'<br>';
            unset($from[$delete_backpath]);
        }
        
    }
    //new dBUg($from);


    $ret = [];
    foreach($from[$cave_id] as $the_go_to_id=>$the_go_to){
        if(!isset($from[$the_go_to])){
            if($the_go_to=='end')$ret[$the_go_to]='end';
        }else{
            if(checkUppercase($cave_id)){
                //multi
                $tmp = goToCave($the_go_to,$from,'',$the_skip_delete);
                $ret[$the_go_to]=$tmp;
            }else{
                $tmp = goToCave($the_go_to,$from,$cave_id,$the_skip_delete);
                $ret[$the_go_to]=$tmp;
            }
        }
    }
    //echo 'end '.$cave_id.'<br>';
    return $ret;

}

function returnStrings($arr){
    $ret=[];
    foreach($arr as $the_key=>$the_arr){
        if($the_key=='end'){
            $ret[]=',end<br>';
        }else{
            $tmp = returnStrings($the_arr);
            foreach($tmp as $tmp_str){
                $ret[]=','.$the_key.$tmp_str;
            }
        }
    }
    return $ret;
}


exit;

/*
$from_s=array();
$from_m=array();
$start=[];
$end=[];

foreach($rows as $row  ){
    $row = trim($row);
    $tmp = explode('-',$row);

    if($tmp[1]=='start'){

    }elseif($tmp[0]=='start'){
       $start[]=$tmp[1];
       $from_s['start'][]=$tmp[1];
    }elseif($tmp[0]=='end'){
        //$from_s[$tmp[1]][]='end';
    }else{
        if(checkUppercase($tmp[0])){
            $from_m[$tmp[0]][]=$tmp[1];
        }else{
            $from_s[$tmp[0]][]=$tmp[1];
        }
    }

    //reverse
    if($tmp[0]=='start'){

    }elseif($tmp[1]=='start'){
        $start[]=$tmp[0];
        $from_s['start'][]=$tmp[0];
     }elseif($tmp[1]=='end'){
        //$from_s[$tmp[0]][]='end';
     }else{
         if(checkUppercase($tmp[1])){
             $from_m[$tmp[1]][]=$tmp[0];
         }else{
             $from_s[$tmp[1]][]=$tmp[0];
         }
     }
}

new dBUg($from_s);
new dBUg($from_m);
*/






$tmp_from_s = $from_s;
$steps=[];


foreach($from_s['start'] as $go_to){
    $i=0;
    $from_s = $tmp_from_s;
    while($i<1000){

        $ret = $i.':start-';
        $tmp = visitCave($go_to,$from_s,'start');
        new dbug($tmp);
        if($tmp!==false){
            new dbug($ret);
        }else{
            break;
        }
        new dbug($ret);
        $i++;
    }
}

function visitCave($cave_id,$from_s=array(),$go_back=''){
    echo 'start '.$cave_id.'<br>';
    if($go_back!='' && isset($from_s[$go_back])){
        echo 'delete '.$go_back.'<br>';
        unset($from_s[$go_back]);
        new dBUg($from_s);
    }
    global $from_m;
    $ret=[];
    
    if(isset($from_s[$cave_id])){
        foreach($from_s[$cave_id] as $the_s_id=>$go_to){
            if(!isset($from_s[$go_to]))continue;
            $tmp = visitCave($go_to,$from_s,$cave_id);
            echo '$tmp:';
            new dBUg($tmp);
            if($tmp === false){ 
                //next cave is finish
                $ret[$cave_id][]=$go_to;
                echo '1';
                new dBUg($ret);
                //return false;
            }else{
                $ret[$cave_id][]=$tmp;
            }
        }
        new dBUg($ret);
        echo 'finish '.$cave_id;
        return $ret;
    }

    /*
    if(isset($from_m[$cave_id])){
        foreach($from_m[$cave_id] as $go_to){
            $tmp = visitCave($go_to);
            if($tmp === false){ 
                //next cave is finish
                $ret[$cave_id][]=$goto;
            }else{
                $ret[$cave_id][]=$tmp;
            }
        }
        return $ret;
    }
    */

    return false;
}

new dBUg($from_s);
new dBUg($from_m);

