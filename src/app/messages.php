<?php
session_start();

//variable prenom qui retient le prenom du responsable
$prenomResp = $_SESSION["prenomResp"];
//ud de connexion
$id = mysqli_connect("127.0.0.1:8889", "root", "root", "ticketing");

//requete pour verifier qu'il s'est bien identifier avant d'arriver ici
$resulVerif = mysqli_query($id, "Select * from responsable where prenom ='$prenomResp'");
$ligne = mysqli_fetch_assoc($resulVerif);
$id_u = $ligne["id"];

//si il ne renvoit pas de resultat alors il est redirigé vers la page de connexion
if (mysqli_num_rows($resulVerif) == 0) {

    header("location:Connexion.php");
}

echo "Bonjour $prenomResp !";

?>

<?php

if ($_GET['id_to'] != 'null') {
    $id_to = $_GET['id_to'];
    // Utilisez $id_to dans votre code
} else {
    $id_to = last_discu($id_u);
    echo $id_to;
    // Utilisez $id_to dans votre code
}

function last_discu($id_user)
{

    $id = mysqli_connect("127.0.0.1:8889", "root", "root", "ticketing");
    $result = mysqli_query($id, "SELECT* FROM messages WHERE ( id_receiver = '$id_user' OR id_sender = '$id_user' ) 
        ORDER by sent_at DESC LIMIT 1");

    if (!$result) {

        die("L'insertion a échoué : " . mysqli_error($id));
    }

    $row = mysqli_fetch_assoc($result);

    // Valeur par défaut
    $id_to = 4; 

    if ($row) {
        if ($row['id_sender'] == $id_user) {
            $id_to = $row['id_receiver'];
        } else {
            $id_to = $row['id_sender'];
        }
    }

    return $id_to;
}

function info_to_user($id_user)
{
    $id = mysqli_connect("127.0.0.1:8889", "root", "root", "ticketing");
    $result = mysqli_query($id, "SELECT* FROM responsable WHERE id = '$id_user' ");
    $ligne = mysqli_fetch_assoc($result);
    $nom = $ligne["nom"];
    $prenom = $ligne["prenom"];
    return array("nom" => $nom, "prenom" => $prenom);
}

//envoie message
function send_msg($id_u, $id_to, $msg)
{

    $id = mysqli_connect("127.0.0.1:8889", "root", "root", "ticketing");
    $result = mysqli_query($id, "INSERT INTO messages VALUES (NULL,'$id_u', '$id_to', '$msg', NOW(), null)");

    if (!$result) {

        die("L'envoie à echoué : " . mysqli_error($id));
      } else {
        echo "<script>window.location = 'messages?id_to=' . $id_to . '';</script>";
      }

}

function all_discu($id_user)
{
    $id = mysqli_connect("127.0.0.1:8889", "root", "root", "ticketing");

    $result = mysqli_query($id, "SELECT DISTINCT id_receiver FROM messages WHERE id_sender = '$id_user'");
    $result1 = mysqli_query($id, "SELECT DISTINCT id_sender FROM messages WHERE id_receiver = '$id_user'");

    $contacts = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $contacts[] = $row;
    }
    while ($row = mysqli_fetch_assoc($result1)) {
        $contacts[] = $row;
    }

    $contacts = array_map(function ($item) {

        //toute les key s'appellerons 'id'
        $item["id"] = isset($item["id_receiver"]) ? $item["id_receiver"] : $item["id_sender"];
        unset($item["id_receiver"], $item["id_sender"]);

        return $item;
    }, $contacts);

    $values = array();
    foreach ($contacts as $key => $subArray) {
        $value = reset($subArray);
        if (in_array($value, $values)) {
            unset($contacts[$key]);
        } else {
            $values[] = $value;
        }
    }

    return $contacts;
}

//quand il clic sur le bouton envoyer un msg
if (isset($_POST['boot'])) {
    extract($_POST);

    if (empty($msg)) {
    } else {
        //permet de ne pas inserer de html
        $msg = htmlspecialchars(strip_tags($message));

        //on creer un nvx msg
        send_msg($id_u, $id_to, $msg);

    }
}

//on stock dans les variables toutes les info utiles du user
// $user_Info = $userController->displayMyProfile();
// $avatar_u = $user_Info['profile_picture'];
// $avatar_u = '<img src="http://localhost:8888/mysocialnetwork/public/images/profile-images/'.$avatar_u.'" alt="'.$avatar_u.'">';
// $nom_u = $user_Info['last_name'];
// $prenom_u = $user_Info['first_name'];
// $promo_u = $user_Info['promo'];

//on stock dans dautres variable toutes les info de l'autre user
//qui vont etre utiliser en haut la discussion actuel
// $user_to= $userController->displayUserProfile($id_to);
// $avatar_to = $user_to['profile_picture'];
// $avatar_to = '<img src="http://localhost:8888/mysocialnetwork/public/images/profile-images/'.$avatar_to.'" alt="'.$avatar_to.'">';
// $nom_to = $user_to['last_name'];
// $prenom_to = $user_to['first_name'];
// $promo_to = $user_to['promo'];
// $email_to = $user_to['email'];





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <title>Messagerie</title>
</head>

<body>

    <div class="messagerie">

        <div class="all-discussions">

            <div class="recherche-contact">
                <!-- barre de recherche AJAX -->
                <form action="">
                    <input type="text" id="search-user-f" value="" placeholder="Recherche..." />
                </form>
                <div style="margin-top: 20px;">
                    <div id="result-search-f"></div>
                </div>
            </div>

            <div class="contacts">
                <?php
                //on recupere les discussion precedente
                $contacts = all_discu($id_u);
                //on affiche les differentes discu
                foreach ($contacts as $contact) {
                    echo '<div class ="contact" >';
                    $id_contact = $contact['id'];
                    //pour chaque discu on recupere les infos de la personne

                    $info_user = info_to_user($id_contact);
                    $nom_id = $info_user["nom"] ;
                    $prenom_id = $info_user["prenom"] ;

                             ?>

                    <a href="location:messages.php?id_to=<?php echo $id_contact ?>">
                        <?php echo $nom_id . ' ' . $prenom_id; ?></a>

                <?php echo '</div>
                        </div>';
                }

                ?>
            </div>


        </div>

        <!-- infos du contact actuel en haut des msgs -->
        <div class="discussion-actuel">
            <div class="info_contact">
                <?php echo "Avatar"; ?>
                <div class="nom-contact">
                        <?php 
                        $info_user = info_to_user($id_to);
                        $nom_to = $info_user["nom"] ;
                        $prenom_to = $info_user["prenom"] ;

                        echo $nom_to . ' ' . $prenom_to;
                         ?>
                
                </div>
            </div>
            <div class="messages" id="messages">
                <!-- messages en direct avec AJAX -->
            </div>

            <!-- ecrire un nvx msg -->
            <div class="nvx-message">

                <form method="POST" action="location:messages.php?id_to=<?php echo $id_to ?>">
                    <textarea name="message" cols="40" rows="2" placeholder="Votre message..."></textarea>
                    <input type="submit" name="boot" value="Envoyer" class="text-white mr-8 w-16" />
                </form>
            </div>

        </div>
    </div>

</body>
</html>

<!-- <script type="text/javascript"> -->
    function scrollbas() {
        var msg = document.getElementById('messages');
        msg.scrollTop = msg.scrollHeight;
    }
    setTimeout(scrollbas, 10);




    $(document).ready(function() {
        $('#search-user-f').keyup(function() {
            $('#result-search-f').html(''); //modifie l'html pour rafraichir la recherche

            var utilisateur = $(this).val();

            // // console.log(utilisateur);
            if (utilisateur != "") {

                $.ajax({
                    type: 'GET',
                    url: 'router.php?page=search_user_frends&userId=<?php echo $id_u ?>',
                    // url: '/Applications/MAMP/htdocs/mysocialnetwork/app/views/messages/recherche_user_msg.php?page=message',
                    data: 'users=' + encodeURIComponent(utilisateur),
                    success: function(data) {
                        if (data != "") {
                            $('#result-search-f').append(data); //data

                        } else {
                            document.getElementById('result-search-f').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top:10px'>Aucun utilisateur</div>";
                        }
                    }
                });
            }
        });
    });

    //     $(document).ready(function() {
    //     $('#search-user-f').keyup(function() {
    //         $('#result-search-f').html('');

    //         var utilisateur = $(this).val();

    //         if (utilisateur != "") {
    //             $.ajax({
    //                 type: 'GET',
    //                 url: 'recherche_user_msg.php', // URL relative
    //                 data: 'users=' + encodeURIComponent(utilisateur) + '&page=message',
    //                 success: function(data) {
    //                     if (data != "") {
    //                         $('#result-search-f').append(data);
    //                     } else {
    //                         document.getElementById('result-search-f').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top:10px'>Aucun utilisateur</div>";
    //                     }
    //                 }
    //             });
    //         }
    //     });
    // });


    function msg_live() {
        // Créer une instance XMLHttpRequest
        var xhr = new XMLHttpRequest();

        // Définir la fonction de rappel à appeler lorsqu'on obtient une réponse du serveur
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Si la requête réussit, mettre à jour la div "messages" avec le contenu reçu
                    document.getElementById("messages").innerHTML = xhr.responseText;
                }
            }
        };

        // Envoyer une requête GET à "discu_live.php"

        xhr.open("GET", "router.php?page=discu_user&id_to=<?php echo $id_to ?>", true);

        xhr.send();
        // scrollbas();

        // Actualiser la page toutes les secondes
        setTimeout(msg_live, 500);
    }

    // Appeler la fonction pour la première fois pour démarrer l'actualisation
    msg_live();
</script>


<style>
/* Style général de la page */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
}

.messagerie {
    border: 2px solid green;

    display: grid;
    grid-template-columns: 1fr 3fr; /* Divise la messagerie en 1/4 et 3/4 */
    margin: 6% 20% 3% 20%;
    padding: 5%;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.all-discussions {
    border: 2px solid green;
    padding: 10px;
    background-color: #f9f9f9;
    border-radius: 5px;
    overflow: hidden;
    display: grid;
    grid-template-rows: 1fr 9fr; /* Divise la partie gauche en 1/10 et 9/10 */
}

.recherche-contact {
    padding: 10px;
}

.contacts {
    border: 2px solid green;

    overflow-y: auto;
    padding: 10px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.contact {

    padding: 10px;
    margin: 5px 0;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    text-align: center;
}

/* Style de la discussion actuelle */
.discussion-actuel {
    border: 2px solid green;

    margin-left: 2%;
    padding: 10px;
    background-color: #fff;
    border-radius: 5px;
    overflow: hidden;
}

.info_contact {
    border: 2px solid green;

    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.nom-contact {
    margin-left: 10px;
    font-size: 20px;
    font-weight: bold;
}

.messages {
    border: 2px solid green;

    max-height: 400px;
    overflow-y: auto;
    padding: 10px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.nvx-message {
    border: 2px solid green;

    margin-top: 10px;
}

.nvx-message textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    resize: none;
}

.nvx-message input[type="submit"] {
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
}

.nvx-message input[type="submit"]:hover {
    background-color: #0056b3;
}

</style>