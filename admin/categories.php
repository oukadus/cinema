<?php
require_once("../inc/functions.inc.php");
$pageTitle = "- Gestion des catégories";
// debug($_POST);
?>


<!-- CONTENU PHP DE LA PAGE -->
<?php
$info = "";
// Message d'info 
message();

// redirection 
if (!isset($_SESSION['user'])) { // si la session "user" existe, rediriges vers profil.php

    header("location:" . RACINE_SITE . "auth.php");
} else {
    if ($_SESSION['user']['role'] == 'ROLE_USER') {
        header("location:" . RACINE_SITE . "profil.php");
        exit;
    }
}

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
        if (!isset($_POST['name']) || strlen(trim($_POST['name'])) < 3 || strlen(trim($_POST['name'])) > 50 || preg_match('/[0-9]/', $_POST['name'])) {
            $info .= alert("Le nom de la catégorie doit contenir entre 3 et 50 caractères", "danger");
        }

        if (!isset($_POST['description']) || strlen(trim($_POST['description'])) < 5 || preg_match('/[0-9]/', $_POST['description'])) {
            $info .= alert("La description de la catégorie doit contenir au moins 5 caractères", "danger");
        }

        if (empty($info)) {
            // On recupere les données du formulaire
            $name = htmlspecialchars(trim($_POST['name']));
            $description = htmlspecialchars(trim($_POST['description']));

            // on vérifie si ça existe
            $category = categoryExist($name);

            if (isset($_GET['action']) && $_GET['action'] == "update") {
                if ($category) {
                    $idCategory = htmlspecialchars($_GET['id']);
                    updateCategory($name, $description, $idCategory);
                    $alertMessage .= alert("Catégorie modifiée avec succès", "success");
                    $_SESSION['message'] = $alertMessage;
                    header('location:categories.php');
                    exit;
                } else {
                    $info .= alert("La catégorie n'existe pas", "danger");
                }
            } elseif ($category) {
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
if (isset($_GET['action']) && isset($_GET['id']) && !empty($_GET['id'])) {
    $idCategory = htmlspecialchars($_GET['id']);
    $categoryUpdate = showCategory($idCategory);
    $categoryUpdate['name'] = html_entity_decode($categoryUpdate['name']);
    $categoryUpdate['description'] = html_entity_decode($categoryUpdate['description']);
    $submitUpdate = "Modifier";
    // debug($category);

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
            <!-- FORMULAIRE D'AJOUT  START -->

            <form action="" method="post" class="back">

                <div class="row">
                    <div class="col-md-8 mb-5">
                        <label for="name" class="text-white">Nom de la catégorie</label>

                        <input type="text" id="name" name="name" class="form-control" value="<?= $categoryUpdate['name'] ?? "" ?>">

                    </div>
                    <div class="col-md-12 mb-5">
                        <label for="description" class="text-white">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="10"><?= $categoryUpdate['description'] ?? "" ?></textarea>
                    </div>

                </div>
                <div class="row justify-content-center">
                    <button type="submit" class="btn btn-danger p-3"><?= $submitUpdate ?? "Ajouter" ?></button>
                </div>

            </form>
            <!-- FORMULAIRE D'AJOUT  END -->
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
                                <a href="categories.php?action=delete&id=<?= $category['id']; ?>" onclick="return(confirm('Êtes-vous sûr de vouloir supprimer cette categorie ?'))">
                                    <i class="bi bi-trash3 text-danger"></i>
                                </a>
                            </td>
                            <td class="text-center"><a href="categories.php?action=update&id=<?= $category['id']; ?>"><i class="bi bi-pen-fill"></i></a></td>
                        </tr>
                    <?php endforeach; ?>


                </tbody>

            </table>

        </div>

        <?php require_once("../inc/footer.inc.php"); ?>