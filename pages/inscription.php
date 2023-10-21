<?php
session_start();
require_once '../config.php';


// pour les erreurs
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail = $_POST['mail'];
    $mdp = $_POST['mdp'];

    // Vérifier si les champs ne sont pas vides
    if (empty($nom) || empty($prenom) || empty($mail) || empty($mdp)) {
        $error = "Tous les champs sont obligatoires!";
    } else {
        // Insertion dans la base de données
        try {
            $stmt = $db->prepare("INSERT INTO technicien (nom, prenom, mail, mdp) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $prenom, $mail, password_hash($mdp, PASSWORD_DEFAULT)]);

            // Si l'enregistrement est réussi, création la session et redirection vers dashboard.php
            $_SESSION["mail_user"] = $mail;
            header("Location: dashboard.php");
            exit;

        } catch (PDOException $e) {
            $error = "Erreur lors de l'inscription: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<?php include '../header.php'; ?>
<div class="bg-gray-200 h-screen flex justify-center">
<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <h2 class="text-2xl mb-6 text-center font-bold">Inscription à Ticketing</h2>

    <!-- Afficher les erreurs -->
    <?php if ($error): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p><?= $error ?></p>
        </div>
    <?php endif; ?>

    <form action="inscription.php" method="post" class="space-y-6">
        <div>
            <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
            <input type="text" name="nom" id="nom" required class="mt-1 p-2 w-full border rounded-md">
        </div>
        <div>
            <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
            <input type="text" name="prenom" id="prenom" required class="mt-1 p-2 w-full border rounded-md">
        </div>
        <div>
            <label for="mail" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="mail" id="mail" required class="mt-1 p-2 w-full border rounded-md">
        </div>
        <div>
            <label for="mdp" class="block text-sm font-medium text-gray-700">Mot de passe</label>
            <input type="password" name="mdp" id="mdp" required class="mt-1 p-2 w-full border rounded-md">
        </div>
        <div>
            <button type="submit" class="mt-4 w-full p-2 text-white hover:bg-green-700 rounded-md" style="background-color: #3E497A">S'inscrire</button>
        </div>
    </form>
</div>
</div>

</body>
</html>
