<?php
require_once("../dBug.php");
$rows = file_get_contents('input.txt');


ini_set('memory_limit', '4092M');

set_time_limit(1200);


$tmp = explode(',',trim($rows));

$fishs=[];
$live_initial_end=6;
$live_end=8;
//$live_extension=2;




$state=array(0,0,0,0,0,0,0,0,0);

foreach($tmp as $fish_num){
    $state[$fish_num]++;
}
new dBUg($state);


for($i=0; $i<256; $i++){

    $newState=array(0,0,0,0,0,0,0,0,0);

    foreach($state as $state_id => $state_val){
        $newState[$state_id]=$state[$state_id+1];
    }
    $newState[8]=$state[0];
    $newState[6]+=$state[0];

    $state=$newState;

    new dBUg($state);

}


echo array_sum($state);

exit;

echo $result.' ';
echo $count.'<br>';
exit;

echo '!!!';
new dBUg($state);


//echo $count;
exit;


function iWillCreate($live,$days){
    //echo 'DAYS: '.$days.'<br>';
    
    $days_to_create = $days - $live;
    if($days_to_create<0)return 0;
    //echo 'DAYS TO CREATE: '.$days_to_create.' <br>';
    //if($initial==0)$days_to_create-=2;
    $creations = intval($days_to_create/7)+1;
    //echo 'CREATIONS '.$creations.' <br>';;

    $ret=0;

    for($i=0; $i<$creations;$i++){
        $ret += iWillCreate(7,$days-($live+(7*$i))-2);
    }

    return $creations+$ret;
}