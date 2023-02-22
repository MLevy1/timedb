<?php

$arrMinDev = array();

$sumMins = array_sum($data[1]);

$avgMins = $sumMins/$cnt;

for($x = 0; $x < $cnt; $x++) {
	$arrMinDev[] = pow(($data[1][$x]-$avgMins), 2);
}

$varMin = array_sum($arrMinDev) / ($cnt-1);

$stdev = sqrt($varMin);

echo "n = ".$cnt."<br>";

echo "sum = ".$sumMins."<br>";

echo "mean = ".round($avgMins, 1)."<br>";

echo "st dev = ".round($stdev, 1)."<br>";

?>