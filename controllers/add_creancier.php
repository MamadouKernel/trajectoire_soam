<?php

require 'loader.php';
if (!isset($_SESSION['admin'])) {
    header('location:http://trajectoire.so-am.org/');
}

$reponse = "";
if (isset($_POST['enregistre'])) {
    extract($_POST);
    $verif_adm = $creance->verif_creancier($email, $nump);

    if ($verif_adm != 0) {
        $reponse .= 'echec';
    } else {
        $date_j = date("d/m/Y");
        //id de l'admin
        $idad = $kernel->_log_connect()[0]->IdAdmin;
        $uploads_dir = '../src/files/';
        //pour le client
        $image_bout = $_FILES['photoadmin']['name'];
        $tmp_name = $_FILES["photoadmin"]["tmp_name"];
        //le recto
        $image_recto = $_FILES['recto']['name'];
        $tmp_name_recto = $_FILES["recto"]["tmp_name"];
        //le verso
        $image_verso = $_FILES['verso']['name'];
        $tmp_name_verso = $_FILES["verso"]["tmp_name"];

        $np = $n . ' ' . $p;
        $insert_add = $creance->add_creancier($image_bout, $np, $tel, $email, $resid, $prof, $revm, $tpiece, $nump, $image_recto, $image_verso, $date_j, $idad);

        if ($insert_add == true) {
            $reponse .= "success";
            //pour creancier
            move_uploaded_file($tmp_name, $uploads_dir . $image_bout);
            //pour recto
            move_uploaded_file($tmp_name_recto, $uploads_dir . $image_recto);
            //pour verso
            move_uploaded_file($tmp_name_verso, $uploads_dir . $image_verso);
        } else {
            $reponse .= "echecc";
        }
    }
}


echo $twig->render('add_creancier.kmphtml.twig', [
    'log_connect' => $kernel->_log_connect()[0],
    'message' => $reponse,
    'message_success' => 'Le Créancier a bien été enregistrer avec sucèss',
    'message_echec' => 'Echec d\'enregistrement veuillez verifier si les informations sont correctes',
    'add_exit' => 'Désoler ce créancier existe déjà',
]);