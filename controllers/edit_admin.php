<?php

require 'loader.php';
if (!isset($_SESSION['admin'])) {
    header('location:http://trajectoire.so-am.org/');
}

$reponses = '';

if (isset($_POST['modifier'])) {
    extract($_POST);
    $verif_edit_admin = $kernel->verif_id_admin($id_edit);
    if ($verif_edit_admin == 0) {
        $reponses .= 'echec';
    } else {
        $uploads_dir = '../src/files/';
        $image_bout = $_FILES['photoadmin']['name'];
        $tmp_name = $_FILES["photoadmin"]["tmp_name"];
        if (empty($image_bout)) {
            $image_bout = $current_image;
        }

        $edit_add = $kernel->edit_admins($image_bout, $n, $email, $tel, $mdp, $role, $tpiece, $nump, $id_edit);

        if ($edit_add == true) {
            $reponses .= "success";
            if (!empty($image_bout)) {
                move_uploaded_file($tmp_name, $uploads_dir . $image_bout);
            }
        } else {
            $reponses .= "echecc";
        }
    }
}

if (isset($_GET['edit']) and $kernel->verif_id_admin($_GET['edit']) != NULL) {
    extract($_GET);

    $edit_admin = $kernel->select_edit_admin($edit);
//    var_dump($edit_admin[0]->image);
//    exit();
} else {
    header('location:http://trajectoire.so-am.org/dashboard');
}


echo $twig->render('edit_admin.kmphtml.twig', [
    'log_connect' => $kernel->_log_connect()[0],
    'edit_admins' => $edit_admin[0],
    'message' => $reponses,
    'message_success' => 'L\'Administrateur ou le gestionnaire a bien été modifier avec sucèss',
    'message_echec' => 'Echec d\'enregistrement veuillez verifier si les informations sont correctes',
    'add_noexit' => 'Désoler cet administrateur ou ce gestionnaire n\'existe pas',
]);