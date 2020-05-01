<?php
include ('connexion.php');
include ('header.php');
include ('footer.php');

if (isset($_GET['nom']) && isset($_GET['prenom'])) {
    $nom = htmlspecialchars($_GET['nom']);
    $prenom = htmlspecialchars($_GET['prenom']);

    NomPrenom($nom,$prenom);
    
}


function NomPrenom ($nom,$prenom)
{
        $bdd = connexion();
        if($nom == NULL && $prenom == NULL)
        {
            addheader();
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


function boucle($info,$compteur)
{
    addheader();
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

}
?>
