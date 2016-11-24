<?php

try {
    // On se connecte à MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=tp_evalue_01;charset=utf8', 'root', 'mode83');
}

catch(Exception $e) {

    // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}