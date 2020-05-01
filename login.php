<?php
include ('connexion.php');
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
    </div>
    <form action='login.php' class='login' method='GET'>
        <div class='login'>
            <label for='name'>Nom d'utilisateur : </label>
            <input type='text' id='username' name='username'>
        </div>
        <div class='login'>
            <label for='name'>Mot de passe: </label>
            <input type='password' id='password' name='password'>
        </div>
        <button>Envoyer</button>
    </form>
    <a href='creecompte.php'>Pas de compte ? crée un compte</a>
";

if (isset($_GET['username']) && isset($_GET['password'])) {
    $username = htmlspecialchars($_GET['username']);
    $password = htmlspecialchars($_GET['password']);
    login($username,$password);
    
}
function login ($username,$password)
{
    if($username == NULL || $password == NULL || $username == NULL && $password == NULL)
    {
        print "champs vide ou incorrect";
        return false;
    }
    $bdd = connexion();
    $requete = $bdd->query("SELECT * FROM login WHERE username = '$username' AND password = '$password'");
    $resultat = $requete->fetch();
    if($resultat == NULL)
    {
        print "Nom d'utilisateur incorrect ou mauvais mot de passe";
    }
    else
    {
        espace($resultat);
    }
}

function espace($info)
{
    if ($info['grade'] == 'membre') {
       print "Connecté en tant que membre";
    }

    if ($info['grade'] == 'admin') {
        print "Connecté en tant que qu'admin";
     }
}
?>