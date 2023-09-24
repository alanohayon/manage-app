<?php


$host = 'localhost';  // ou utiliser 127.0.0.1
$dbname = 'SA';
$username = 'root';   // utilisateur par défaut de MAMP
$password = 'root';   // mot de passe par défaut de MAMP


try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Configurer PDO pour qu'il génère des exceptions en cas d'erreurs
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}

?>
