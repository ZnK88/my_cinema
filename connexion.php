<?php

function connexion()
{
try
    {
        $connexion = new PDO("mysql:host=localhost;dbname=cinema;charset=utf8", "root", "");
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return($connexion);
    }
catch (Exception $e)
    {
            die('Erreur : ' . $e->getMessage());
    }
}
?>