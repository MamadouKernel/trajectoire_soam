<?php
require 'loader.php';
if (!isset($_SESSION['admin'])) {
    header('location:http://trajectoire.so-am.org/');
}

$reponse = "";
if (isset($_GET['del'])) {
    extract($_GET);
    $del = $creance->del_creancier($del);
    if ($del == true) {
        $reponse .= "success";
    } else {
        $reponse .= "echec";
    }
}


echo $twig->render('view_creancier.kmphtml.twig', [
    'log_connect' => $kernel->_log_connect()[0],
    'select_creancier' => $creance->select_creancier(),
    'message' => $reponse,
    'message_success' => 'Le Créancier a bien été supprimé avec sucèss',
    'message_echec' => 'Echec de suppression',
]);