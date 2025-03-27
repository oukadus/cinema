<?php
require_once("inc/functions.inc.php");
$info = "";
?>

<!-- CONTENU PHP DE LA PAGE -->
<?php

// afficher un film 
if (isset($_GET['action']) && $_GET['action'] == 'view' && !empty($_GET['id'])) {
    $idFilm = htmlspecialchars($_GET['id']);
    $film = showFilm($idFilm);
    // debug($film);
    $pageTitle = $film['title'];
    $film['title'] = html_entity_decode($film['title']);
    $film['synopsis'] = html_entity_decode($film['synopsis']);
    $film['director'] = html_entity_decode($film['director']);
    $film['actors'] = html_entity_decode($film['actors']);
    $film['category_id'] = html_entity_decode($film['category_id']);
    $film['duration'] = html_entity_decode($film['duration']);
    $film['date'] = html_entity_decode($film['date']);
    $film['price'] = html_entity_decode($film['price']);
    $film['stock'] = html_entity_decode($film['stock']);
    $film['ageLimit'] = html_entity_decode($film['ageLimit']);
    $film['image'] = html_entity_decode($film['image']);
    $film['id'] = html_entity_decode($film['id']);
    // debug($film);
} else {
    $info .= alert("Film introuvable", "danger");
}

$filmCategory = showCategory($film['category_id']);
// debug($filmCategory);

?>

<?php
require_once("inc/header.inc.php");
?>

<!-- CONTENU HTML DE LA PAGE -->
<div class="film bg-dark">
    <?= $info ?>
    <div class="back">
        <a href=""><i class="bi bi-arrow-left-circle-fill"></i></a>
    </div>
    <div class="cardDetails row mt-5">
        <h2 class="text-center mb-5"><?= $film['title'] ?></h2>
        <div class="col-12 col-xl-5 row p-5">
            <img src="<?= RACINE_SITE . "assets/img/films/" . $film['image'];  ?>" alt="Affiche du film">
            <div class="col-12 mt-5">
                <form action="store/cart.php" method="post" enctype="multipart/form-data" class="w-75 m-auto row justify-content-center p-5">
                    <!-- Dans le formulaire d'ajout au panier, ajoutez des champs cachés pour chaque information que vous souhaitez conserver du film -->
                    <input type="hidden" name="id_film" value="<?= $film['id']; ?>">
                    <select name="quantity" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                        <?php for ($i = 1; $i <= $film['stock']; $i++) : ?>
                            <option value="<?= $i; ?>"><?= $i; ?></option>
                        <?php endfor; ?>


                    </select>
                    <button class="m-auto btn btn-danger btn-lg fs-5" type="submit">Ajouter au panier</button>
                    <!-- au moment du click j'initalise une session de panier qui sera récupérer dans le fichier panier.php -->
                </form>
            </div>
        </div>
        <div class="detailsContent  col-md-7 p-5">
            <div class="container mt-5">
                <div class="row">
                    <h3 class="col-4"><span>Realisateur :</span></h3>
                    <ul class="col-8">
                        <li><?= $film['director'] ?></li>
                    </ul>
                    <hr>
                </div>
                <div class="row">
                    <h3 class="col-4"><span>Acteur :</span></h3>
                    <ul class="col-8">
                        <?php foreach (explode("/", $film['actors']) as $actor) : ?>
                            <li><?= $actor; ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <hr>
                </div>

                <!-- // si j'ai un age limite renseigné je l'affiche si non pas de div avec Àge limite : -->

                <div class="row">
                    <h3 class="col-4"><span>Àge limite :</span></h3>
                    <ul class="col-8">
                        <li>+ <?= $film['ageLimit']; ?> ans</li>
                    </ul>
                    <hr>
                </div>


            </div>
        </div>
        <div class="row">
            <h3 class="col-4"><span>Genre : </span></h3>
            <ul class="col-8">

                <li><?= $filmCategory['id']; ?></li>
            </ul>
            <hr>
        </div>
        <div class="row">
            <h3 class="col-4"><span>Durée : </span></h3>
            <ul class="col-8">
                <li><?= $film['duration']; ?></li>
            </ul>
            <hr>
        </div>
        <div class="row">
            <h3 class="col-4"><span>Date de sortie:</span></h3>
            <ul class="col-8">
                <li><?= $film['date']; ?></li>
            </ul>
            <hr>
        </div>
        <div class="row">
            <h3 class="col-4"><span>Prix : </span></h3>
            <ul class="col-8">
                <li><?= $film['price']; ?>€</li>
            </ul>
            <hr>
        </div>
        <div class="row">
            <h3 class="col-4"><span>Stock :</span> </h3>
            <ul class="col-8">
                <li><?= $film['stock']; ?></li>
            </ul>
            <hr>
        </div>
        <div class="row">

            <h5 class="col-4"><span>Synopsis :</span></h5>
            <ul class="col-8">
                <li><?= $film['synopsis']; ?></li>
            </ul>
        </div>
    </div>
</div>

<?php
require_once("inc/footer.inc.php");
?>