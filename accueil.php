<?php
//Ici j'inclus ma connexion à PDO
include_once("config.php");
session_start();
echo "Bonjour vous êtes connecté en tant que ", $_SESSION['role'], ": ", $_SESSION['username'];
if ($_SESSION['role'] != "Administrateur") {
    header("Location:login.php");
}
//Ici j'effectue ma requete qui me permet de récupérer toutes mes graines
$listeGraineRequete = $connexion->prepare("SELECT * FROM graines");
$listeGraineRequete->execute();
//Ici je recupere toutes mes lignes
$listeGraine = $listeGraineRequete->fetchAll();
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>

<body>
    <h1>Liste des semences</h1>
    <table>
        <tr>
            <td>Nom</td>
            <td>Famille</td>
            <td>Periode plantation</td>
            <td>Periode recolte</td>
            <td>Conseil jardinage</td>
            <td>Quantité en stock</td>
            <td>Image de la graine</td>
        </tr>

        <?php
        $res = [];
        foreach ($listeGraine as $res) {
            echo "<tr><td>", $res['nom'], "</td>";
            echo "<td>", $res['famille'], "</td>";
            echo "<td>", $res['periodePlantation'], "</td>";
            echo "<td>", $res['periodeRecolte'], "</td>";
            echo "<td>", $res['conseilJardinage'], "</td>";
            echo "<td>", $res['quantiteStock'], "</td>";
            echo "<td>", "<img height='60px' width='60px' src='", $res['lienVisuel'], "' alt='Image de la graine'>", "</td>";
            echo "<td><a href=\"supprimerGraine.php?id=$res[idGraines]\">Supprimer</a></td></tr>";
        }
        ?>
    </table>
    <a href="exportationCSV.php">Exporter au format CSV</a>

    <h1>Ajouter une semence : </h1>
    <form action="" method="post">
        <label for="">Nom semence : </label>
        <input type="text" name="name"><br>
        <label for="">Insérer une famille : </label>
        <input type="text" name="family"><br>
        <label for="">Période de plantation : </label>
        <select name="planting" id="">
            <option value="Ete">Eté</option>
            <option value="Printemps">Printemps</option>
            <option value="Automne">Automne</option>
            <option value="Hiver">Hiver</option>
        </select><br>
        <label for="">Période de récolte : </label>
        <select name="harvest" id="">
            <option value="Ete">Eté</option>
            <option value="Printemps">Printemps</option>
            <option value="Automne">Automne</option>
            <option value="Hiver">Hiver</option>
        </select><br>
        <label for="">Conseil jardinage</label>
        <input type="text" name="advice"><br>
        <label for="">Quantité en stock : </label>
        <input type="number" min="0" name="quantity"><br>
        <label for="">Insérer un lien de l'image de la graine</label>
        <input type="text" name="link"><br>
        <input type="submit" name="ajouterSemence" value="Ajouter">
    </form>

    <?php
    if (isset($_POST['ajouterSemence'])) {
        $name = addslashes($_POST['name']);
        $family = addslashes($_POST['family']);
        $planting =  $_POST['planting'];
        $harvest = $_POST['harvest'];
        $advice = addslashes($_POST['advice']);
        $quantity = $_POST['quantity'];
        $link = addslashes($_POST['link']);
        $ajouterRequete = $connexion->prepare("INSERT INTO graines(nom,famille,periodeplantation,perioderecolte,conseiljardinage,quantitestock,lienvisuel) VALUES('$name','$family','$planting','$harvest','$advice','$quantity','$link')");
        $ajouterRequete->execute();
        echo "La semence a bien été ajoutée.";
    }

    // Partie requête pour grouper le nom des semences par periode de plantation
    $periodeRequete = $connexion->prepare("SELECT periodePlantation, GROUP_CONCAT(nom) AS 'Groupement' FROM graines
    GROUP BY periodePlantation");
    $periodeRequete->execute();
    $periode = $periodeRequete->fetchAll();

    ?>

    <h2>Calendrier de plantation : </h2>
    <table>
        <tr>
            <td>Période</td>
            <td>Nom</td>
        </tr>
        <?php
        foreach ($periode as $res) {
            echo "<tr><td>", $res['periodePlantation'], "</td>";
            echo "<td>", $res['Groupement'], "</td></tr>";
        }
        ?>
    </table>
</body>

</html>