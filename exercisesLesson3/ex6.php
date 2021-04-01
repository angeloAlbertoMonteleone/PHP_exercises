<?php

$start = 124;
$end = 769;

/*
 * Calcolare e mostrare:
 *  - quanti numeri divisibili (divisione intera) per 3 ci sono tra $start e $end
 */
$modulo = 3;
$count = 0;
$arrDivisible = [];

for ($i = $start; $i <= $end; $i++) {
    if ($i % $modulo === 0) {
        $count++;
        $arrDivisible[] = $i;
    }
}

echo "Il totale dei numeri divisibile per 3 tra $start e $end e`: $count";
echo "<br>";
echo "<br>";


/*
 *  - i primi 7 numeri divisibili per 6 tra $start e $end
 */


$moduloSix = 6;
for ($j = $start; $j <= $end; $j++) {
    if ($j % $moduloSix === 0) {
        $arrDivisible[] = $j;
    }
}

echo "I primi 7 numeri divisibili per 6 tra $start e $end sono: ";

foreach ($arrDivisible as $key => $number) {
    if ($key > 6) {
        break;
    }
    echo $number . ", ";
}
echo "<br>";
echo "<br>";


//   - tra i numeri divisibili per 3 o per 5 tra $start e $end, contare quanti sono pari e quanti dispari

$countIsEven = 0;
$countIsOdd = 0;
for ($b = $start; $b <= $end; $b++) {
    if ($b % 3 === 0 || $b % 5 === 0) {
        $isEven = $b % 2 === 0;
        if ($isEven === true) {
            $countIsEven++;
        } else {
            $countIsOdd++;
        }
    }
}

echo "tra $start e $end ci sono $countIsEven numeri pari e $countIsOdd numeri dispari";


// *  - tra i numeri divisibili per 3 o per 5 tra $start e $end, mostrare i primi 10

$firstTen = [];
for ($a = $start; $a <= $end; $a++) {
    if ($a % 3 === 0 || $a % 5 === 0) {
        $firstTen[] = $a;
    }
}

echo "I primi 10 numeri, tra numeri divisibili per 3 o per 5 tra $start e $end sono: ";
foreach ($firstTen as $key => $value) {
    if ($key > 10) {
        break;
    }
    echo $value . ", ";
}
