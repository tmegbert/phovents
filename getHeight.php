<?php
$height = 200;
$w1 =  300;
$w2 = 133;
$w3 = 133;
$w4 = 300;
$total = $w1 +$w2 + $w3 + $w4;

while($total < 1200){
    $height++;
    $w1 = round($height * 1.5);
    $w2 = round($height * 0.665);
    $w3 = round($height * 0.665);
    $w4 = round($height * 1.5);
    $total = $w1 +$w2 + $w3 + $w4;
}

echo "Width 1 is " . $w1 . "\n";
echo "Width 2 is " . $w2 . "\n";
echo "Height is " . $height . "\n";

