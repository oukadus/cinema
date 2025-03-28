<!DOCTYPE html>
<html lang="html">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Premier site en PHP : site cinema">
    <meta name="author" content="SaharMahdouani">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Style css  -->
    <link rel="stylesheet" href="<?= RACINE_SITE; ?>assets/css/style.css">
    <!--  icone bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!--  Line vers google font  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    <!-- stripe js -->
    <script src="https://js.stripe.com/v3/"></script>

    <!-- Title -->
    <title>Cinema <?= $pageTitle; ?></title>


</head>

<body class="bg-light">

    <header>
        <nav class="navbar navbar-expand-lg fixed-top ">
            <div class="container-fluid">
                <h1><a class="navbar-brand" href="<?= RACINE_SITE; ?>">M <img src="<?= RACINE_SITE ?>assets/img/logo.png" alt=""> VIES</a></h1>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav w-100 d-flex justify-content-end">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="<?= RACINE_SITE; ?>">Accueil</a>
                        </li>


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Catégories
                            </a>
                            <ul class="dropdown-menu">

                                <?php $categories = allCategories('name');
                                foreach ($categories as $category) : ?>

                                    <li><a class="dropdown-item fs-4" href="index.php?action=showCategory&id=<?= $category['id']; ?>"><?= html_entity_decode($category['name']); ?></a></li>

                                <?php endforeach; ?>
                            </ul>
                        </li>



                        <?php
                        if (!isset($_SESSION['user'])) { ?>


                            <!-- Condition de session START -->
                            <li class=" nav-item">
                                <a class="nav-link" href="<?= RACINE_SITE ?>register.php">Inscription</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= RACINE_SITE ?>auth.php">Connexion</a>
                            </li>
                            <!-- Condition de session END -->

                            <?php } else {

                            if (isset($_SESSION['user'])) {
                                $user = $_SESSION['user'];
                                //  if ($_SESSION['user']['role'] == "ROLE_ADMIN")
                                if ($user['role'] == "ROLE_ADMIN") {
                            ?>

                                    <li class="nav-item dropdown">

                                        <a class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">Backoffice</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item text-dark fs-4" href="<?= RACINE_SITE; ?>admin/categories.php">Catégories</a></li>
                                            <li><a class="dropdown-item text-dark fs-4" href="<?= RACINE_SITE; ?>admin/films.php">Films</a></li>
                                            <li><a class="dropdown-item text-dark fs-4" href="<?= RACINE_SITE; ?>admin/filmForm.php">Gestion films</a></li>
                                            <li><a class="dropdown-item text-dark fs-4" href="<?= RACINE_SITE; ?>admin/users.php">utilisateurs</a></li>
                                        </ul>
                                    </li>

                                <?php
                                }
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= RACINE_SITE; ?>profil.php">Compte (<?= $user['pseudo']; ?>)<sup class="badge rounded-pill text-bg-danger"></sup></a>
                                </li>
                            <?php
                            }
                            ?>



                            <li class="nav-item">
                                <a class="nav-link" href="?action=deconnexion">Déconnexion</a>
                            </li>

                        <?php } ?>







                        <li class="nav-item">
                            <a class="nav-link" href="<?= RACINE_SITE; ?>store/cart.php"><i class="bi bi-cart fs-2"><sup></sup></i></a>
                        </li>


                    </ul>

                </div>
            </div>
        </nav>
    </header>