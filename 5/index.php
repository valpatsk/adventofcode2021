<?php
require_once("../dBug.php");
$rows = file('input.txt');

$the_lines = [];
$the_dots = [];

for($i=0;$i<=999;$i++){
    for($j=0;$j<=999;$j++){
        $the_dots[$i][$j]=0;
    }
}


foreach($rows as $row_id=>$row){
    $tmp = explode(" -> ",$row);

    $dot1= explode(",",trim($tmp[0]));
    $dot2= explode(",",trim($tmp[1]));

    //new dBUg($dot1);
        //new dBUg($dot2);

    if(intval($dot1[0])==intval($dot2[0])){
        //new dBUg($dot1);
        //new dBUg($dot2);
        echo '111<br>';
        if($dot1[1]<$dot2[1]){$start=$dot1[1];$finish=$dot2[1];}
        else {$start = $dot2[1];$finish=$dot1[1];}
        for($i=$start;$i<=$finish;$i++){
            $the_dots[intval($dot1[0])][$i]++;
        }
    }elseif($dot1[1]==$dot2[1]){
        //new dBUg($dot1);
        //new dBUg($dot2);
        echo '222<br>';
        if($dot1[0]<$dot2[0]){$start=$dot1[0];$finish=$dot2[0];}
        else {$start = $dot2[0];$finish=$dot1[0];}
        for($i=$start;$i<=$finish;$i++){
            $the_dots[$i][$dot1[1]]++;
        }
    }else{
        new dBUg($dot1);
        new dBUg($dot2);
        if(abs($dot1[0]-$dot2[0]) !=abs($dot1[1]-$dot2[1]))continue;
        echo '333<br>';

        if($dot1[0]<$dot2[0]){$starti=$dot1[0];$finishi=$dot2[0];}
        else {$starti = $dot2[0];$finishi=$dot1[0];}

        if($dot1[1]<$dot2[1]){$startj=$dot1[1];$finishj=$dot2[1];}
        else {$startj = $dot2[1];$finishj=$dot1[1];}

        echo $starti.' '.$finishi.' - '.$startj.' '.$finishj.' :'.abs($dot1[0]-$dot2[0]).'<br>';

        for($i=$dot1[0],$j=$dot1[1],$count=0;
            $count<=abs($dot1[0]-$dot2[0]);
            ($dot1[0]<$dot2[0])?$i++:$i--,($dot1[1]<$dot2[1])?$j++:$j--){


                echo 'Add:'.$i.'-'.$j.', ';
                $the_dots[$i][$j]++;
                $count++;
        }
    }
}

$twos=0;
//new dBUg($the_dots[28]);
for($i=0;$i<=999;$i++){
    echo "Line!".$i.'!: ';
    for($j=0;$j<=999;$j++){
        //echo $the_dots[$i][$j].' ';
        if($the_dots[$i][$j]>=2){
            //new dBUg($the_dots[$i]);exit;
            $twos++;
            
        }
    }
    echo '<br>';
}


echo $twos;