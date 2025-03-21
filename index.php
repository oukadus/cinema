<?php
require_once("inc/functions.inc.php");
$pageTitle = "- Accueil";

switch ($_GET['action']) {
    case 'viewAll':
        $films = allFilms('title'); // on recupere tous les films
        $nbFilms = count($films); // on compte le nombre de films
        $showButton = "Afficher les derniers films";
        $showTitle = "Tous les films";
        $showUrl = "index.php";
        break;
    case 'showCategory':
        $catId = htmlspecialchars($_GET['id']);
        $films = getFilmsByCategory($catId);
        $category = showCategory($catId);
        // on recupere tous les films
        $nbFilms = count($films); // on compte le nombre de films
        $showButton = "Afficher tous les films";
        $showTitle = $category['name'];
        $showUrl = "index.php?action=viewAll";

        break;
    default:
        $films = getLastFilms(); // on recupere tous les films
        $nbFilms = count($films); // on compte le nombre de films
        $showButton = "Afficher tous les films";
        $showTitle = "Nos derniers films";
        $showUrl = "index.php?action=viewAll";

        break;
}
?>

<!-- CONTENU PHP DE LA PAGE -->

<?php
require_once("inc/header.inc.php");
?>

<!-- CONTENU HTML DE LA PAGE -->
<main class="bg-dark">
    <div class="films">
        <h2 class="fw-bolder fs-1 mx-5 text-center"><?= $showTitle . "(" . $nbFilms . ")"; ?></h2> <!-- Affiche le message et le nombre de films -->

        <div class="row">
            <!-- Affiche les films -->
            <?php foreach ($films as $film) : ?>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xxl-3">
                    <div class="card">
                        <img src="<?= RACINE_SITE . "assets/img/films/" . $film['image'];  ?>" alt="image du film"> <!-- Affiche l'image du film -->
                        <div class="card-body">
                            <h3><?= $film['title'] ?></h3> <!-- Affiche le titre du film -->
                            <h4><?= $film['director'] ?></h4> <!-- Affiche le réalisateur du film -->
                            <p><span class="fw-bolder">Résumé:</span> <?= html_entity_decode(substr($film['synopsis'], 0, 100) . "...") ?></p> <!-- Affiche un résumé du film -->
                            <a href="<?= RACINE_SITE . "showFilm.php?action=view&id=" . $film['id'] ?>" class="btn">Voir plus</a> <!-- Lien pour voir plus de détails -->
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="col-12 text-center">

            <a href="<?= $showUrl; ?>" class="btn p-4 fs-3"><?= $showButton; ?></a>

        </div>
    </div>


    <?php
    require_once("inc/footer.inc.php");
    ?>