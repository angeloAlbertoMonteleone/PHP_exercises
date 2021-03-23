<?php

/*
 * array che contiene misurazioni di temperature (scala Farenight)
 */
$temperatures = [78, 60, 62, 68, 71, 68, 73, 85, 66, 64, 76, 63, 75, 76, 73, 68, 62, 73, 72, 65, 74, 62, 62, 65, 64, 68, 73, 75, 79, 73];

/*
 * 1) Calcolare e stampare:
 *      - la temperatura media
 *      - i 5 valori più bassi e i 5 valori più alti
 */

$sum = 0;

foreach ($temperatures as $temperature) {
    $sum += $temperature;
}

$elements = count($temperatures);
if($elements > 0) {
    $average = $sum / $elements;
    echo sprintf("The temperature average is %s", number_format($average, 2));
    
    echo "<br>";
    echo "<br>";
    
    echo "List of 5 lowest temperatures";
    echo "<br>";


    sort($temperatures);
    for($i = 0; $i <= 4; $i++) {
        echo sprintf("%s". ", ",$temperatures[$i]);
    }
    
    echo "<br>";
    echo "<br>";
    
    echo "List of 5 highest temperatures";
    echo "<br>";
    $temperaturesInReverseOrder = array_reverse($temperatures);
    for($i = 0; $i <= 4; $i++) {
        echo sprintf("%s". ", ",$temperaturesInReverseOrder[$i]);
    }
    
} else {
    echo "No elements found";
}

