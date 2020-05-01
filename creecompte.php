<?php
include ('connexion.php');
if (isset($_GET['username']) && isset($_GET['password'])) {
    if(isset($_GET['typeaccount']))
    {
        $username = htmlspecialchars($_GET['username']);
        $password = htmlspecialchars($_GET['password']);
        $grade = htmlspecialchars($_GET['typeaccount']);
    
        creecompte($username,$password,$grade);
    }
    else {
        # code...
        $username = htmlspecialchars($_GET['username']);
        $password = htmlspecialchars($_GET['password']);
    
        creecompte($username,$password);
    }
    
}
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
    <form action='creecompte.php' class='test' method='GET'>
        <h1>Creation de compte</h1>
        <div class='test'>
            <label for='name'>Nom : </label>
            <input type='text' id='nom' name='nom' disabled>
            <label for='prenom'>prenom : </label>
            <input type='text' id='prenom' name='prenom' disabled>
            <label for='email'>e-mail: </label>
            <input type='text' id='email' name='email' disabled>
            <label for='username'>Nom d'utilisateur</label>
            <input type='text' id='username' name='username' required>
            <label for='password'>Mot de passe</label>
            <input type='password' id='password' name='password' required>
            <label for='typeaccount'>compte administrateur ?</label>
            <input type='checkbox' id='scales' name='typeaccount'>
        </div>
        <button>Envoyer</button>
    </form>
";

function creecompte ($username,$password,$grade = NULL)
{

 $bdd = connexion();
 $requeteverification = $bdd->query("SELECT username FROM login where username = '$username'");
 $verification = $requeteverification->fetch();

    if ($verification == true) {
        print "Ce compte existe Deja";
        return false;
    }
    else
    {
        if ($grade == 'on') {
            $grade = 'admin';
            $bdd->exec("INSERT INTO `login` (`id_login`, `username`, `password`, `grade`) VALUES (NULL, '$username', '$password', 'admin')");
        }
        if ($grade == NULL)
        {
            $bdd->exec("INSERT INTO `login` (`id_login`, `username`, `password`, `grade`) VALUES (NULL, '$username', '$password', 'membre')");
        }
        print "compte crée";
    }


}   
?>
