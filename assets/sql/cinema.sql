-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 27 mars 2025 à 09:26
-- Version du serveur : 8.0.30
-- Version de PHP : 8.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cinema`
--
CREATE DATABASE IF NOT EXISTS `cinema` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `cinema`;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(6, 'Science-fiction', 'Un film de science-fiction Il utilise des représentations fictives, souvent basées sur la science, qui n&amp;#039;est pas entièrement acceptée (voire qui sont totalement rejetées) par la science traditionnelle, telles que par exemple les formes de vie extraterrestre, les mondes extraterrestres, la perception extrasensorielle et les voyages dans le temps.'),
(8, 'Aventure', 'Un film d&amp;#039;aventure (au singulier) est un genre cinématographique caractérisé par la présence d&amp;#039;un héros fictif ou non, tirant son statut du mythe qu&amp;#039;il inspire, l&amp;#039;action particulière qui s&amp;#039;y déroule, l&amp;#039;emploi de décors particuliers également, parfois le décalage temporel par rapport au contemporain ainsi que, parfois, les invraisemblances voulues caractérisant ainsi son excentricité, le tout véhiculant une idée générale de dépaysement.'),
(9, 'Drame', 'Le drame est un genre cinématographique qui traite des situations généralement non épiques dans un contexte sérieux, sur un ton plus susceptible d&amp;#039;inspirer la tristesse que le rire. Généralement, un drame repose sur un scénario abordant avec le moins d&amp;#039;humour possible un thème grave (la mort, la misère, le viol, la toxicomanie…) qui peut être douloureux, révoltant ; une injustice. Il peut s’inspirer de l&amp;#039;histoire (avec des thèmes comme la Seconde Guerre mondiale ou de l&amp;#039;actualité'),
(10, 'Film d&amp;#039;animation', 'Technique cinématographique qui permet par des prises de vues image par image de créer le mouvement d&amp;#039;objets et de personnages animés. Film cinématographique réalisé en partant d&amp;#039;une suite de dessins représentant les phases successives du mouvement du corps.'),
(11, 'Fantastique', 'Le cinéma fantastique est un genre cinématographique regroupant des films faisant appel au surnaturel, à l&amp;#039;horreur, à l&amp;#039;insolite ou aux monstres. L’intrigue se fonde sur des éléments irrationnels ou irréalistes. Le genre se caractérise par sa grande diversité : il regroupe des œuvres inspirées du merveilleux, des films d&amp;#039;horreur faisant appel à l&amp;#039;épouvante, au cauchemar, à la folie.'),
(12, 'Famille', 'Catégorie regroupant tous les films dont les personnages principaux composent une famille, les relations familiales étant bien représentées dans l&amp;#039;histoire, qu&amp;#039;il s&amp;#039;agisse d&amp;#039;un film dramatique, d&amp;#039;une comédie ou d&amp;#039;un film d&amp;#039;aventure.'),
(23, 'Action', 'Le film d&amp;#039;action est un genre cinématographique qui met en scène une succession de scènes spectaculaires souvent stéréotypées (courses-poursuites, fusillades, explosions...) construites autour d&amp;#039;un conflit résolu de manière violente, généralement par la mort des ennemis du héros.');

-- --------------------------------------------------------

--
-- Structure de la table `films`
--

CREATE TABLE `films` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `director` varchar(100) NOT NULL,
  `actors` varchar(100) NOT NULL,
  `ageLimit` varchar(5) DEFAULT NULL,
  `duration` time NOT NULL,
  `synopsis` text NOT NULL,
  `date` date NOT NULL,
  `image` varchar(250) NOT NULL,
  `price` float NOT NULL,
  `stock` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `films`
--

INSERT INTO `films` (`id`, `category_id`, `title`, `director`, `actors`, `ageLimit`, `duration`, `synopsis`, `date`, `image`, `price`, `stock`) VALUES
(2, 6, 'Dune', 'Villeneuve', 'Timothée Chalamet / Zendaya', '13', '02:36:00', 'L&#039;;histoire de Paul Atreides, jeune homme aussi doué que brillant, voué à connaître un destin hors du commun qui le dépasse totalement. Car s&#039;il veut préserver l&#039;avenir de sa famille et de son peuple, il devra se rendre sur la planète la plus dangereuse de l&#039;;univers – la seule à même de fournir la ressource la plus précieuse au monde, capable de décupler la puissance de l&#039;humanité. Tandis que des forces maléfiques se disputent le contrôle de cette planète, seuls ceux qui parviennent à dominer leur peur pourront survivre…', '2021-09-15', 'avatar.jpg', 11, 20),
(3, 6, 'Avatar', 'Cameron', 'Worthingt on/Zoe Saldana/Si gourney Weaver/St ephen Lang', '10', '02:46:00', 'Malgré sa paralysie, Jake Sully, un ancien marine immobilisé dans un fauteuil roulant, est resté un combattant au plus profond de son être. Il est recruté pour se rendre à des années-lumière de la Terre, sur Pandora, où de puissants groupes industriels exploitent un minerai rarissime destiné à résoudre la crise énergétique sur Terre. Parce que l&amp;#039;atmosphère de Pandora est toxique pour les humains, ceux-ci ont créé le Programme Avatar, qui permet à des &amp;quot; pilotes &amp;quot; humains de lier leur esprit à un avatar, un corps biologique commandé à distance, capable de survivre dans cette atmosphère létale. Ces avatars sont des hybrides créés génétiquement en croisant l&amp;#039;ADN humain avec celui des Na&amp;#039;vi, les autochtones de Pandora.', '2009-12-16', 'avatar.jpg', 11, 20),
(4, 6, 'Interstellar', 'Nolan', 'Matthew McConaug hey/Anne Hathaway /Michael Caine', '10', '02:49:00', 'Le film raconte les aventures d’un groupe d’explorateurs qui utilisent une faille récemment découverte dans l’espace-temps afin de repousser les limites humaines et partir à la conquête des distances astronomiques dans un voyage interstellaire', '2014-11-05', 'interstellar.jpg', 11, 20),
(5, 11, 'Matrix', 'Wachow sisters', 'Keanu Reeves/Laurence Fishburne/ Carrie Anne Moss', '16', '02:15:00', 'Programmeur anonyme dans un service administratif le jour, Thomas Anderson devient Neo la nuit venue. Sous ce pseudonyme, il est l&amp;#039;un des pirates les plus recherchés du cyberespace. A cheval entre deux mondes, Neo est assailli par d&amp;#039;étranges songes et des messages cryptés provenant d&amp;#039;un certain Morpheus. Celui-ci l&amp;#039;exhorte à aller au-delà des apparences et à trouver la réponse à la question qui hante constamment ses pensées : qu&amp;#039;est-ce que la Matrice ? Nul ne le sait, et aucun homme n&amp;#039;est encore parvenu à en percer les defenses. Mais Morpheus est persuadé que Neo est l&amp;#039;Elu, le libérateur mythique de l&amp;#039;humanité annoncé selon la prophétie. Ensemble, ils se lancent dans une lutte sans retour contre la Matrice et ses terribles agents...', '1999-05-24', 'matrix.jpg', 11, 20),
(6, 11, 'E.T', 'Spielberg', 'Henry Thomas/Drew Barrymore /Dee Wallace', '10', '02:00:00', 'Une soucoupe volante atterrit en pleine nuit près de Los Angeles. Quelques extraterrestres, envoyés sur Terre en mission d&amp;#039;exploration botanique, sortent de l&amp;#039;engin, mais un des leurs s&amp;#039;aventure audelà de la clairière où se trouve la navette. Celui-ci se dirige alors vers la ville. C&amp;#039;est sa première découverte de la civilisation humaine. Bientôt traquée par des militaires et abandonnée par les siens, cette petite créature apeurée se nommant E.T. se réfugie dans une résidence de banlieue.', '1892-05-26', 'et.jpg', 11, 20),
(9, 9, '7ans au tibet', 'Jean-Jacques Annaud', 'Brad Pitt / David Thewlis / Jamyang Jamtsho Wangchuk / David Thewlis / B.D Wong', '10', '02:15:00', 'A la fin de l&amp;#039;été 1939, l&amp;#039;alpiniste autrichien Heinrich Harrer, premier vainqueur de la face Nord de l&amp;#039;Eiger et qui rêve de conquérir le Nanga Parbat, sommet inviolé de l&amp;#039;Himalaya, accepte de l&amp;#039;argent nazi pour y planter le drapeau à croix gammée. La guerre éclate. Prisonnier des Britanniques à la frontière de l&amp;#039;Inde, il s&amp;#039;évade. Commence alors la véritable aventure de sa vie : une longue errance qui se termine à Lhassa, résidence du jeune Dalaï- lama avec qui il se lie d&amp;#039;amitié.', '1997-10-08', '7-ans-au-Tibet.jpg', 11, 20),
(10, 9, 'Invictus', 'Clint Eastwood', 'Morgan Freeman / Matt Damon / Tony Kgoroge / Adjoa Andoh / Marguerit', '10', '02:12:00', 'À l&amp;#039;issue de la chute de l&amp;#039;apartheid, le président Nelson Mandela, récemment élu, est confronté à une Afrique du Sud qui est racialement et économiquement divisée.', '2012-12-01', 'Invictus.png', 11, 20);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `price` float NOT NULL,
  `created_at` date NOT NULL,
  `is_paid` enum('1','0') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_details`
--

CREATE TABLE `order_details` (
  `order_id` int NOT NULL,
  `film_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `civility` enum('f','h') NOT NULL,
  `birthday` date NOT NULL,
  `address` varchar(50) NOT NULL,
  `zip` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `country` varchar(50) DEFAULT NULL,
  `role` enum('ROLE_USER','ROLE_ADMIN') DEFAULT 'ROLE_USER'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `pseudo`, `mdp`, `email`, `phone`, `civility`, `birthday`, `address`, `zip`, `city`, `country`, `role`) VALUES
(1, 'Abdelkader', 'OUNADJELA', 'Kader', '$2y$12$mKdAx2AwvCuUBabKdQfz8OJ.0lq2u7MPnHYC12Dw6zEewOGyc3a7q', 'okadus@gmail.com', '0788440529', 'h', '1984-06-06', '10 allée des Orgues de Flandre', '75010', 'Paris', 'France', 'ROLE_ADMIN'),
(8, 'Mamadou', 'Amadou', 'Doumstyle', '$2y$12$nZm0X.zFtDWewyvItBROF.Tj1/DPh22nrR8XFNujhsPjW1mJE5aG6', 'mamadou.amadou@colombbus.org', '0788440529', 'h', '1983-12-12', 'Terrage du 10', '75010', 'Paris', 'France', 'ROLE_ADMIN'),
(9, 'Islem', 'Fourati', 'IslemFou', '$2y$12$f8GU/ln.IUFJTVEJ/1OixureKWtoxd978LcoTxbVuKhZK/4Wfpym.', 'islem.fourati@colombbus.org', '0788440529', 'f', '1995-01-01', 'Terrage du 10', '75010', 'Paris', 'France', 'ROLE_USER');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `order_details`
--
ALTER TABLE `order_details`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `film_id` (`film_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `films`
--
ALTER TABLE `films`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `films`
--
ALTER TABLE `films`
  ADD CONSTRAINT `films_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`),
  ADD CONSTRAINT `order_details_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_4` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`),
  ADD CONSTRAINT `order_details_ibfk_5` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_6` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
