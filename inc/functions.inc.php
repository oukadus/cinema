<?php
////////////////////// Lancement de la session //////////////////////////
session_start();


////////////////////////////////////////////

define("RACINE_SITE", "http://localhost/cinema/");

function alert($content, $type = 'primary'): string
{
    return "<div class=\"alert alert-$type alert-dismissible fade show text-center w-50 m-auto mb-5\" role=\"alert\">
                $content
            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
        </div>";
}

$pageTitle; // variable pour le titre de la page


///////////////////////   Fonction pour débuguer ////////////////////////

function debug($var)
{
    echo '<pre class= "border border-dark bg-light text-danger fw-bold w-50 p-5 mt-5 mx-auto">';
    var_dump($var);
    echo '</pre>';
}

///////////////////////   Fonction pour déconnexion de session LOGOUT ////////////////////////

if (isset($_GET['action']) && $_GET['action'] === 'deconnexion') {
    unset($_SESSION['user']); // on supprime l'indice user de la session pour se déconnecter / Cette fonction détruit les éléments de  du tableau $_SESSION['user']

    // La fonction session_destroy détruit toutes les données de la session déjà établie. Cette fonction détruit la session sur le serveur

    header('location:' . RACINE_SITE . 'index.php');
}

// Fonction Session pour les messages d'alerte
function message(): string
{
    $message = '';

    if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
        $message = $_SESSION['message'];

        unset($_SESSION['message']);
    }

    return $message;
}


######################################################
// On vas utiliser l'extension PHP Data Objects (PDO), elle définit une excellente interface pour accéder à une base de données depuis PHP et d'exécuter des requêtes SQL .

// Pour se connecter à la BDD avec PDO il faut créer une instance de cet Objet (PDO) qui représente une connexion à la base,  pour cela il faut se servir du constructeur de la classe. 

// Ce constructeur demande certains paramètres:
// On déclare des constantes d'environnement qui vont contenir les information à la connexion à la BDD
#####################################################

// Créer une constante server 
define("DB_HOST", "localhost");

// Créer une constante user 
define("DB_USER", "root");

// créer une constante mot de passe 
define("DB_PASS", "");

// Créer une constante Nom de la base de données 
define("DB_NAME", "cinema");


function connection_bdd(): object
{

    //DSN (Data Source Name):

    //$dsn = mysql:host=localhost;dbname=entreprise;charset=utf8;
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";

    //Grâce à PDP on peut lever une exception (une erreur) si la connexion à la BDD ne se réalise pas(exp: suite à une faute au niveau du nom de la BDD) et par la suite si elle cette erreur est capté on lui demande d'afficher une erreur

    try { // dans le try on vas instancier PDO, c'est créer un objet de la classe PDO (un élment de PDO)
        // Sans la variable dsn les constatntes d'environnement
        // $pdo = new PDO('mysql:host=localhost;dbname=entreprise;charset=utf8','root','');
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        //On définit le mode d'erreur de PDO sur Exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // POUR SAHAR:  cet atribut est à rajouter après le premier fetch en bas 
        //On définit le mode de "fetch" par défaut
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // je vérifie la connexion avec ma BDD avec un simple echo
        // echo "Je suis connecté à la BDD";
    } catch (PDOException $e) {  // PDOException est une classe qui représente une erreur émise par PDO et $e c'est l'objetde la clase en question qui vas stocker cette erreur

        die("Erreur : " . $e->getMessage()); // die d'arrêter le PHP et d'afficher une erreur en utilisant la méthode getmessage de l'objet $e
    }

    //le catch sera exécuter dès lors on aura un problème da le try

    // À partir d'ici on est connecté à la BDD et la variable $pdo est l'objet qui représente la connexion à la BDD, cette variable va nous servir à effectuer les requêtes SQL et à interroger la base de données 


    // debug($pdo);
    //debug(get_class_methods($pdo)); // permet d'afficher la liste des méthodes présentes dans l'objet $pdo.


    return $pdo;
}


// Créer la table categories
function createTableCategories(): void
{

    $cnx = connection_bdd();
    $sql = "CREATE TABLE IF NOT EXISTS categories 
    (
    id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    description TEXT NULL
    )";

    $request = $cnx->exec($sql);
}

// Créer la table films
function createTableFilms(): void
{

    $cnx = connection_bdd();
    $sql = "CREATE TABLE IF NOT EXISTS films 
    (
    id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    category_id INT(11) NOT NULL, 
    title VARCHAR(100) NOT NULL,
    director VARCHAR(100) NOT NULL,
    actors VARCHAR(100) NOT NULL,
    ageLimit VARCHAR(5) NULL,
    duration TIME NOT NULL,
    synopsis TEXT NOT NULL,
    date DATE NOT NULL,
    image VARCHAR(250) NOT NULL,
    price FlOAT NOT NULL,
    stock BIGINT NOT NULL
    )";

    $request = $cnx->exec($sql);
}

// Créer la table Users
function createTableUsers()
{
    $cnx = connection_bdd();
    $sql = " CREATE TABLE IF NOT EXISTS users (
            id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            firstName VARCHAR(50),
            lastName VARCHAR(50) NOT NULL,
            pseudo VARCHAR(50) NOT NULL,
            mdp VARCHAR(255) NOT NULL,
            email VARCHAR(100) NOT NULL,
            phone VARCHAR(30) NOT NULL,
            civility ENUM('f', 'h') NOT NULL,
            birthday date NOT NULL,
            address VARCHAR(50) NOT NULL,
            zip VARCHAR(50) NOT NULL,
            city VARCHAR(50) NOT NULL,
            country VARCHAR(50),
            role ENUM('ROLE_USER','ROLE_ADMIN') DEFAULT 'ROLE_USER'
         )";
    $request = $cnx->exec($sql);
}


// Créer une clé étrangère 
function foreignKey(string $tableL, string $fieldL, string $tableF, string $fieldF): void
{
    $cnx = connection_bdd();
    $sql = "ALTER TABLE $tableL ADD FOREIGN KEY ($fieldL) REFERENCES $tableF ($fieldF)";
    $request = $cnx->exec($sql);
}

// Execution des requêtes de création de table 
// createTableCategories();
// createTableFilms();
// createTableUsers();

// foreignKey('films', 'category_id', 'categories', 'id');


/*
                          ╔═════════════════════════════════════════════╗
                          ║                                             ║
                          ║                UTILISATEURS                 ║
                          ║                                             ║
                          ╚═════════════════════════════════════════════╝ 
                          
*/

//////////////// Fonction d'ajout d'utilisateur //////////////////////////

function addUser(string $firstName, string $lastName, string $pseudo, string $email, string $phone, string $mdp, string $civility, string $birthday, string $address, string $zip, string $city, string $country): void
{

    // Créer un tableau associatif avec les noms des colones de la table users comme clés
    $data = [
        'firstName' => $firstName,
        'lastName' => $lastName,
        'pseudo' => $pseudo,
        'email' => $email,
        'phone' => $phone,
        'mdp' => $mdp,
        'civility' => $civility,
        'birthday' => $birthday,
        'address' => $address,
        'zip' => $zip,
        'city' => $city,
        'country' => $country
    ];

    // Echapper les données et les traiter contre les failles JS

    foreach ($data as $key => $value) {

        //$data['lastName'] = htmlspecialcharts($lastname)
        $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

        /* 
        htmlspecialchars est une fonction qui convertit les caractères spéciaux en entités HTML, cela est utilisé afin d'empêcher l'exécution de code HTML ou JavaScript : les attaques XSS (Cross-Site Scripting) injecté par un utilisateur malveillant en échappant les caractères HTML /////////////potentiellement dangereux . Par défaut, htmlspecialchars échappe les caractères suivants :

        & (ampersand) devient &amp;
        < (inférieur) devient &lt;
        > (supérieur) devient &gt;
        " (guillemet double) devient &quot;
        
        */

        // ENT_QUOTES : est une constante en PHP  qui convertit les guillemets simples et doubles. 
        // => ' (guillemet simple) devient &#039; 
        // 'UTF-8' : Spécifie que l'encodage utilisé est UTF-8.
    }


    $cnx = connection_bdd();
    $sql = "INSERT INTO users (firstName, lastName, pseudo, email, phone, mdp, civility, birthday, address, zip, city, country) VALUES (:firstName, :lastName, :pseudo, :email, :phone, :mdp, :civility, :birthday, :address, :zip, :city, :country)";
    $request = $cnx->prepare($sql); //prepare() est une méthode qui permet de préparer la requête sans l'exécuter. Elle contient un marqueur :firstName qui est vide et attend une valeur.

    /* Les requêtes préparer sont préconisées si vous exécutez plusieurs fois la même requête. Ainsi vous évitez au SGBD de répéter toutes les phases analyse/ interpretation / exécution de la requête (gain de performance). Les requêtes préparées sont aussi utilisées pour nettoyer les données et se prémunir des injections de type SQL.

        1- On prépare la requête
        2- On lie le marqueur à la requête
        3- On exécute la requête 

    */

    // $request->execute(array(
    //     ':firstName' => $data['firstName'],
    //     ':lastName' => $data['lastName'],
    //     ':pseudo' => $data['pseudo'],
    //     ':email' => $data['email'],
    //     ':phone' => $data['phone'],
    //     ':mdp' => $data['mdp'],
    //     ':civility' => $data['civility'],
    //     ':birthday' => $data['birthday'],
    //     ':address' => $data['address'],
    //     ':zip' => $data['zip'],
    //     ':city' => $data['city'],
    //     ':country' => $data['country']
    // ));

    $request->execute($data);
}

function checkEmailUser(string $email): mixed
{
    $cnx = connection_bdd();
    $sql = "SELECT email FROM users WHERE email = :email";
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':email' => $email
    ));

    $result = $request->fetch();
    return $result;
}

function checkPseudoUser(string $pseudo): mixed
{
    $cnx = connection_bdd();
    $sql = "SELECT pseudo FROM users WHERE pseudo = :pseudo";
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':pseudo' => $pseudo
    ));

    $result = $request->fetch();
    return $result;
}

function checkUser(string $pseudo, string $email): mixed
{
    $cnx = connection_bdd();
    $sql = "SELECT * FROM users WHERE pseudo = :pseudo AND email = :email";
    $request = $cnx->prepare($sql);
    $request->execute(array(

        ':pseudo' => $pseudo,
        ':email' => $email
    ));

    $result = $request->fetch();
    return $result;
}


function allUsers(): mixed
{
    $cnx = connection_bdd();
    $sql = "SELECT * FROM users";
    $request = $cnx->query($sql);
    $result = $request->fetchAll();

    return $result;
}

function showUser(int $id): mixed
{
    $cnx = connection_bdd();
    $sql = "SELECT * FROM users WHERE id = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id' => $id,


    ));

    $result = $request->fetch();
    return $result;
}

function updateRole(string $role, int $id): void
{

    $cnx = connection_bdd();
    $sql = "UPDATE users SET role = :role WHERE id = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':role' => $role,
        ':id' => $id
    ));
}

// Dans une fonction qui ne retourne rien, on ne fetch pas. Vue que Fetch permet de retourner sous forme de tableau
function deleteUser(int $id): void
{
    $cnx = connection_bdd();
    $sql = "DELETE FROM users WHERE id = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        'id' => $id
    ));
}

// modifier les informations de l'utilisateur 
// function updateUser(string $firstName, string $lastName, string $pseudo, string $email, string $phone, string $mdp, string $civility, string $birthday, string $address, string $zip, string $city, string $country): void {
//     $cnx = connection_bdd(); 
//     $sql = 
// }

/*
                          ╔═════════════════════════════════════════════╗
                          ║                                             ║
                          ║                CATEGORIES                   ║
                          ║                                             ║
                          ╚═════════════════════════════════════════════╝ 
                          
*/

// vérifier si catégorie existe déjà
function categoryExist(string $name): mixed
{
    $cnx = connection_bdd();
    $sql = "SELECT * FROM categories WHERE name = :name";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':name' => $name
    ));

    $result = $request->fetch();
    return $result;
}

//ajouter une catégorie
function addCategory(string $name, string $description): void
{

    $data = [
        'name' => $name,
        'description' => $description
    ];

    foreach ($data as $key => $value) {
        $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    $cnx = connection_bdd();
    $sql = "INSERT INTO categories (name, description) VALUES (:name, :description)";
    $request = $cnx->prepare($sql);
    $request->execute($data);
}

//afficher toutes les catégories
function allCategories(string $order = "id"): mixed
{
    $cnx = connection_bdd();
    $sql = "SELECT * FROM categories ORDER BY $order";
    $request = $cnx->query($sql);
    $result = $request->fetchAll();

    return $result;
}

// effacer une catégorie
function deleteCategory(int $id): void
{
    $cnx = connection_bdd();
    $sql = "DELETE FROM categories WHERE id = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        'id' => $id
    ));
}

// afficher une catégorie
function showCategory(int $id): mixed
{
    $cnx = connection_bdd();
    $sql = "SELECT * FROM categories WHERE id = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id' => $id
    ));

    $result = $request->fetch();
    return $result;
}

// modifier une catégorie
function updateCategory(string $name, string $description, int $id): void
{
    $data = [
        'name' => $name,
        'description' => $description,
        'id' => $id
    ];

    foreach ($data as $key => $value) {
        $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    $cnx = connection_bdd();
    $sql = "UPDATE categories SET name = :name, description = :description WHERE id = :id";
    $request = $cnx->prepare($sql);
    $request->execute($data);
}

/*
                          ╔═════════════════════════════════════════════╗
                          ║                                             ║
                          ║                FILMS                        ║
                          ║                                             ║
                          ╚═════════════════════════════════════════════╝ 
                          
*/

// vérifier si le film existe déjà
function filmExist(string $title): mixed
{
    $cnx = connection_bdd();
    $sql = "SELECT * FROM films WHERE title = :title";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':title' => $title
    ));

    $result = $request->fetch();
    return $result;
}

// ajouter un film
function addFilm(string $title, string $director, string $actors, string $ageLimit, int $categories, string $duration, string $date, string $price, string $stock, string $synopsis, string $image): void
{
    $data = [
        'title' => $title,
        'director' => $director,
        'actors' => $actors,
        'ageLimit' => $ageLimit,
        'categories' => $categories,
        'duration' => $duration,
        'date' => $date,
        'price' => $price,
        'stock' => $stock,
        'synopsis' => $synopsis,
        'image' => $image
    ];

    foreach ($data as $key => $value) {
        $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    $cnx = connection_bdd();
    $sql = "INSERT INTO films (title, director, actors, ageLimit, category_id, duration, date, price, stock, synopsis, image) VALUES (:title, :director, :actors, :ageLimit, :categories, :duration, :date, :price, :stock, :synopsis, :image)";
    $request = $cnx->prepare($sql);
    $request->execute($data);
}

// afficher tous les films
function allFilms(string $order = "id"): mixed
{
    $cnx = connection_bdd();
    $sql = "SELECT * FROM films ORDER BY $order";
    $request = $cnx->query($sql);
    $result = $request->fetchAll();

    return $result;
}

// afficher un film
function showFilm(int $id): mixed
{
    $cnx = connection_bdd();
    $sql = "SELECT * FROM films WHERE id = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':id' => $id
    ));

    $result = $request->fetch();
    return $result;
}

// modifier un film
function updateFilm(string $title, string $director, string $actors, string $ageLimit, int $categories, string $duration, string $date, string $price, string $stock, string $synopsis, string $image, int $id): void
{
    $data = [
        'title' => $title,
        'director' => $director,
        'actors' => $actors,
        'ageLimit' => $ageLimit,
        'categories' => $categories,
        'duration' => $duration,
        'date' => $date,
        'price' => $price,
        'stock' => $stock,
        'synopsis' => $synopsis,
        'image' => $image,
        'id' => $id
    ];

    foreach ($data as $key => $value) {
        $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    $cnx = connection_bdd();
    $sql = "UPDATE films SET title = :title, director = :director, actors = :actors, ageLimit = :ageLimit, category_id = :categories, duration = :duration, date = :date, price = :price, stock = :stock, synopsis = :synopsis, image = :image WHERE id = :id";
    $request = $cnx->prepare($sql);
    $request->execute($data);
}
