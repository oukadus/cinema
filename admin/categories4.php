<?php
require_once("../inc/functions.inc.php");
$pageTitle = "- Gestion des catégories";
// debug($_POST);
?>


<!-- CONTENU PHP DE LA PAGE -->
<?php
$info = "";
// Message d'info 
if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
    $info = $_SESSION['message'];

    unset($_SESSION['message']);
}

// redirection 
if (!isset($_SESSION['user'])) { // si la session "user" existe, rediriges vers profil.php

    header("location:" . RACINE_SITE . "auth.php");
} else {
    if ($_SESSION['user']['role'] == 'ROLE_USER') {
        header("location:" . RACINE_SITE . "profil.php");
        exit;
    }
}

if (!empty($_POST) && $_GET['action'] != "update") {
    // On verifie si un champ est vide 
    $verif = true;
    foreach ($_POST as $key => $value) {
        if (empty(trim($value))) {

            $verif = false;
        }
    }

    if ($verif === false) {
        $info .= alert("Veuillez renseigner tous les champs", "danger");
    } else {
        // On recupere les données du formulaire
        if (!isset($_POST['name']) || strlen(trim($_POST['name'])) < 3 || strlen(trim($_POST['name'])) > 50 || preg_match('/[0-9]/', $_POST['name'])) {
            $info .= alert("Le nom de la catégorie doit contenir entre 3 et 50 caractères", "danger");
        }

        if (!isset($_POST['description']) || strlen(trim($_POST['description'])) < 10 || preg_match('/[0-9]/', $_POST['description'])) {
            $info .= alert("La description de la catégorie doit contenir au moins 10 caractères", "danger");
        } elseif (empty($info)) {
            // On recupere les données du formulaire
            $name = htmlspecialchars(trim($_POST['name']));
            $description = htmlspecialchars(trim($_POST['description']));

            // on vérifie si ça existe
            $category = categoryExist($name);

            if ($category) {
                $info .= alert("La catégorie existe déjà", "danger");
            } else {
                addCategory($name, $description);
                $info .= alert("Catégorie ajoutée avec succès", "success");
            }
        }
    }
}

$categories = allCategories();

// Supprimer catégorie
if (isset($_GET['action']) && isset($_GET['id'])) {

    $idCategory = htmlspecialchars($_GET['id']);
    if (!empty($_GET['action']) && $_GET['action'] == "delete" && !empty($_GET['id'])) {
        deleteCategory($idCategory);
        $alertMessage = alert("Catégorie supprimée avec succès", "success");
        $_SESSION['message'] = $alertMessage;
        header('location:categories.php');
        exit;
    }
}

// modifier catégorie 
if (isset($_GET['action']) && isset($_GET['id'])) {
    $idCategory = htmlspecialchars($_GET['id']);
    $category = showCategory($idCategory);

    if (!empty($_GET['action']) && $_GET['action'] == "update" && !empty($_GET['id'])) {
        // fonction update 
        if (!empty($_POST)) {
            // On verifie si un champ est vide 
            $verif = true;
            foreach ($_POST as $key => $value) {
                if (empty(trim($value))) {

                    $verif = false;
                }
            }

            if ($verif === false) {
                $info .= alert("Veuillez renseigner tous les champs", "danger");
            } else {
                // On recupere les données du formulaire
                if (!isset($_POST['nameUpdate']) || strlen(trim($_POST['nameUpdate'])) < 3 || strlen(trim($_POST['nameUpdate'])) > 50 || preg_match('/[0-9]/', $_POST['nameUpdate'])) {
                    $info .= alert("Le nom de la catégorie doit contenir entre 3 et 50 caractères", "danger");
                }

                if (!isset($_POST['descriptionUpdate']) || strlen(trim($_POST['descriptionUpdate'])) < 20 || preg_match('/[0-9]/', $_POST['descriptionUpdate'])) {
                    $info .= alert("La description de la catégorie doit contenir au moins 20 caractères", "danger");
                } elseif (empty($info)) {
                    // On recupere les données du formulaire
                    $nameUpdate = htmlspecialchars(trim($_POST['nameUpdate']));
                    $descriptionUpdate = htmlspecialchars(trim($_POST['descriptionUpdate']));

                    // on vérifie si ça existe
                    $category = categoryExist($nameUpdate);

                    if (!$category) {
                        $info .= alert("La catégorie n'existe pas", "danger");
                    } else {
                        updateCategory($nameUpdate, $descriptionUpdate, $idCategory);
                        header('location:categories.php');
                        $alertMessage = alert("Catégorie modifiée avec succès", "success");
                        $_SESSION['message'] = $alertMessage;
                    }
                }
            }
        }
    }
}
?>

<?php
require_once("../inc/header.inc.php");

?>

<!-- CONTENU HTML DE LA PAGE -->
<main class="bg-dark">
    <div class="row mt-5" style="padding-top: 8rem;">
        <div class="col-sm-12 col-md-6 mt-5">
            <h2 class="text-center fw-bolder mb-5 text-danger">Gestion des catégories</h2>
            <?= $info ?>
            <!-- FORMULAIRE DE MODIFICATION  START -->
            <?php if (isset($_GET['action']) && $_GET['action'] == "update") : ?>
                <form action="" method="post" class="back" id="updateCategory">

                    <div class="row">
                        <div class="col-md-8 mb-5">
                            <label for="name" class="text-white">Nom de la catégorie</label>

                            <input type="text" id="name" name="nameUpdate" class="form-control" value="<?= html_entity_decode($category['name']); ?>">

                        </div>
                        <div class="col-md-12 mb-5">
                            <label for="description" class="text-white">Description</label>
                            <textarea id="description" name="descriptionUpdate" class="form-control" rows="10"><?= html_entity_decode($category['description']); ?></textarea>
                        </div>

                    </div>
                    <div class="row justify-content-center">
                        <button type="submit" class="btn btn-danger p-3">Modifier</button>
                    </div>
                </form>

                <!-- FORMULAIRE DE MODIFICATION  END -->

            <?php else : ?>

                <!-- FORMULAIRE D'AJOUT  START -->

                <form action="" method="post" class="back">

                    <div class="row">
                        <div class="col-md-8 mb-5">
                            <label for="name" class="text-white">Nom de la catégorie</label>

                            <input type="text" id="name" name="name" class="form-control" value="">

                        </div>
                        <div class="col-md-12 mb-5">
                            <label for="description" class="text-white">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="10"></textarea>
                        </div>

                    </div>
                    <div class="row justify-content-center">
                        <button type="submit" class="btn btn-danger p-3">Submit</button>
                    </div>
                </form>
                <!-- FORMULAIRE D'AJOUT  END -->

            <?php endif; ?>
        </div>



        <div class="col-sm-12 col-md-6 d-flex flex-column mt-5 pe-3">

            <h2 class="text-center fw-bolder mb-5 text-danger">Liste des catégories</h2>


            <table class="table table-dark table-bordered mt-5 ">
                <thead>
                    <tr>
                        <!-- th*7 -->
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Supprimer</th>
                        <th>Modifier</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category) : ?>
                        <tr>
                            <td><?= $category['id'] ?></td>
                            <td><?= html_entity_decode($category['name']) ?></td>
                            <td><?= html_entity_decode($category['description']) ?></td>
                            <td class="text-center">
                                <i class="bi bi-trash3" onclick="confirmDelete(<?= $category['id'] ?>)"></i>
                                <a href="categories.php?action=delete&id=<?= $category['id']; ?>" class="user-action delete-<?= $category['id'] ?> d-none">
                                    <i class="bi bi-check-lg text-danger"></i>
                                </a>
                            </td>
                            <td class="text-center"><a href="categories.php?action=update&id=<?= $category['id']; ?>"><i class="bi bi-pen-fill"></i></a></td>
                        </tr>
                    <?php endforeach; ?>


                </tbody>

            </table>

        </div>

        <?php require_once("../inc/footer.inc.php"); ?>