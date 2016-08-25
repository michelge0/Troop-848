<?php

	// function flip($n) {
	// 	$arr = [];
	// 	$i = 0;
	// 	while($n>0) {
	// 		$arr[] = $n%10;
	// 	    $n=floor($n/10);
	// 	    $i++;
	// 	}
	// 	$result = 0;
	// 	for ($i = 0; $i < count($arr); $i++) {
	// 		$to_add = $arr[$i] * (10 ** (count($arr) - 1 - $i));
	// 		$result += $to_add;
	// 	}
	// 	return $result;
	// }

	$fib = [ 1, 1 ];
	for ($i = 0; $i < 10000; $i++) {
		$prev = $fib[count($fib) - 1];
		$prevprev = $fib[count($fib) - 2];
		$next = bcadd($prev, $prevprev);
		$fib[] = $next;
	}	

	$icc = [ 1, 1 ];

	for ($i = 0; $i < 10000; $i++) {
		$prev = $icc[count($icc) - 1];
		$prevprev = $icc[count($icc) - 2];
		$next = bcadd($prev, $prevprev);
		$icc[] = $next;
	}	

	for ($i = 0; $i < 1000; $i++) {
		echo bcdiv($fib[$i], $icc[$i]);
		echo "<br>";
	}


	// echo $fib[1000] . "\r\n";
	// echo $icc[1000] . "\r\n";
	// echo ($fib[1000] / $icc[1000]);
?>