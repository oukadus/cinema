<?php
require_once("../inc/functions.inc.php");
$pageTitle = "- Créer un film";
// debug($_POST);
// debug($_FILES);

$regexDuration = "/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/"; // regex pour la durée du film
$regexDate = "/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/"; // regex pour la date de sortie du film
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
?>


<?php
$info = "";
// Message d'info
message();

// On verifie si un champ est vide
if (!empty($_POST)) {
    $verif = true;
    foreach ($_POST as $key => $value) {
        if (empty(trim($value))) {

            $verif = false;
        }
    }

    // alerter sur les champs vides 
    if (!$verif) {
        $info .= alert("Veuillez renseigner tous les champs", "danger");
    } else {
        // On recupere les données du formulaire
        if (!isset($_POST['title']) || strlen(trim($_POST['title'])) < 3 || strlen(trim($_POST['title'])) > 50) {
            $info .= alert("Le titre du film doit contenir entre 3 et 50 caractères", "danger");
        }

        if (!isset($_POST['director']) || strlen(trim($_POST['director'])) < 5) {
            $info .= alert("Le nom du réalisateur doit contenir au moins 5 caractères", "danger");
        }

        if (!isset($_POST['actors']) || strlen(trim($_POST['actors'])) < 5) {
            $info .= alert("Le nom des acteurs doit contenir au moins 5 caractères", "danger");
        }

        if (!isset($_POST['ageLimit']) || !is_numeric($_POST['ageLimit'])) {
            $info .= alert("Erreur sur la date du film", "danger");
        }

        if (!isset($_POST['categories'])) {
            $info .= alert("Categorie invalide", "danger");
        }

        if (!isset($_POST['duration']) || !preg_match('/[0-9]/', $_POST['duration'])) {
            $info .= alert("Format de la durée du film est invalide", "danger");
        }

        if (!isset($_POST['date']) || !preg_match($regexDate, $_POST['date'])) {
            $info .= alert("Le format de la date de sortie est invalide", "danger");
        }

        if (!isset($_POST['price']) || !preg_match('/[0-9]/', $_POST['price'])) {
            $info .= alert("Le prix doit être un nombre", "danger");
        }

        if (!isset($_POST['stock']) || !preg_match('/[0-9]/', $_POST['stock'])) {
            $info .= alert("Le stock doit être un nombre", "danger");
        }

        if (!isset($_POST['synopsis']) || strlen(trim($_POST['synopsis'])) < 5) {
            $info .= alert("Le synopsis doit contenir au moins 5 caractères", "danger");
        }

        // On verifie si l'image est valide

        if ($_FILES['image']['error'] == 4) {
            $_FILES['image']['name'] = htmlspecialchars(trim($_POST['oldImage']));
        } else {
            if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0 && $_GET['action'] != "update") {
                $info .= alert("Erreur sur l'image", "danger");
            } else {
                $extensions = ['jpg', 'jpeg', 'png', 'gif'];
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                if (!in_array($extension, $extensions)) {
                    $info .= alert("L'extension de l'image n'est pas valide", "danger");
                } elseif ($_FILES['image']['size'] > 2000000) {
                    $info .= alert("L'image est trop lourde", "danger");
                } elseif ($_FILES['image']['size'] == 0) {
                    $info .= alert("L'image est vide", "danger");
                }
            }
        }
    }

    if (empty($info)) {
        // Stocker les éléments dans des variables
        $title = htmlspecialchars(trim($_POST['title']));
        $director = htmlspecialchars(trim($_POST['director']));
        $actors = htmlspecialchars(trim($_POST['actors']));
        $ageLimit = htmlspecialchars(trim($_POST['ageLimit']));
        $categories = htmlspecialchars(trim($_POST['categories']));
        $duration = htmlspecialchars(trim($_POST['duration']));
        $date = htmlspecialchars(trim($_POST['date']));
        $price = htmlspecialchars(trim($_POST['price']));
        $stock = htmlspecialchars(trim($_POST['stock']));
        $synopsis = htmlspecialchars(trim($_POST['synopsis']));
        $image = $_FILES['image']['name'];
        $oldImage = htmlspecialchars(trim($_POST['oldImage']));

        // On verifie si le film existe
        $filmExist = filmExist($title);

        // modification du film
        if (isset($_GET['action']) && $_GET['action'] == "update") {
            if ($filmExist) {

                $idFilm = htmlspecialchars($_GET['id']);
                // on déplace l'image
                $path = "../assets/img/films/" . $image;
                move_uploaded_file($_FILES['image']['tmp_name'], $path);
                // on modifie le film
                updateFilm($title, $director, $actors, $ageLimit, $categories, $duration, $date, $price, $stock, $synopsis, $image, $idFilm);
                $alertMessage = alert("Film modifié avec succès", "success");
                $_SESSION['message'] = $alertMessage;
                header('location:films.php');
                exit;
            } else {
                $info .= alert("Le film n'existe pas", "danger");
            }
        } elseif ($filmExist) {
            $info .= alert("Le film existe déjà", "danger");
        } else {
            // On ajoute l'image
            $path = "../assets/img/films/" . $image;
            move_uploaded_file($_FILES['image']['tmp_name'], $path);
            // On ajoute le film
            addFilm($title, $director, $actors, $ageLimit, $categories, $duration, $date, $price, $stock, $synopsis, $image);


            $info .= alert("Film ajouté avec succès", "success");
        }
    }
}

// modifier le film
if (isset($_GET['action']) && isset($_GET['id'])) {
    if ($_GET['action'] == "update") {
        $id = htmlspecialchars($_GET['id']);
        $film = showFilm($id);
        if (empty($film)) {
            $info .= alert("Le film n'existe pas", "danger");
        } else {
            $title = $film['title'];
            $director = $film['director'];
            $actors = $film['actors'];
            $ageLimit = $film['ageLimit'];
            $categories = $film['category_id'];
            $duration = $film['duration'];
            $date = $film['date'];
            $price = $film['price'];
            $stock = $film['stock'];
            $synopsis = $film['synopsis'];
            $exisitingImage = $film['image'];
            $submit = "Modifier un film";
        }
    }
}



?>

<?php
require_once("../inc/header.inc.php");
?>

<!-- CONTENU HTML DE LA PAGE -->
<?php


require_once "../inc/header.inc.php";
?>

<main class="bg-dark">
    <?= $info ?>
    <h2 class="text-center fw-bolder mb-5 text-danger">Ajouter un film</h2>

    <form action="" method="post" class="back" enctype="multipart/form-data">
        <!-- il faut isérer une image pour chaque film, pour le traitement des images et des fichiers en PHP on utilise la surperglobal $_FILES -->
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="title" class="text-white">Titre de film</label>
                <input type="text" name="title" id="title" class="form-control" value="<?= $title ?? "" ?>">

            </div>
            <div class="col-md-6 mb-5">
                <label for="image" class="text-white">Affiche</label>
                <br>
                <input type="file" name="image" id="image">
                <input class="hidden" name="oldImage" value="<?= $exisitingImage ?? "not_existing_image" ?>"></input>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="director" class="text-white">Réalisateur</label>
                <input type="text" class="form-control" id="director" name="director" value="<?= $director ?? "" ?>">
            </div>
            <div class="col-md-6">
                <label for="actors" class="text-white">Acteur(s)</label>
                <input type="text" class="form-control" id="actors" name="actors" value="<?= $actors ?? "" ?>" placeholder="séparez les noms d'acteurs avec un /">
            </div>
        </div>
        <div class="row">
            <!-- raccouci bs5 select multiple -->
            <div class="mb-3">
                <label for="ageLimit" class="form-label" class="text-white">Àge limite</label>
                <select class="form-select form-select-lg" name="ageLimit" id="ageLimit">
                    <?php switch ($ageLimit) {

                        case 10:
                            echo '<option value="10" selected>10</option>';
                            break;
                        case 13:
                            echo '<option value="13" selected>13</option>';
                            break;
                        case 16:
                            echo '<option value="16" selected>16</option>';
                            break;
                        default:
                            echo '<option value="10">10</option>';
                            echo '<option value="13">13</option>';
                            echo '<option value="16">16</option>';
                    } ?>
                </select>
            </div>
        </div>
        <div class="row">
            <label for="categories">Genre du film</label>


            <?php
            $categories = allCategories('name');
            foreach ($categories as $category) : ?>
                <div class="form-check col-sm-12 col-md-4">
                    <?php if ($category['id']) : ?>
                        <input class="form-check-input" type="radio" name="categories" id="<?= $category['id'] ?>" value="<?= $category['id'] ?>" checked>
                        <label class="form-check-label" for="<?= $category['id'] ?>"><?= html_entity_decode($category['name']); ?></label>
                    <?php else : ?>
                        <input class="form-check-input" type="radio" name="categories" id="<?= $category['id'] ?>" value="<?= $category['id'] ?>">
                        <label class="form-check-label" for="<?= $category['id'] ?>"><?= html_entity_decode($category['name']); ?></label>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>


        </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="duration" class="text-white">Durée du film</label>
                <input type="time" class="form-control" id="duration" name="duration" min="01:00" value="<?= $duration ?? "" ?>">
            </div>

            <div class="col-md-6 mb-5">

                <label for="date" class="text-white">Date de sortie</label>
                <input type="date" name="date" id="date" class="form-control" value="<?= $date ?? "" ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="price" class="text-white">Prix</label>
                <div class=" input-group">
                    <input type="text" class="form-control" id="price" name="price" aria-label="Euros amount (with dot and two decimal places)" value="<?= $price ?? "" ?>">
                    <span class="input-group-text">€</span>
                </div>
            </div>

            <div class="col-md-6">
                <label for="stock" class="text-white">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" min="0" value="<?= $stock ?? "" ?>"> <!--pas de stock négativ donc je rajoute min="0"-->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label for="synopsis" class="text-white">Synopsis</label>
                <textarea type="text" class="form-control" id="synopsis" name="synopsis" rows="10"><?= $synopsis ?? "" ?></textarea>
            </div>
        </div>

        <div class="row justify-content-center">
            <button type="submit" class="btn btn-danger p-3 w-25"><?= $submit ?? "Ajouter un film" ?></button>
        </div>

    </form>

</main>
<?php

require_once "../inc/footer.inc.php";
?>