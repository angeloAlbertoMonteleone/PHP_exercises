<?php

/*
 * 1) includere il file config.php e stampare gli elementi di $cars
 */
require_once('config.php');

foreach ($cars as $car) {
    echo $car . ", ";
}
