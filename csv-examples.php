<?php

$filename = 'address_book.csv';

$handle = fopen($filename, 'r');

$address_book = [];

while(!feof($handle)) {
  $address_book[] = fgetcsv($handle);
}

fclose($handle);

print_r($address_book);