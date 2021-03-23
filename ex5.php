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
 *  - lista degli item in carrello e il prezzo totale
 *  - l'item con prezzo maggiore e quello con prezzo minore
 *  - gli item ordinati per prezzo ascendente
 *  - gli item ordinati per prezzo ascendente, il cui totale non supera 46$
 *  - aggiungere la chiave $cart[...]['percentage_weight'] che memorizza il peso percentuale di ogni item rispetto al totale di spesa, con valori tra 0 e 100
 */

$totalPrice = 0;
foreach ($cart as $value) {
    
    $totalPrice += $value["price"]; 
    
}

echo "The total price is: " ,$totalPrice;