<?php
include_once("config.php");
$csvRequete = $connexion->prepare("SELECT * FROM graines");
$csvRequete->execute();
$csv = $csvRequete->fetchAll();

ini_set('memory_limit', '512M');
header("content-type: application/octet-stream");
header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename=ListeSemences.csv");
flush();

$fp = fopen('php://output', 'w');
if ($fp === false)
    die();

foreach ($csv as $liste) {
    fputcsv($fp, $liste);
}

fclose($fp);
