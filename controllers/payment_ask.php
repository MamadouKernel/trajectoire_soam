<?php
require 'loader.php';
if (!isset($_SESSION['admin'])) {
    header('location:http://trajectoire.so-am.org/');
}

if (isset($_GET['emprunt']) and $ask_credits->select_emprunt_by_id($_GET['emprunt']) != NULL){
    extract($_GET);

    $edit_repayment = $ask_credits->select_emprunt_by_id($emprunt);
//    var_dump($edit_repayment);
//    exit();
   
} else {
    header('location:http://trajectoire.so-am.org/dashboard');
}

$reponses = "";

$montant_total_remboursse = $ask_credits->sum_remb_by_emp($_GET['emprunt']);

$montant_emprunt = $ask_credits->select_ask_by_id($_GET['emprunt']);

// var_dump($montant_emprunt[0]->MontantEmprunt);
// exit();
/*
* repayment
*/
if($montant_total_remboursse[0]->MontantTRemb == $montant_emprunt[0]->MontantEmprunt ){
    
    $ask_credits->update_statut_by_emprunt($_GET['emprunt']);
    $reponses .='solde';
}

if (isset($_POST['repayment'])) {
    extract($_POST);

    if($ask_credits->verif_rembou($idemprunt)==false){

        $montant_rest = $montant_emprunt[0]->MontantEmprunt - $price;
    }else{
        $montant_restant =$ask_credits->select_montrest_by_emprunt($idemprunt);
        $montant_rest = $montant_restant[0]->MontantRestant - $price;
    }
   
    // var_dump($montant_rest);
    // exit();

    $date_j = date("d/m/Y");

    //id de l'admin
    
    $idad = $kernel->_log_connect()[0]->IdAdmin;
    $status = 1;
    
    // verification du montant
    
    if($montant_total_remboursse[0]->MontantTRemb + $price <= $montant_emprunt[0]->MontantEmprunt){

        $insert_repayment = $ask_credits->repayment($price,$montant_rest,$status,$date_j,$idemprunt,$idtype,$idcreancier,$idad);

        if ($insert_repayment == true) {
            $reponses .= "successs";
          
        } else {
            $reponses .= "echecc";
        }
    
    }  else{
    
        $reponses .= 'erreur';
    }
}


$montant_total_remboursse = $ask_credits->sum_remb_by_emp($_GET['emprunt']);



echo $twig->render('payment_ask.kmphtml.twig', [
    'log_connect' => $kernel->_log_connect()[0],
    'select_ask' => $edit_repayment,
    'restmont' => $montant_total_remboursse[0]->MontantTRemb,
    'messages' => $reponses,
    'messages_solde' => 'Ce t\'emprunt est soldé',
    'message_erreur'=>'Le montant rembourssé est supperieur au montant emprunté',
    'message_ask' => 'Payement effectué avec sucèss',
    'message_echec_ask' => 'Echec d\'enregistrement veuillez verifier si les informations sont correctes',
]);