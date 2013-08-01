<?php 
/**
 * Calculates the average of the given values
 */
function average($values) {
	$total = 0;
	$count = 0;
	foreach ($values as $temperature) {
		$total += $temperature;
		$count++;
	}
	
	return number_format(round($total / $count, 1), 1);
}

/**
 * @return the minimum value in an array of integers.
 */
function getMin($values) {
	$lowest = NULL;
	foreach ($values as $temperature) {
		$value = $temperature;
		if ($lowest === NULL || $value < $lowest) {
			$lowest = $value;
		}
	}
	return number_format($lowest, 1);
}

/**
 * @return the maximum value in an array of integers
 */
function getMax($values) {
	$highest = NULL;
	foreach ($values as $temperature) {
		$value = $temperature;
		if ($highest === NULL || $value > $highest) {
			$highest = $value;
		}
	}
	return number_format($highest, 1);
}
