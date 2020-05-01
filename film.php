<?php

include ('connexion.php');
include ('header.php');
include ('footer.php');


if (isset($_GET['genre']) && isset($_GET['distrib'])) {
    $genreselect = htmlspecialchars($_GET['genre']);
    $distribselect = htmlspecialchars($_GET['distrib']);

    AffichageFilm($genreselect,$distribselect);
    
}


function afficherliste()
{
    $bdd = connexion();
    $genre = $bdd->query("SELECT * from genre");
    $distrib = $bdd->query("SELECT * from distrib");

    print "<form action='film.php' class='SecondFormulaire' method='GET'>\n";
    print "<div class='ZoneSelect'>\n";
    print "<label for='genre'>Genre :</label>\n";
    print "<select name='genre' class='genre'>\n";
    print "<option value=''> </option>\n";

    while ($resultat = $genre->fetch())
    {
        $retour = $resultat['nom'];
        print "<option value='$retour'>$retour</option>\n";
    }
    print "</select>\n";
    print "</div>\n";
    print "<div class='ZoneSelect'>\n";
    print "<label for='distrib'>distributeur :</label>\n";
    print "<select name='distrib' class='distrib'>\n";
    print "<option value=''> </option>\n";
    while ($resultat2 = $distrib->fetch())
    {
        $retour = $resultat2['nom'];
        print "<option value='$retour'>$retour</option>\n";
    }
    print "</select>\n";
    print "</div>\n";
    print "<button>Envoyer</button>\n";
    print "</form>\n";
    addfooter();

}
function AffichageFilm($genreselect,$distribselect)
{
    //faire gestion d'erreur ou de 1 var defini
    if (empty($genreselect) && empty($distribselect)) {
        return false;
    }
    // a optimisé avec des inner join si motivé 
    $distribselect = str_replace('+',' ',$distribselect);
    $bdd = connexion();
    $request = $bdd->query("SELECT id_genre FROM genre WHERE nom = '$genreselect'");
    $request2 = $bdd->query("SELECT id_distrib FROM distrib WHERE nom = '$distribselect'");
    $result = $request->fetch();
    $result2 = $request2->fetch();
    $idgenre = $result['id_genre'];
    $iddistrib = $result2['id_distrib'];
    print "<table>\n<tr>\n<td>Titre</td>\n<td>Année de production</td>\n<td>Durée(Minute)</td>\n
    <td>Genre</td>\n<td>Distributeur</td>\n<td>Resumé</td>\n";
    if (!empty($idgenre) && empty($iddistrib)) {
        $affichage = $bdd->query("SELECT titre,annee_prod,duree_min,resum FROM film WHERE id_genre = '$idgenre'");
        $compteur = $bdd->query("SELECT count(*) FROM film WHERE id_genre = '$idgenre'");
        $resultatcompteur = $compteur->fetch();
        while($affiche = $affichage->fetch())
        {
            print "<tr>\n<td>".$affiche['titre']."<td>".$affiche['annee_prod']."<td>".$affiche['duree_min']."<td>"."A Faire"."<td>"."A faire"."<td>".$affiche['resum']."</td></tr>";
        }
        print "</table>\n";
        print $resultatcompteur[0]."\n";
    }
    if (empty($idgenre) && !empty($iddistrib)) {
        $affichage = $bdd->query("SELECT titre,annee_prod,duree_min,resum FROM film WHERE id_distrib = '$iddistrib'");
        $compteur = $bdd->query("SELECT titre,annee_prod,duree_min,resum FROM film WHERE id_distrib = '$iddistrib'");
        while($affiche = $affichage->fetch())
        {
            print "<tr>\n<td>".$affiche['titre']."<td>".$affiche['annee_prod']."<td>".$affiche['duree_min']."<td>"."A Faire"."<td>"."A faire"."<td>".$affiche['resum']."</td></tr>";
        }
        
    }
    if (!empty($idgenre && !empty($iddistrib))) {
        $affichage = $bdd->query("SELECT titre,annee_prod,duree_min,resum FROM film WHERE id_genre = '$idgenre' AND id_distrib = '$iddistrib'");
        $compteur = $bdd->query("SELECT titre,annee_prod,duree_min,resum FROM film WHERE id_genre = '$idgenre' AND id_distrib = '$iddistrib'");
        $resultatcompteur = $compteur->fetch();
        while($affiche = $affichage->fetch())
        {
            print "<tr>\n<td>".$affiche['titre']."<td>".$affiche['annee_prod']."<td>".$affiche['duree_min']."<td>"."A Faire"."<td>"."A faire"."<td>".$affiche['resum']."</td></tr>";
        }

        print $resultatcompteur[0];
    }


}
afficherliste();

?>