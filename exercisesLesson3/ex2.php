<?php

$countries = [
    "Italy" => "Rome",
    "Luxembourg" => "Luxembourg",
    "Belgium" => "Brussels",
    "Denmark" => "Copenhagen",
    "Finland" => "Helsinki",
    "France" => "Paris",
    "Slovakia" => "Bratislava",
    "Slovenia" => "Ljubljana",
    "Germany" => "Berlin",
    "Greece" => "Athens",
    "Ireland" => "Dublin",
    "Netherlands" => "Amsterdam",
    "Portugal" => "Lisbon",
    "Spain" => "Madrid",
    "Sweden" => "Stockholm",
    "United Kingdom" => "London",
    "Cyprus" => "Nicosia",
    "Lithuania" => "Vilnius",
    "Czech Republic" => "Prague",
    "Estonia" => "Tallin",
    "Hungary" => "Budapest",
    "Latvia" => "Riga",
    "Malta" => "Valetta",
    "Austria" => "Vienna",
    "Poland" => "Warsaw",
];

/*
 * 1) Stampare la seguente riga per ogni elemento di $countries:
 *  The capital of Netherlands is Amsterdam
 *  The capital of Greece is Athens
 *  ...
 */
foreach ($countries as $key => $country) {
        print_r("The capital of $key is $country");
        echo "<br>";
    }
 

    echo "<br>";
    echo "<br>";
    echo "<br>";

    
    
 // 2) Stampare le stesse righe, ma ordinate (alfabeticamente) per capitale
 asort($countries);
    foreach ($countries as $key => $country) {
    print_r("The capital of $key is $country");
    echo "<br>";
}

echo "<br>";
echo "<br>";
echo "<br>";



//3) Stampare le stesse righe, ma ordinate (alfabeticamente) per nome del paese
ksort($countries);
foreach ($countries as $key => $country) {
    echo sprintf("The capital of %s is %s", $key, $country);
    echo "<br>";
}


