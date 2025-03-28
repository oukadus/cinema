<?php
require_once '../inc/functions.inc.php';
$pageTitle = "Opération réussie";
require_once '../inc/header.inc.php';


$id_user  = $_SESSION['user']['id_user'];
$price = $_GET['total'];
$dateAchat = date('Y-m-d H:i:s');
$result = addOrder($id_user, $price, $dateAchat, 1);

$orderId = lastId();

if ($result) {
    foreach ($_SESSION['cart'] as $value) {
        addOrderDetails($orderId['lastId'], $value['id_film'], $value['quantity'], $value['price']);
        reduceStock($value['id_film'], $value['quantity']);
    }
    unset($_SESSION['cart']);
}


?>



<main class="bg-dark">
    <?php debug($_GET['total']); ?>

    <div class="w-25 m-auto  d-flex flex-column align-item-center">
        <p class="alert alert-success text-center ">Votre achat est bien effectué </p>
        <a href="<?= RACINE_SITE ?>profil.php" class="btn text-center">Suivre ma commande </a>
    </div>

</main>