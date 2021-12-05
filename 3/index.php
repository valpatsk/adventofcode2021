<?php
require_once("../dBug.php");
$rows = file('input.txt');

$first = array();

foreach($rows as $row){
    $row=trim($row);
    for($i=0;$i<strlen($row);$i++){
        $first[$i]+=$row[$i];
    }
}

new dBUg($first);
$first_num='';
$second_num='';
foreach($first as $key=>$value){
    if($value/count($rows)<0.5) {$first_num.='1';$second_num.='0';}
    elseif($value/count($rows)>0.5) {$first_num.='0';$second_num.='1';}
    else echo 'EQUAL<br>';
}

echo $first_num;
echo '<br>';
echo $second_num;
echo '<br>';
$first_num = base_convert($first_num,2,10);
$second_num = base_convert($second_num,2,10);

echo $first_num * $second_num;


echo '<hr>';
$ox_str='';
$co_str='';
$oxs=$rows;
$cos=$rows;
for($j=0; $j<strlen($rows[0]); $j++){
    
    if(count($oxs)>1){
        $the_ox=0;
        foreach($oxs as $row){
            $row=trim($row);
            $the_ox+=$row[$j];
        }
        echo "OX: ".$the_ox.' '.count($oxs).'<br>';
        if($the_ox/count($oxs)>=0.5) {
            $ox_str.='1';
            foreach($oxs as $key=>$row){
                if($row[$j]=='0')unset($oxs[$key]);
            }
        }else {
            $ox_str.='0';
            foreach($oxs as $key=>$row){
                if($row[$j]=='1')unset($oxs[$key]);
            }
        }
        //new dBUg($oxs);
    }else{
        foreach($oxs as $val){
            $ox_str=$val;
        }
    }


    if(count($cos)>1){
        $the_co=0;
        foreach($cos as $row){
            $row=trim($row);
            $the_co+=$row[$j];
        }
        echo 'CO: '.$the_co.' '.count($cos).'<br>';
        if($the_co/count($cos)<0.5) {
            foreach($cos as $key=>$row){
                if($row[$j]=='0')unset($cos[$key]);
            }
        }else {
            foreach($cos as $key=>$row){
                if($row[$j]=='1')unset($cos[$key]);
            }
        }
        //new dBUg($cos);
    }else{
        
        foreach($cos as $val){
            $co_str=$val;
        }
    }

}

echo $ox_str;
echo '<br>';
echo $co_str;
echo '<br>';
$first_num = base_convert($ox_str,2,10);
$second_num = base_convert($co_str,2,10);

echo $first_num * $second_num;