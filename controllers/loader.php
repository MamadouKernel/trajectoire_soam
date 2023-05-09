<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$session = session_id();
if (empty($session)) {
    session_start();
}


$root = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR;
define('chemin', $root);

include chemin . 'core/DB_connect.php';
$db = new DATABASE();

include chemin . 'apps/Admins.php';
$kernel = new Admins($db);

include chemin . 'apps/creancier.php';
$creance = new creancier($db);

include chemin . 'apps/topera.php';
$type_ope = new type_ope($db);

include chemin . 'apps/ask_credits.php';
$ask_credits = new ask_credits($db);

require chemin . 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader([chemin . 'templates', chemin . 'views']);
$twig = new \Twig\Environment($loader, [
        //'cache' => chemin.'caches',
        ]);


if (isset($_GET['logout']) and $_GET['logout'] == true) {
    unset($_SESSION['Users']);
    session_destroy();
    ?>
    <script>
        setTimeout(function () {
            window.location.href = 'login'
        }, 0)
    </script>
<?php }
?>