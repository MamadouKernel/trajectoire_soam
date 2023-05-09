<?php
require 'loader.php';
if (!isset($_SESSION['admin'])) {
    header('location:http://trajectoire.so-am.org/');
}

// $reponse = '';

if (isset($_GET['creancier']) ) {
    extract($_GET);

    $edit_repayment = $ask_credits->verif_id_emprunt($creancier);
//    var_dump($edit_admin[0]->image);
//    exit();
}//else{
   // $reponse .='erreur';
//}

echo $twig->render('list_ask.kmphtml.twig', [
    'log_connect' => $kernel->_log_connect()[0],
    'select_repayment' => $edit_repayment,
    // 'restmont' => $ask_credits->all_repayment(),
    //  'message' => $reponse,
     'message_erreur' => 'Désoler ce créancie n\'a éffectué aucun paiement!',
    // 'message_echec' => 'Echec de suppression',
]);