<?php
require_once("inc/functions.inc.php");
$pageTitle = "- Profil";
?>


<!-- CONTENU PHP DE LA PAGE -->
<?php

// redirection 
if (!isset($_SESSION['user'])) { // si la session "user" existe, rediriges vers profil.php

    header("location:" . RACINE_SITE . "auth.php");
} else {
    $user = $_SESSION['user'];
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $idUser = htmlspecialchars($_GET['id']);
    $user = showUser($idUser);

    if (!empty($_GET['action']) && $_GET['action'] == "update" && !empty($_GET['id'])) {
    }
}


?>

<?php
require_once("inc/header.inc.php");
?>

<!-- CONTENU HTML DE LA PAGE -->
<main class="bg-dark">
    <div class="mx-auto p-2 row flex-column align-items-center">
        <h2 class="text-center mb-5">Bonjour, <?= $user['pseudo']; ?> </h2>

        <?php ?>
        <div class="cardFilm">
            <div class="image">
                <?php

                if ($user['civility'] === "h") {
                    echo "<img src=\"" .  RACINE_SITE . "assets/img/male.png\" alt=\"Image avatar de l'utilisateur\">";
                } else {
                    echo "<img src=\"" .  RACINE_SITE . "assets/img/femal.png\" alt=\"Image avatar de l'utilisateur\">";
                }

                ?>



                <div class="details">
                    <div class="center ">

                        <table class="table">
                            <tr>
                                <th scope="row" class="fw-bold">Nom</th>
                                <td><?= $user['lastName']; ?></td>

                            </tr>
                            <tr>
                                <th scope="row" class="fw-bold">Prenom</th>
                                <td><?= $user['firstName']; ?></td>

                            </tr>
                            <tr>
                                <th scope="row" class="fw-bold">Pseudo</th>
                                <td colspan="2"><?= $user['pseudo']; ?></td>

                            </tr>
                            <tr>
                                <th scope="row" class="fw-bold">email</th>
                                <td colspan="2"><?= $user['email']; ?></td>

                            </tr>
                            <tr>
                                <th scope="row" class="fw-bold">Tel</th>
                                <td colspan="2"><?= $user['phone']; ?></td>

                            </tr>
                            <tr>
                                <th scope="row" class="fw-bold">Adresse</th>
                                <td colspan="2"><?php echo $user['address'] . ", " . $user['zip'] . ". " . $user['city'] . "<br>" . $user['country']; ?></td>

                            </tr>

                        </table>
                        <a href="profil.php?action=update&id=<?= $user['id']; ?>" class="btn mt-5">Modifier vos informations</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
require_once("inc/footer.inc.php");
?>