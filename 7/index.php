<?php
require_once("../dBug.php");
$rows = file_get_contents('input.txt');


$xs = explode(',',trim($rows));

$weights = array();
foreach($xs as $x){
    $amounts[$x]++;
}

$min = min($xs);
$max = max($xs);

$steps_fuel = array();

for($i=$min;$i<=$max; $i++){
    $steps_fuel[$i] = $steps_fuel[$i-1]+$i;
}
//new dBUg($steps_fuel);

//new dBUg($amounts);


for($i=$min; $i<=$max; $i++){
    $weights[$i]=0;
    foreach($amounts as $number=>$amount_of_numbers){
        //сколько шагов в $i от числа
       // echo 'steps from $number '.$number.' to $i '.$i.': '.abs($number-$i).' and fuel needed: '.$steps_fuel[abs($number-$i)].' with total of $number '.$number.': '.$amount_of_numbers.' <br>';

        $weight[$i]+=$steps_fuel[abs($number-$i)]*$amount_of_numbers;
    }
}

echo min($weight);
new dBUg($weight);
exit;



$count = count($xs);
$sum = array_sum($xs);

$weights = array();

foreach($xs as $x){
    $weights[$x]++;
}

new dBUg($weights);
$the_w = 0;
foreach($weights as $w=>$w_a){
    $the_w += $w*$w_a;
}

echo $the_w/$count;

$total = $max-$min;
echo '<br>total: '.$total;
echo '<br>count: '.$count;
echo '<br>sum: '.$sum;
echo '<br>with sum '.($sum/$count);