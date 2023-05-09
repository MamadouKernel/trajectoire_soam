<?php
require 'loader.php';
if (!isset($_SESSION['admin'])) {
    header('location:http://trajectoire.so-am.org/');
}

$reponse = "";
if (isset($_POST['enregistre'])) {
    extract($_POST);

    $verif_ask_credit = $ask_credits->verif_ask_encour($creancier);

    if ($verif_ask_credit != 0) {
        $reponse .= 'echec';
    } else {
        $date_j = date("d/m/Y");
        //id de l'admin
        $idad = $kernel->_log_connect()[0]->IdAdmin;
        $status = 1;
        $insert_ask = $ask_credits->add_ask($montant,$dateget,$dategive,$status,$date_j,$typope,$creancier,$idad);

        if ($insert_ask == true) {
            $reponse .= "success";
        } else {
            $reponse .= "echecc";
        }
    }
}


echo $twig->render('ask_credit.kmphtml.twig', [
    'log_connect' => $kernel->_log_connect()[0],
    'select_types' => $type_ope->select_type_ope(),
    'select_creanciers' => $creance->select_creancier(),
    'message' => $reponse,
    'message_success' => 'L\'Enregistrement du crédit a bien été enregistrer avec sucèss',
    'message_echec' => 'Echec d\'enregistrement veuillez verifier si les informations sont correctes',
    'add_exit' => 'Désoler cet créancier ne peut pas avoir de prêt car il a un pêt en cour!',
]);