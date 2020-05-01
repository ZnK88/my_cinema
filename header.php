<?php
function addheader(){
print"<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Document</title>
    <link rel='stylesheet' href='style.css'>
    <script src='script.js'></script>
</head>
<body>
    <div class='header'>
    <a href='index.php' class='logo'><img src='my_cinema.png' alt='logo'></a>
    <a href='recherchefilmdate.php'>Quel film passe ce soir ?</a>
    <a href='login.php'>connexion</a>
    </div>
    <form action='index.php' class='PremierTableau' method='GET'>
        <div class='saisiezone'>
            <label for='name'>Nom : </label>
            <input type='text' id='nom' name='nom'>
        </div>
        <div class='saisiezone'>
            <label for='name'>prénom : </label>
            <input type='text' id='prenom' name='prenom'>
        </div>
        <button>Envoyer</button>
    </form>
";
}
?>