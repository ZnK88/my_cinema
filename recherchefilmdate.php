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
    <form action='recherchefilmdate.php' class='recherchefilm' method='GET'>
    <h1>Quel film passe ce soir ?</h1>
    <div class='film'>
    <label for='date'>date : </label>
    <input type='date' id='date' name='date'>
    </div>
    <button>Envoyer</button>
    </form>
    ";
    

if (isset($_GET['date'])) {
    $date = htmlspecialchars($_GET['date']);

    recherchepardate($date);
    
}
    
    function recherchepardate($date)
    {
        $bdd = connexion();
        $requete = $bdd->query("SELECT * from film WHERE '$date' >= date_debut_affiche AND '$date' <= date_fin_affiche");
        $requetecompteur = $bdd->query("SELECT count(*) from film WHERE '$date' >= date_debut_affiche AND '$date' <= date_fin_affiche");
        $compteur = $requetecompteur->fetch();
        if($compteur[0] > 0)
        {
            print "<table class='resultatrecherchepardate'>\n<tr>\n<td>Titre</td>\n<td>date de diffusion</td>\n<td>date de fin de diffusion</td>\n</tr>";
            while ($resultat = $requete->fetch()) 
            {
                print "<tr>\n<td>".$resultat['titre']."<td>".$date."<td>".$resultat['date_fin_affiche']."</tr>";
            }

            print "</table>";
        }
    }
    
    ?>