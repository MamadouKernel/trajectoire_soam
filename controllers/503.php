<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require 'loader.php';
if (!isset($_SESSION['admin'])) {
    header('location:http://trajectoire.so-am.org/');
}




echo $twig->render('503.kmphtml.twig', [
    'log_connect' => $kernel->_log_connect()[0]
]);
