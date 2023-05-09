<?php
require 'loader.php';
if (!isset($_SESSION['admin'])) {
    header('location:http://trajectoire.so-am.org/');
}



if (isset($_GET['list'])) {
    extract($_GET);

    $edit_repayment = $ask_credits->list_emprunt_by_client($list);
//    var_dump($edit_admin[0]->image);
//    exit();
} /*else {
    header('location:http://trajectoire/dashboard');
}*/

// var_dump($ask_credits->list_emprunt_by_client($_GET['list']));
// exit();
 
echo $twig->render('list_emprunt_client.kmphtml.twig', [
    'log_connect' => $kernel->_log_connect()[0],
    'select_emprunts' => $ask_credits->list_emprunt_by_client($_GET['list']),
]);