<?php
require 'loader.php';
if (!isset($_SESSION['admin'])) {
    header('location:http://trajectoire.so-am.org/');
}

//modification

$reponse = "";
if (isset($_POST['modifier'])) {
    extract($_POST);


    $edit_add = $type_ope->edit_type_op($nomtypeope, $descr, $id_edit);

    if ($edit_add == true) {
        $reponse .= "success";
        
    } else {
        $reponse .= "echecc";
    }
}

// selection

if (isset($_GET['edit']) and $type_ope->verif_id_type_ope($_GET['edit']) != NULL) {
    extract($_GET);

    $edit_type_op = $type_ope->id_type_ope($edit);
//    var_dump($edit_client[0]->image);
//    exit();
} else {
    header('location:http://trajectoire.so-am.org/dashboard');
}

echo $twig->render('edit_tope.kmphtml.twig', [
    'log_connect' => $kernel->_log_connect()[0],
    'type_op' => $type_ope->id_type_ope($edit),
    'message' => $reponse,
    'message_success' => 'Le Type d\'opération a bien été modifier avec sucèss',
    'message_echec' => 'Echec d\'enregistrement veuillez verifier si les informations sont correctes',
    'add_exit' => 'Désoler ce Type d\'opération n\'existe pas',
]);