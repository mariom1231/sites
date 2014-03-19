<!-- 99 Bottles of Beer (1 Point)
The Challenge:

Write a program that prints the lyrics to of the song "99 Bottles of Beer"

Input:

No input given for this problem.

Output:

The lyrics of the entire "99 Bottle of Beer" song | Click here for reference

"99 bottles of beer on the wall, 99 bottles of beer. Take one down and pass it around, 98 bottles of beer on the wall."

"98 bottles of beer on the wall, 98 bottles of beer. Take one down and pass it around, 97 bottles of beer on the wall."

...

"2 bottles of beer on the wall, 2 bottles of beer. Take one down and pass it around, 1 bottle of beer on the wall."

"1 bottle of beer on the wall, 1 bottle of beer. Take one down and pass it around, no more bottles of beer on the wall."

"No more bottles of beer on the wall, no more bottles of beer. Go to the store and buy some more, 99 bottles of beer on the wall." -->


<?php

$a = 100;

do {
	echo "$a\n";
	$a = $a - 5;

} while ($a >= -10);
// $a = 99;
// // $b = $a - 1;

// do {

// echo "$a bottles of beer on the wall, $a bottles of beer. Take one down and pass it around, $a bottles of beer on the wall.";

// } while ($a > 0);

?>