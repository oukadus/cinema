<?php
require_once("../inc/functions.inc.php");
$pageTitle = "Films";

?>


<!-- CONTENU PHP DE LA PAGE -->
<?php
// redirection 
if (!isset($_SESSION['user'])) { // si la session "user" existe, rediriges vers profil.php

    header("location:" . RACINE_SITE . "auth.php");
} else {
    if ($_SESSION['user']['role'] == 'ROLE_USER') {
        header("location:" . RACINE_SITE . "profil.php");
        exit;
    }
}

message();
$info = "";

$films = allFilms(); // on recupere tous les films
// debug($films);
// on recupere la categorie


?>

<?php
require_once("../inc/header.inc.php");
?>

<!-- CONTENU HTML DE LA PAGE -->
<?php



require_once "../inc/header.inc.php";
?>

<main class="bg-dark">
    <div class="d-flex flex-column m-auto mt-5">
        <?= $info ?>
        <h2 class="text-center fw-bolder mb-5 text-danger">Liste des films</h2>
        <a href="filmForm.php" class="btn align-self-end"> Ajouter un film</a>
        <table class="table table-dark table-bordered mt-5 ">
            <thea>
                <tr>
                    <!-- th*7 -->
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Affiche</th>
                    <th>Réalisateur</th>
                    <th>Acteurs</th>
                    <th>Àge limite</th>
                    <th>Genre</th>
                    <th>Durée</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Synopsis</th>
                    <th>Date de sortie</th>
                    <th>Supprimer</th>
                    <th> Modifier</th>
                </tr>
            </thea>
            <tbody>
                <?php
                foreach ($films as $film) : ?>

                    <tr>
                        </td>
                        <td><?= $film['id']; ?></td>
                        <td><?= html_entity_decode($film['title']); ?></td>
                        <td><img src="<?= RACINE_SITE . "assets/img/films/" . $film['image']; ?>" alt="affiche du film" class="img-fluid"></td>
                        <td><?= $film['director']; ?></td>
                        <td>
                            <ul>
                                <?php foreach (explode("/", $film['actors']) as $actor) : ?>
                                    <li class="fs-3"><?= $actor; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td><?= $film['ageLimit']; ?></td>
                        <td><?php
                            $category = showCategory($film['category_id']);
                            echo $category['name'];
                            ?></td>
                        <td><?= $film['duration']; ?></td>
                        <td><?= $film['price']; ?> €</td>
                        <td><?= $film['stock']; ?></td>
                        <td><?= html_entity_decode($film['synopsis']); ?></td>
                        <td><?= $film['date']; ?></td>


                        <td class="text-center"><a href=""><i class="bi bi-trash3-fill"></i></a></td>
                        <td class="text-center"><a href="filmForm.php?action=update&id=<?= $film['id']; ?>"><i class="bi bi-pen-fill"></i></a></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>


        </table>


    </div>
    <?php

    require_once "../inc/footer.inc.php";
    ?>




    <?php
    require_once("../inc/footer.inc.php");
    ?>