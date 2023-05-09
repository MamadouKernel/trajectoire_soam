<?php
require 'loader.php';
if (!isset($_SESSION['admin'])) {
    header('location:http://trajectoire.so-am.org/');
}

$reponse = "";
if (isset($_POST['enregistre'])) {
    extract($_POST);

    $verif_type_ope = $type_ope->verif_type_ope($nomtypeope);

    if ($verif_type_ope != 0) {
        $reponse .= 'echec';
    } else {
        $date_j = date("d/m/Y");
        //id de l'admin
        $idad = $kernel->_log_connect()[0]->IdAdmin;

        $insert_add = $type_ope->add_type_ope($nomtypeope, $descr, $date_j, $idad);

        if ($insert_add == true) {
            $reponse .= "success";
        } else {
            $reponse .= "echecc";
        }
    }
}
//SUPRESSION DU FICHIER

$reponses = "";
if (isset($_GET['del'])) {
    extract($_GET);

    $del = $type_ope->del_type_ope($del);
    if ($del == true) {
        $reponses .= "del";
    } else {
        $reponses .= "nodel";
    }
}


echo $twig->render('add_tope.kmphtml.twig', [
    'log_connect' => $kernel->_log_connect()[0],
    'select_types' => $type_ope->select_type_ope(),
    'message' => $reponse,
    'messages' => $reponses,
    'message_success' => 'Le Type d\'opération a bien été enregistrer avec sucèss',
    'message_echec' => 'Echec d\'enregistrement veuillez verifier si les informations sont correctes',
    'add_exit' => 'Désoler ce Type d\'opération existe déjà',
    'message_sup' => 'L\'opération a bien été supprimé avec sucèss',
    'message_no_sup' => 'Echec de suppression',
]);