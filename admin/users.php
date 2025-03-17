<?php
require_once("../inc/functions.inc.php");
$pageTitle = "- Gestion des utilisateurs";

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

$users = allUsers();
// debug($users)
// debug($users);

if (isset($_GET['action']) && isset($_GET['id'])) {

    $idUser = htmlspecialchars($_GET['id']);
    $user = showUser($idUser);


    if (!empty($_GET['action']) && $_GET['action'] == "update" && !empty($_GET['id'])) {
        // fonction update 

        if ($user['role'] == "ROLE_ADMIN") {
            // change en admin
            updateRole("ROLE_USER", $idUser);
        } else {
            updateRole("ROLE_ADMIN", $idUser);
        }
        $alertMessage = alert("Droits d'utilisateur modifiés avec succés", "success");
    }

    if (!empty($_GET['action']) && $_GET['action'] == "delete" && !empty($_GET['id'])) {
        if ($user['role'] !== "ROLE_ADMIN") {
            // fonction suppression
            deleteUser($idUser);
            $alertMessage = alert("Utilisateur supprimé avec succés", "success");
        } else {
            $alertMessage = alert("Vous ne pouvez pas supprimer un administrateur", "warning");
        }
    }
    $_SESSION['message'] = $alertMessage;
    header('location:users.php');
    exit;
}

?>

<?php
require_once("../inc/header.inc.php");
?>

<!-- CONTENU HTML DE LA PAGE -->
<main class="bg-dark">
    <div class="d-flex flex-column m-auto mt-5 table-responsive">
        <!-- tableau pour afficher toutles films avec des boutons de suppression et de modification -->

        <h2 class="text-center fw-bolder mb-5 text-danger">Liste des utilisateurs</h2>
        <table class="table  table-dark table-bordered mt-5">
            <thead>
                <tr>
                    <!-- th*7 -->
                    <th>ID</th>
                    <th>FirstName</th>
                    <th>LastName</th>
                    <th>Pseudo</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Civility</th>
                    <th>Address</th>
                    <th>Zip</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Rôle</th>
                    <th>Supprimer</th>
                    <th>Modifier Le rôle</th>
                </tr>
            </thead>
            <tbody>
                <?= $info; ?>
                <?php
                foreach ($users as $user) { ?>
                    <tr>
                        <!-- il faut utiliser la fonction html_entity_decode() sur les valeur récupérer -->
                        <td><?= $user['id']; ?></td>
                        <td><?= ucfirst($user['firstName']); ?></td><!-- une majuscule sur la prmère lettre-->
                        <td><?= ucfirst($user['lastName']); ?></td>
                        <td><?= $user['pseudo']; ?></td>
                        <td><?= $user['email']; ?></td>
                        <td><?= $user['phone']; ?></td>
                        <td><?= $user['civility']; ?></td>
                        <td><?= $user['address']; ?></td>
                        <td><?= $user['zip']; ?></td>
                        <td><?= $user['city']; ?></td>
                        <td><?= $user['country']; ?></td>
                        <td><?= $user['role']; ?></td>

                        <td class="text-center">
                            <i class="bi bi-trash3" onclick="confirmDelete(<?= $user['id'] ?>)"></i>
                            <a href="users.php?action=delete&id=<?= $user['id']; ?>" class="user-action delete-<?= $user['id'] ?> d-none"><i class="bi bi-check-lg text-danger"></i></a>
                        </td>
                        <td class="text-center"><a href="users.php?action=update&id=<?= $user['id']; ?>" class="btn btn-danger"><?= ($user['role'] === "ROLE_ADMIN") ? 'Rôle_user' : 'Rôle_admin' ?></a></td>

                    </tr>

                <?php }
                ?>



            </tbody>
        </table>

        <!-- Ajout de la modal de suppression d'utilisateur  -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark">Suppression de compte</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-dark">
                        <p>Voulez-vous confirmer la suppression de </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" value="users.php?action=delete&id=">Confirmer</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php
    require_once("../inc/footer.inc.php");
    ?>