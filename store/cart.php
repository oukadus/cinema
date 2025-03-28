<?php
require_once "../inc/functions.inc.php";
$pageTitle = "Panier";



$total = 0;
if (empty($_SESSION['user'])) {

    header("location:" . RACINE_SITE . "auth.php");
}


if (isset($_POST) && !empty($_POST)) {

    $idFilm = htmlspecialchars($_POST['id_film']);
    $film = showfilm($idFilm);
    $quantity = htmlspecialchars($_POST['quantity']);

    $title = $film['title'];
    $price =  $film['price'];
    $stock =  $film['stock'];
    $image =  $film['image'];

    if ($idFilm != $film['id'] || !isset($quantity) || empty($quantity) ||  $quantity > $stock) {

        header("location:" . RACINE_SITE . "index.php");
    } else {


        if (!isset($_SESSION['cart'])) { // je vérifie si je n'ai pas de film dans le panier donc j'initialise  le panier : s'il n'existe pas une session avec l'index "panier" on en créer une et on mets un tableau à l'intérieur
            $_SESSION['cart'] = array();
        }
        // si la session avec l'index "panier" existe on passe directement à la vérification du film


        // si le film existe dans le panier
        $filmNotExiste = false;

        foreach ($_SESSION['cart'] as $key => $value) {

            // $_SESSION['cart'] => film 1 =>les informations: id / titre / image
            if ($value['id_film'] == $idFilm) {



                $_SESSION['cart'][$key]['quantity'] += $quantite;
                //-------- film n°1 ------ : quantité = quantité initiale + la nouvelle quantité
                $filmNotExiste = true;
                break;
            }
        }

        // si le film n'existe pas dans le Panier

        if ($filmNotExiste == false) { // si le film n'existe pas dans le panier
            $newFilm = [
                'id_film' => $idFilm,
                'quantity' => $quantite,
                'title' => $title,
                'price' => $price,
                'stock' => $stock,
                'image' => $image

            ];
            $newFilm['subtotal'] = $newFilm['quantity'] * $newFilm['price'];
            $_SESSION['cart'][] = $newFilm; // j'ajoute le film avec toutes ses information dans $_SESSION['cart']

        }
    }
}
if (isset($_GET['action']) && $_GET['action'] == 'clear') {

    unset($_SESSION['cart']);
}
if (isset($_GET['id'])) {

    $idFilmForDelete = htmlspecialchars($_GET['id_film']);
    foreach ($_SESSION['cart'] as $key => $film) {

        if ($film['id_film'] == $idFilmForDelete) {
            unset($_SESSION['cart'][$key]);
        }
    }
}







require_once "../inc/header.inc.php";
?>


<main class="bg-dark">
    <div class="panier d-flex justify-content-center" style="padding-top:8rem;">


        <div class="d-flex flex-column  mt-5 p-5">
            <h2 class="text-center fw-bolder mb-5 text-danger">Mon panier</h2>

            <!-- le paramètre vider=1 pour indiquer qu'il faut vider le panier. -->
            <?php
            $info = '';

            if (empty($_SESSION['cart'])) {

                echo $info = alert('votre panier est vide', 'warning');
            } else {


            ?>
                <a href="?action=clear" class="btn align-self-end mb-5">Vider le panier</a>

                <table class="fs-4">
                    <tr>
                        <th class="text-center text-danger fw-bolder">Affiche</th>
                        <th class="text-center text-danger fw-bolder">Nom</th>
                        <th class="text-center text-danger fw-bolder">Prix</th>
                        <th class="text-center text-danger fw-bolder">Quantité</th>
                        <th class="text-center text-danger fw-bolder">Sous-total</th>
                        <th class="text-center text-danger fw-bolder">Supprimer</th>
                    </tr>

                    <?php

                    foreach ($_SESSION['cart']  as $filmDansPanier) {
                        $total += $filmDansPanier['subtotal'];


                    ?>
                        <tr>
                            <td class="text-center border-top border-dark-subtle"><a href="<?= RACINE_SITE ?>showFilm.php?id=<?= $filmDansPanier['id_film'] ?>"><img src="<?= RACINE_SITE ?>assets/img/films/<?= $filmDansPanier['image'] ?>" style="width: 100px;"></a></td>
                            <td class="text-center border-top border-dark-subtle"><?= $filmDansPanier['title'] ?></td>
                            <td class="text-center border-top border-dark-subtle"><?= $filmDansPanier['price'] ?>€</td>
                            <td class="text-center border-top border-dark-subtle d-flex align-items-center justify-content-center" style="padding: 7rem;">

                                <?= $filmDansPanier['quantity'] ?>
                                <!-- Afficher la quantité actuelle -->

                            </td>
                            <td class="text-center border-top border-dark-subtle"><?= $filmDansPanier['subtotal'] ?>€</td>
                            <td class="text-center border-top border-dark-subtle"><a href="?id=<?= $filmDansPanier['id_film'] ?>"><i class="bi bi-trash3"></i></a></td>
                        </tr>

                    <?php
                    }
                    ?>
                    <tr class="border-top border-dark-subtle">
                        <th class="text-danger p-4 fs-3">Total : <?= $total; ?>€</th>
                    </tr>



                </table>
                <form action="checkout.php" method="post">
                    <input type="hidden" name="total" value="<?= $total; ?>">
                    <button type="submit" class="btn btn-danger mt-5 p-3" id="checkout-button">Payer</button>


                </form>

            <?php

            }

            ?>


        </div>
    </div>
</main>




<?php

require_once "../inc/footer.inc.php";
?>
require_once "../inc/footer.inc.php";
?>