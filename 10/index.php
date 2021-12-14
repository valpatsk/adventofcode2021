<?php
require_once("../dBug.php");
require_once("../functions.php");
$rows = file('input.txt');

$open=['(','{','[','<'];
$close=[')','}',']','>'];
$same = array("{"=>"}","("=>")","<"=>">","["=>"]");
$scores=array(')'=>3,']'=>57,'}'=>1197,'>'=>25137);

$scores2=array(')'=>1,']'=>2,'}'=>3,'>'=>4);

$errors=array();

$score2=[];

foreach($rows as $the_id=> $row){
    $stek=[];
    $chunks_arr=mkarr($row);
    foreach($chunks_arr as $pos => $chunk){
        if(in_array($chunk,$open)){
            array_push($stek,$chunk);
        }
        if(in_array($chunk,$close)){
            $test = array_pop($stek);
            if($same[$test]!=$chunk){
                $errors[]=$chunk;
                continue(2);
            }
        }
    }


//echo '<hr>'.$the_id;
    //if we are here - the string is not finished
    //new dBUg($stek);
    $finish = array();
    for($i=count($stek)-1;$i>=0;$i--){
        $finish[]=$same[$stek[$i]];
    }
    //new dBUg($finish);
    $local_score2=0;
    foreach($finish as $id=>$fin){
        $local_score2*=5;
        $local_score2+=$scores2[$fin];
    }
    $score2[]=$local_score2;

}
//new dBUg($errors);

sort($score2);
new dBUg($score2);
//echo intval(count($score2)/2);

echo $score2[intval(count($score2)/2)];

//array_pop - извлекает последний
//array_push - пушает в конец

//array_shift - берет первый
//array_shift - добавляет в начало