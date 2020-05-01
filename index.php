<?php
include ('connexion.php');
include ('header.php');
include ('footer.php');

addheader();
afficherliste();

if (isset($_GET['nom']) && isset($_GET['prenom'])) {
    $nom = htmlspecialchars($_GET['nom']);
    $prenom = htmlspecialchars($_GET['prenom']);

    NomPrenom($nom,$prenom);  
}

if (isset($_GET['genre']) && isset($_GET['distrib'])) {
    $genreselect = htmlspecialchars($_GET['genre']);
    $distribselect = htmlspecialchars($_GET['distrib']);

    AffichageFilm($genreselect,$distribselect);
    
}

if (isset($_GET['titre'])) {
    $titreselect = htmlspecialchars($_GET['titre']);

    affichagepartitre($titreselect);
    
}


function afficherliste()
{
    $bdd = connexion();
    $genre = $bdd->query("SELECT * from genre");
    $distrib = $bdd->query("SELECT * from distrib");

    print "<form action='index.php' class='SecondFormulaire' method='GET'>\n<div class='ZoneSelect'>\n<label for='genre'>Genre :</label>\n<select name='genre' class='genre'>\n<option value=''> </option>\n";
    while ($resultat = $genre->fetch())
    {
        $retour = $resultat['nom'];
        print "<option value='$retour'>$retour</option>\n";
    }
    print "</select>\n</div>\n<div class='ZoneSelect'>\n<label for='distrib'>distributeur :</label>\n<select name='distrib' class='distrib'>\n<option value=''> </option>\n";
    while ($resultat2 = $distrib->fetch())
    {
        $retour = $resultat2['nom'];
        print "<option value='$retour'>$retour</option>\n";
    }
    print "</select>\n</div>\n<button>Envoyer</button>\n</form>\n<form action='index.php' class='troisiemeFormulaire' method='GET'>\n<div class='saisiezone'>\n";
    print "<label for='Titre'>Titre : </label>\n";
    print "<input type='text' id='titre' name='titre'>\n</div>\n<button>Envoyer</button>\n</form>";

}

function AffichageFilm($genreselect,$distribselect)
{
    if (empty($genreselect) && empty($distribselect)) {
        return false;
    }
    // a optimisé avec des inner join si motivé 
    $distribselect = str_replace('+',' ',$distribselect);
    $genreselect = str_replace('+',' ',$genreselect);
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
        print "</table>\n"."Nombre de resultat : ".$resultatcompteur[0]."\n";
    }
    if (empty($idgenre) && !empty($iddistrib)) {
        $affichage = $bdd->query("SELECT titre,annee_prod,duree_min,resum FROM film WHERE id_distrib = '$iddistrib'");
        $compteur= $bdd->query("SELECT count(*) FROM film WHERE id_distrib = '$iddistrib'");
        $resultatcompteur = $compteur->fetch();
        while($affiche = $affichage->fetch())
        {
            print "<tr>\n<td>".$affiche['titre']."<td>".$affiche['annee_prod']."<td>".$affiche['duree_min']."<td>"."A Faire"."<td>"."A faire"."<td>".$affiche['resum']."</td></tr>";
        }
        print "</table>\n"."Nombre de resultat : ".$resultatcompteur[0]."\n";
        
    }
    if (!empty($idgenre) and !empty($iddistrib)) {
        $affichage = $bdd->query("SELECT titre,annee_prod,duree_min,resum FROM film WHERE id_genre = '$idgenre' AND id_distrib = '$iddistrib'");
        $compteur = $bdd->query("SELECT count(*) FROM film WHERE id_genre = '$idgenre' AND id_distrib = '$iddistrib'");
        $resultatcompteur = $compteur->fetch();
            while($affiche = $affichage->fetch())
            {
                print "<tr>\n<td>".$affiche['titre']."<td>".$affiche['annee_prod']."<td>".$affiche['duree_min']."<td>"."A Faire"."<td>"."A faire"."<td>".$affiche['resum']."</td></tr>";
            }
            print "</table>\n"."Nombre de resultat : ".$resultatcompteur[0]."\n";
    }
}


    function NomPrenom ($nom,$prenom)
    {
            $bdd = connexion();
            if($nom == NULL && $prenom == NULL)
            {
                print "Aucun resultat";
                addfooter();
            }
            if($nom == NULL && !empty($prenom))
            {
                $info = $bdd->query("SELECT * from fiche_personne WHERE prenom = '$prenom'");
                $compteur = $bdd->query("SELECT count(*) from fiche_personne WHERE prenom = '$prenom'");
                boucle($info,$compteur);
            }
            if(!empty($nom) && empty($prenom))
            {
                $info = $bdd->query("SELECT * from fiche_personne WHERE nom = '$nom'");
                $compteur = $bdd->query("SELECT count(*) from fiche_personne WHERE nom = '$nom'");
                boucle($info,$compteur);
            }
    
            if(!empty($nom) && !empty($prenom))
            {
                $info = $bdd->query("SELECT * from fiche_personne WHERE nom = '$nom' AND prenom = '$prenom'");
                $compteur = $bdd->query("SELECT * from fiche_personne WHERE nom = '$nom' AND prenom = '$prenom'");
                boucle($info,$compteur);
            }
    }
    
    function affichagepartitre($titreselect)
    {
        if(empty($titreselect))
        {
            return null;
        }
        print "<table>\n<tr>\n<td>Titre</td>\n<td>Année de production</td>\n<td>Durée(Minute)</td>\n
        <td>Genre</td>\n<td>Distributeur</td>\n<td>Resumé</td>\n";
        $bdd = connexion();
        $titre = $bdd->query ("SELECT * FROM film where titre LIKE '%$titreselect%'");
        while ($resultat = $titre->fetch()) {
            print "<tr>\n<td>".$resultat['titre']."<td>".$resultat['annee_prod']."<td>".$resultat['duree_min']."<td>"."A Faire"."<td>"."A faire"."<td>".$resultat['resum']."</td></tr>";
        }
    }
    
    function boucle($info,$compteur)
    {
        
        $NbrdeResultat = $compteur->fetch();
    
            if($NbrdeResultat[0] >= 1)
            {
                print "<table>\n<tr>\n<td>Nom</td>\n<td>Prénom</td>\n<td>Date de naissance</td>\n
                <td>e-mail</td>\n<td>adresse</td>\n<td>Code postal</td>\n<td>Ville</td>\n<td>Pays</td>\n<td>edition</td></tr>";
    
                while ($resultat = $info->fetch() )
                { 
                    print "<tr>\n<td>".$resultat['nom']."<td>".$resultat['prenom'].
                    "</td>\n"."<td>".$resultat['date_naissance']."</td>\n"."<td>".$resultat['email'].
                    "</td>\n"."<td>".$resultat['adresse']."</td>\n"."<td>".$resultat['cpostal']."</td>\n".
                    "<td>".$resultat['ville']."</td>\n"."<td>".$resultat['pays']."</td>\n<td><button>editer</button><button>supprimer</button></td></tr>";
                }
                print "<div>\n<p>Nombre de resultat : "."$NbrdeResultat[0]</p></div>";
            }
            else {
                echo "Aucun resultat";
            }
            
            addfooter();
    }
?>
