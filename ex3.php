<?php

/*
 * le chiavi rappresentano i nomi delle persone, i valori rappresentano le età
 */
$people = [
    "Sofia" => "31",
    "Jacob" => "41",
    "William" => "39",
    "Matt" => "40",
];


/*
 * 1) Stampare li seguenti righe per ogni elemento di $people:
 *      Sofia is 31
 *      Jacob is 41
 *      ...
 */
foreach ($people as $key => $age) {
    print_r("$key is $age");
    echo "<br>";
}


echo "<br>";
echo "<br>";


// 2) Stampare le stesse righe, ma ordinate per età (dal più giovane al più anziano)
asort($people);
foreach ($people as $key => $age) {
    print_r("$key is $age");
        echo "<br>";    
}


echo "<br>";
echo "<br>";


// 3) Stampare le stesse righe, ma ordinate per età (dal più anziano al più giovane)
arsort($people);
foreach ($people as $key => $age) {
    print_r("$key is $age");
        echo "<br>";    
}



echo "<br>";
echo "<br>";


// 4) Stampare le stesse righe, ma ordinate per nome (alfabeticamente)
ksort($people);
foreach ($people as $key => $age) {
    print_r("$key is $age");
        echo "<br>";    
}


echo "<br>";
echo "<br>";


// 5) Stampare le stesse righe, ma ordinate per nome (alfabeticamente in ordine inverso)
krsort($people);
foreach ($people as $key => $age) {
    print_r("$key is $age");
        echo "<br>";    
}
