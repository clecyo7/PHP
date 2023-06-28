<?php

$asciiArray = range(',', '|');

$removedElement = array_splice($asciiArray, array_rand($asciiArray), 1);

$missingChar = chr(array_sum(array_map('ord', $asciiArray)) - array_sum(array_map('ord', $removedElement)));

echo "Caractere removido: $removedElement[0]\n";
echo "Caractere ausente: $missingChar\n";
?>
