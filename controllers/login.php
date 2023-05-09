<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require 'loader.php';


/**
 * verification de session
 */
if (isset($_SESSION['admin'])) {
    header('location:http://trajectoire.so-am.org/dashboard');
}

$reponses = '';

if (isset($_POST['log'])) {
    extract($_POST);

    if ($options == 'Administrateur') {
        $role = '0';
    } elseif ($options == 'Gestionnaire') {
        $role = '1';
    }
    if ($kernel->_login_admin($email, $mdp, $role)) {
        $reponses .= 'success';
    } else {
        $reponses .= 'echec';
    }
}

echo $twig->render('login.kmphtml.twig', [
    'message' => $reponses,
    'message_connexion' => 'Connexion réussie ! le système va vous rediriger !....',
    'message_err_connexion' => 'Echec Vos données d\'ouverture de session sont incorrectes ! Réessayer SVP !'
]);
