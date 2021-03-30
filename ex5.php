<?php


$cart = [
    [
        'name' => 'Magazine',
        'price' => 2.54,
    ],
    [
        'name' => 'Shirt',
        'price' => 24.99,
    ],
    [
        'name' => 'Chewing gums',
        'price' => 4.99,
    ],
    [
        'name' => 'Snacks',
        'price' => 8.21,
    ],
    [
        'name' => 'Watch',
        'price' => 224.99,
    ],
    [
        'name' => 'Drink',
        'price' => 12,
    ],
];

/*
 * Calcolare e mostrare:
*/


// prezzo totale degli elementi
$totalPrice = 0;
foreach ($cart as $value) {
    $totalPrice += $value["price"];
}

echo "The total price is: ", $totalPrice;
echo "<br>";
echo "<br>";
echo "<br>";


// - l'item con prezzo maggiore e quello con prezzo minore
foreach ($cart as $value) {
    $arr[] = $value["price"];
}

$maxValue = max($arr);
$minValue = min($arr);

echo "The most expensive price is: ", $maxValue, " and the cheaper price is: ", $minValue;
echo "<br>";
echo "<br>";
echo "<br>";


//  - gli item ordinati per prezzo ascendente
sort($arr);
var_dump("array ordinato: ", $arr);
echo "<br>";
echo "<br>";
echo "<br>";


// gli item ordinati per prezzo ascendente, il cui totale non supera 46$
$totalValue = 0;
foreach ($arr as $key => $value) {
    $totalValue += $value;
}
echo "il totale degli item ordinati per prezzo ascendente e`: " . $totalValue;
echo "<br>";
echo "<br>";
echo "<br>";


//  - lista degli item in carrello e il prezzo totale
$totalPrice = 0;
$shoppingBag = '';
foreach ($cart as $value) {
    $totalPrice += $value["price"];
    $shoppingBag .= $value["name"] . ", ";
}
echo "gli items nel carrello sono: ", $shoppingBag, " e il prezzo totale e`: ", $totalPrice;
echo "<br>";
echo "<br>";
echo "<br>";

/** 
 *  - aggiungere la chiave $cart[...]['percentage_weight'] che memorizza il peso percentuale di ogni item rispetto al totale di spesa, con valori tra 0 e 100
 */

foreach ($cart as $value) {
    if ($value["name"] == 'Magazine' || $value["name"] == 'Chewing gums' || $value["name"] == 'Snacks') {
        $value['percentage_weight'] = 70;
        echo "<br>";
    } elseif ($value["name"] == 'Watch' || $value["name"] == 'Drink') {
        $value['percentage_weight'] = 40;
        echo "<br>";
    } elseif ($value["name"] == 'Shirt') {
        $value['percentage_weight'] = 10;
        echo "<br>";
    }

    print_r($value);
}
