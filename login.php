<?php
include_once("config.php");

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>

<body>
    <div>
        <form action="" method="POST">
            <label type=>Nom d'utilisateur : </label>
            <input type="text" name="username"><br>
            <label for="">Mot de passe : </label>
            <input type="password" name="motDePasse"><br>
            <input type="submit" name="connexion" value="Se connecter">
        </form>
    </div>

    <?php
    if (isset($_POST['connexion'])) {
        include_once("config.php");
        $username = $_POST['username'];
        $motDePasse = md5($_POST['motDePasse']);


        $compteRequete = $connexion->prepare("SELECT * FROM account WHERE username='$username' AND password='$motDePasse'");
        $compteRequete->execute();
        $compte = $compteRequete->fetch();
        if ($compte) {
            header("Location:accueil.php");
            session_start();
            $_SESSION['role'] = $compte['role'];
            $_SESSION['username'] = $compte['username'];
        } else {
            echo "Mot de passe ou username invalide";
        }
    }
    ?>
</body>

</html>