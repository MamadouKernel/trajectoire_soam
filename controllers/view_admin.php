<?php
require 'loader.php';
if (!isset($_SESSION['admin'])) {
    header('location:http://trajectoire.so-am.org/');
}

$reponse = "";
if (isset($_GET['del'])) {
    extract($_GET);
    $del = $kernel->del_admin($del);
    if ($del == true) {
        $reponse .= "success";
    } else {
        $reponse .= "echec";
    }
}

echo $twig->render('view_admin.kmphtml.twig', [
    'log_connect' => $kernel->_log_connect()[0],
    'select_adminst' => $kernel->select_admin(),
    // 'message' => $reponse,
    // 'message_success' => 'L\'Administrateur ou le gestionnaire a bien été supprimé avec sucèss',
    // 'message_echec' => 'Echec de suppression',
]);