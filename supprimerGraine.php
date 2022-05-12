<?php
include("config.php");
$id = $_GET['id'];
$suppressionRequete = $connexion->prepare("DELETE FROM graines WHERE idGraines='$id'");
$suppressionRequete->execute();
header("Location:accueil.php");
