<?php

session_start();
require_once 'models/Project.php';
require_once 'models/User.php';
require_once 'config.php';

$projectModel = new Project();


if (isset($_SESSION["mail_user"])) {
    $user_email = $_SESSION["mail_user"];

    // Instanciez l'objet User
    $userModel = new User();

    // Utilisez la méthode getIdByEmail du modèle User
    $user_id = $userModel->getIdByEmail($user_email);




}



