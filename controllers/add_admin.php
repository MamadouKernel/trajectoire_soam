<?php
require 'loader.php';
if (!isset($_SESSION['admin'])) {
    header('location:http://trajectoire.so-am.org/');
}

$reponse = "";
if (isset($_POST['enregistre'])) {
    extract($_POST);

    $verif_adm = $kernel->verif_admin($email, $nump);

    if ($verif_adm != 0) {
        $reponse .= 'echec';
    } else {
        $date_j = date("d/m/Y");
        $uploads_dir = '../src/files/';
        $image_bout = $_FILES['photoadmin']['name'];
        $tmp_name = $_FILES["photoadmin"]["tmp_name"];
        $np = $n . ' ' . $p;
        $insert_add = $kernel->add_admin($image_bout, $np, $email, $tel, $mdp, $role, $typepie, $nump, $date_j);

        if ($insert_add == true) {
            $reponse .= "success";
            move_uploaded_file($tmp_name, $uploads_dir . $image_bout);
        } else {
            $reponse .= "echecc";
        }
    }
}

echo $twig->render('add_admin.kmphtml.twig', [
    'log_connect' => $kernel->_log_connect()[0],
    'message' => $reponse,
    'message_success' => 'L\'Administrateur ou le gestionnaire a bien été enregistrer avec sucèss',
    'message_echec' => 'Echec d\'enregistrement veuillez verifier si les informations sont correctes',
    'add_exit' => 'Désoler cet administrateur ou ce gestionnaire existe déjà',
]);