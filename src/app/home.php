<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/accueil.css">
</head>

<body>

  <div class="voir-tickets">
    <a href="AfficheAllTickets.php">Voir les tickets</a><br><br>
  </div>
  <div class="voir-mes-tickets">
    <a href="MesTickets.php">Mes tickets</a><br><br>
  </div>
  <div class="creer-ticket">
    <a href="CreateTicket.php">Créer un ticket</a><br><br>
  </div>
  <div class="messagerie">
    <a href="chatResp.php">Messagerie</a><br><br>
  </div>

</body>

</html>


<style>
    .messagerieO {
        border: 1px solid blue;
        border-radius: 20px;
        border-top-left-radius: 0;
        margin-left: 30%;
        width: 50%;
        /* overflow: hidden; */
        min-height: 50%;
        min-width: 40%;
        max-height: 60%;
        max-width: 50%;
    }

    .contacts {
        /* border: 1px solid rgb(230, 89, 255); */
        /* margin-top: 10%; */
        overflow-y: scroll;
        border-bottom-left-radius: 20px;
        height: 90%;
        padding-top: 2%;


    }

    .discussions {
        /* border: 1px solid green; */
        border-right: 2px solid blue;
        width: 100%;
        float: left;
        /* min-height: 50%; */
        /* display: flex; */
        flex-direction: column;
        height: 60%;
        max-width: 30%;

    }

    .recherche {
        /* border: 1px solid rgb(255, 49, 49); */
        height: 8%;

    }

    .recherche input[type="text"] {
        /* border: 1px solid rgb(255, 49, 49); */
        margin-top: 3%;
        width: 80%;

    }

    .recherche form {
        border: 1px solid black;
        margin: 2px;
        PADDING-left: 6%;
        border-radius: 20px;
        width: 100%;
        height: 100%;

    }

    .resul_search_f {
        position: relative;
        z-index: 2;
        /* border: 1px solid rgb(255, 24, 24);
        background-color: grey;
        display: flex;
        max-width: 100%;
        padding: 2%; */
        margin-bottom: 3px;
        background-color: #5079a2;
        display: flex;
        max-width: 100%;
        padding: 2%;
    }

    .nom_search_f {
        float: right;
        font-size: 1em;
        width: 80%;
        padding-left: 4%;
        padding-top: 5%;
    }

    .avatar_search_f {
        width: 20%;
    }


    .avatar_search_f img {
        border-radius: 28px;
        border: 1px solid black;
        max-width: 100%;
    }

    .nom_search_f a {
        text-decoration: none;
        color: #102136
    }

    .nom_search_f a:hover {
        text-decoration: none;
        color: #ffffff;


    }

    /*
      .recherche input[type="text"] {
        font-size: 16px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        flex: 1;
      }

      .recherche input[type="text"]:focus {
        outline: none;
        border: 1px solid #007bff;
      }
       */

    .contact {
        /* border-radius: 30px; */
        margin-bottom: 3px;
        background-color: #c1ccd3;
        display: flex;
        max-width: 100%;
        padding: 2%;

    }

    .contact img {
        border-radius: 28px;
        border: 1px solid black;
        max-width: 100%;
    }

    .nom_id {
        float: right;
        font-size: 1em;
        width: 80%;
        padding-left: 4%;
        padding-top: 5%;

    }

    .nom_id a {
        text-decoration: none;
        color: #102136
    }

    .nom_id a:hover {
        color: #ffffff;
    }

    .avatar_id {
        width: 20%;
    }


    .discussion {
        display: flex;
        flex-direction: column;
        margin-left: 30%;
        min-height: 60%;
        min-width: 60%;
        max-height: 60%;
        max-width: 70%;

    }

    .info_contact {
        border: 1px solid blue;
        /* border-top-left-radius: 20px; */
        border-top-right-radius: 20px;
        background-color: white;
        display: flex;
        padding: 2%;

    }

    .info_contact img {
        border-radius: 48%;
        border: 1px solid black;
        width: 13%;
        height: 12%;
    }

    .nom {
        float: right;
        font-size: 1.5em;
        margin-top: 3%;
        margin-left: 3%;
        width: 45%;
    }

    .nom a {
        text-decoration: none;
        color: #102136
    }


    .nom a:hover {
        color: #102136
    }

    .promo {
        float: right;
        font-size: 1em;
        background-color: #c1ccd3;
        padding: 2%;
        border-radius: 10px;
        /* margin-right: 15%; */

    }

    .messages {
        flex: 1;
        border: 1px solid blue;
        overflow-y: scroll;
        padding: 1%;
    }

    .message_envoye {
        margin-bottom: 1%;
        clear: both;
        float: right;
        max-width: 60%;
    }

    .avatar_msg {
        border: 1px solid black;
        border-radius: 20px;
        float: right;
        width: 8%;
    }

    .avatar_msg img {
        max-width: 100%;
        border-radius: 20px;

    }

    .contenu_msg {
        background-color: #0c14147a;
        border: 1px solid black;
        color: white;
        margin-right: 2%;
        float: right;
        margin-bottom: 4px;
        border-radius: 15px;
        padding: 2%;
        max-width: 80%;
    }

    .message_recu {
        margin-bottom: 1%;
        clear: both;
        float: left;
        max-width: 60%;
    }

    .avatar_msg_r {
        border: 1px solid black;
        border-radius: 20px;
        float: left;
        width: 8%;
    }

    .avatar_msg_r img {
        max-width: 100%;
        border-radius: 20px;

    }

    .contenu_msg_r {
        background-color: #778d93;
        border: 1px solid black;
        color: white;
        margin-left: 2%;
        float: left;
        margin-bottom: 4px;
        border-radius: 15px;
        padding: 2%;
        max-width: 80%;
    }

    .nvx_message {
        border: 1px solid blue;
        /* border-bottom-left-radius: 20px; */
        border-bottom-right-radius: 20px;
        background-color: white;
        padding-top: 1%;

    }

    textarea {
        border-radius: 5px;
        color: white;
        border: 0;
        background-color: #102136;
        border-radius: 10px;
        resize: none;
        font-family: serif;
        font-size: 1.2em;
        margin-left: 1%;
        padding-top: 2%;
        width: 70%;
    }

    .nvx_message form {
        border: 1px solid black;
        display: flex;
        width: 90%;
        margin-left: 5%;
        background-color: #102136;
        border-radius: 20px;

    }

    input[type="submit"] {
        background-image: url('MAMP/htdocs/mysocialnetwork/public/image/avatar/logo_envoie.png');
        background-repeat: no-repeat;
        background-position: center center;
        max-width: 100%;
        background-color: #102136;
        border: none;
        cursor: pointer;
        overflow: right;
        border-radius: 34px;
        width: 12%;
        background-size: 39%;
        margin-left: 15%;
    }

    input[type="submit"]:hover {
        background-color: #3787dc;
    }

    textarea:focus {
        outline: none;
    }


    /* @media screen and (min-width: 768px) {
        .messages {
            max-height: 300px;
        }

        .message-envoye,
        .message-recu {
            max-width: 50%;
        }
    } */
</style>