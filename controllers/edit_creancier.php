<?php

require 'loader.php';
if (!isset($_SESSION['admin'])) {
    header('location:http://trajectoire.so-am.org/');
}

$reponses = "";
if (isset($_POST['modifier'])) {
    extract($_POST);
    $verif_edit_creancier = $creance->verif_id_creancier($id_edit);
    if ($verif_edit_creancier == 0) {
        $reponses .= 'echec';
    } else {
        $uploads_dir = '../src/files/';
        //image
        $image_bout = $_FILES['photoadmin']['name'];
        $tmp_name = $_FILES["photoadmin"]["tmp_name"];
        //le recto
        $recto = $_FILES['recto']['name'];
        $tmp_name_recto = $_FILES["recto"]["tmp_name"];
        //le verso
        $verso = $_FILES['verso']['name'];
        $tmp_name_verso = $_FILES["verso"]["tmp_name"];
        if (empty($image_bout)) {
            $image_bout = $current_image;
            $recto = $current_recto;
            $verso = $current_verso;
        }

        $edit_add = $creance->edit_creancier($image_bout, $n, $tel, $email, $resid, $prof, $revm, $tpiece, $nump, $recto, $verso, $id_edit);

        if ($edit_add == true) {
            $reponses .= "success";
            if (!empty($image_bout)) {
                move_uploaded_file($tmp_name, $uploads_dir . $image_bout);
                move_uploaded_file($tmp_name_recto, $uploads_dir . $recto);
                move_uploaded_file($tmp_name_verso, $uploads_dir . $verso);
            }
        } else {
            $reponses .= "echecc";
        }
    }
}

if (isset($_GET['edit']) and $creance->verif_id_creancier($_GET['edit']) != NULL) {
    extract($_GET);

    $edit_client = $creance->id_creancier($edit);
//    var_dump($edit_client[0]->image);
//    exit();
} else {
    header('location:http://trajectoire.so-am.org/dashboard');
}

echo $twig->render('edit_creancier.kmphtml.twig', [
    'log_connect' => $kernel->_log_connect()[0],
    'edit_client' => $creance->id_creancier($edit),
    'message' => $reponses,
    'message_success' => 'L\'Administrateur ou le gestionnaire a bien été modifier avec sucèss',
    'message_echec' => 'Echec d\'enregistrement veuillez verifier si les informations sont correctes',
    'add_noexit' => 'Désoler cet administrateur ou ce gestionnaire n\'existe pas',
]);