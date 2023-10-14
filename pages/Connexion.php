<?php
session_start();
require_once '../config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = $_POST['mail'];
    $mdp = $_POST['mdp'];

    // Vérifier si les champs ne sont pas vides
    if (empty($mail) || empty($mdp)) {
        $error = "Tous les champs sont obligatoires!";
    } else {
        // Vérification de la connexion
        try {
            $stmt = $db->prepare("SELECT * FROM technicien WHERE mail = ?");
            $stmt->execute([$mail]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($mdp, $user['mdp'])) {
                $_SESSION["mail_user"] = $user['mail'];
                header("Location: projects-page.php");
                exit;
            } else {
                $error = "Adresse e-mail ou mot de passe incorrect!";
            }
        } catch (PDOException $e) {
            $error = "Erreur lors de la connexion: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion à Ticketing</title>
</head>
<body>
<?php include '../header.php'; ?>
<div class="bg-gray-200 h-screen flex justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl mb-6 text-center font-bold">Connexion à Ticketing</h2>

        <!-- Afficher les erreurs -->
        <?php if ($error): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p><?= $error ?></p>
            </div>
        <?php endif; ?>

        <form action="connexion.php" method="post" class="space-y-6">
            <div>
                <label for="mail" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="mail" id="mail" required class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div>
                <label for="mdp" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" name="mdp" id="mdp" required class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div>
                <button type="submit" class="mt-4 w-full p-2 text-white hover:bg-green-700 rounded-md" style="background-color: #3E497A">Se connecter</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
