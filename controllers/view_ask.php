<?php
require 'loader.php';
if (!isset($_SESSION['admin'])) {
    header('location:http://trajectoire.so-am.org/');
}


//supression

$reponse = "";
if (isset($_GET['del'])) {
    extract($_GET);
    $dele = $ask_credits->del_ask($del);
    if ($dele == true) {
        $reponse .= "success";
    } else {
        $reponse .= "echec";
    }
}

echo $twig->render('view_ask.kmphtml.twig', [
    'log_connect' => $kernel->_log_connect()[0],
    'select_ask' => $ask_credits->select_ask(),
    'message' => $reponse,
    'message_success' => 'L\'Emprunt a bien été supprimé avec sucèss',
    'message_echec' => 'Echec de suppression',
    // 'message_ask' => 'Payement effectué avec sucèss',
    // 'message_echec_ask' => 'Echec d\'enregistrement veuillez verifier si les informations sont correctes',
]);