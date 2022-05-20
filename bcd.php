<?php

function full_adder($a, $b, $ci){
	$s = (!$a && !$b && $ci) || (!$a && $b && !$ci) || ($a && !$b && !$ci) || ($a && $b && $ci);
	$co = ($a && $b) || ($a && $ci) || ($b && $ci);
	
	return [(int)$co, (int)$s];
}

function four_bit_adder($a3, $a2, $a1, $a0, $b3, $b2, $b1, $b0, $ci){
	$f0 = full_adder($a0, $b0, $ci);
	$f1 = full_adder($a1, $b1, $f0[0]);
	$f2 = full_adder($a2, $b2, $f1[0]);
	$f3 = full_adder($a3, $b3, $f2[0]);
	
	return [(int)$f3[0], (int)$f3[1], (int)$f2[1], (int)$f1[1], (int)$f0[1]];
}

function bcd_adder($a3, $a2, $a1, $a0, $b3, $b2, $b1, $b0, $ci){
	$f0 = four_bit_adder($a3, $a2, $a1, $a0, $b3, $b2, $b1, $b0, $ci);
	$t = ($f0[1] && $f0[2]) || ($f0[1] && $f0[3]) || ($f0[0]);
	$f1 = four_bit_adder($f0[1], $f0[2], $f0[3], $f0[4], 0, $t, $t, 0, 0);
	
	return [(int)$t, (int)$f1[1], (int)$f1[2], (int)$f1[3], (int)$f1[4]];
}

echo implode(bcd_adder(1, 0, 0, 1, 1, 0, 0, 1, 0));
