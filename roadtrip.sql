-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 24 avr. 2019 à 11:51
-- Version du serveur :  10.1.36-MariaDB
-- Version de PHP :  7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `roadtrip`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `box` int(11) DEFAULT NULL,
  `zip_code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `address`
--

INSERT INTO `address` (`id`, `street`, `number`, `box`, `zip_code`, `city`, `state`, `country`, `latitude`, `longitude`) VALUES
(1, 'Rue de Mont 63, Yvoir, Wallonie, Belgique', '63', NULL, '5170', 'Yvoir', NULL, 'BE', 50.3481, 4.87478),
(2, 'Rue de Mont', '64', NULL, '5530', 'Godinne', NULL, 'BE', 0, 0),
(103, 'Sentier de Mariencourt', '128', NULL, '5530', 'Yvoir', NULL, 'BE', 0, 0),
(204, 'rue de Roussel', '537', NULL, '89251', 'Gonzalez-sur-Blot', NULL, 'Montserrat', 0, 0),
(205, 'chemin Marine Vallet', '177', NULL, '38 403', 'Rossidan', 'State1', 'République tchèque', 0, 0),
(206, 'avenue Lemonnier', '61', NULL, '25302', 'Bonnetdan', NULL, 'Algérie', 0, 0),
(207, 'chemin Thérèse Baron', '570', NULL, '56 494', 'Martins', 'State3', 'Nepal', 0, 0),
(208, 'rue Lucas Gauthier', '868', NULL, '95 173', 'De Oliveira', NULL, 'Micronésie (États fédérés de)', 0, 0),
(209, 'place Amélie Marie', '534', NULL, '03014', 'Vaillant-la-Forêt', 'State5', 'Kirghizistan', 0, 0),
(210, 'place Letellier', '194', NULL, '28781', 'Charpentier-les-Bains', NULL, 'Bahrain', 0, 0),
(211, 'chemin Andre', '924', NULL, '52683', 'Moreno', 'State7', 'Namibie', 0, 0),
(212, 'chemin Germain', '982', NULL, '95037', 'Laporte-sur-Andre', NULL, 'Indonésie', 0, 0),
(213, 'boulevard Peron', '416', NULL, '65 986', 'MilletBourg', 'State9', 'Inde', 0, 0),
(215, 'boulevard Camille Bonnin', '799', NULL, '93365', 'Mahe-la-Forêt', 'State11', 'République centrafricaine', 0, 0),
(216, 'place Adrienne Pereira', '508', NULL, '32 694', 'Gomez', NULL, 'Guatemala', 0, 0),
(217, 'rue de Mercier', '477', NULL, '35 780', 'Martineau-les-Bains', 'State13', 'Madagascar', 0, 0),
(218, 'boulevard de Perrot', '753', NULL, '64 471', 'Imbert', NULL, 'Qatar', 0, 0),
(219, 'boulevard de Riviere', '460', NULL, '53961', 'Imbert', 'State15', 'Bouvet (Îles)', 0, 0),
(220, 'boulevard Gérard Briand', '206', NULL, '03 943', 'Toussaint', NULL, 'Maldives (Îles)', 0, 0),
(221, 'chemin Berger', '957', NULL, '90530', 'Didier-sur-Lacombe', 'State17', 'Ukraine', 0, 0),
(222, 'chemin de Levy', '206', NULL, '37894', 'Rousset-sur-Weber', NULL, 'Croatie', 0, 0),
(223, 'chemin Hamel', '35', NULL, '53 977', 'Bernardnec', 'State19', 'Luxembourg', 0, 0),
(224, 'rue Benoit', '476', NULL, '22523', 'Klein', NULL, 'Myanmar', 0, 0),
(225, 'place de Grondin', '461', NULL, '90 492', 'Pons-la-Forêt', 'State21', 'Ghana', 0, 0),
(226, 'impasse Gilles Barbier', '161', NULL, '65 747', 'Guillon', NULL, 'Bangladesh', 0, 0),
(227, 'rue Étienne Regnier', '558', NULL, '19 013', 'Perrin-les-Bains', 'State23', 'Mozambique', 0, 0),
(228, 'impasse Hugues Dumont', '515', NULL, '61400', 'Morin-la-Forêt', NULL, 'Zambie', 0, 0),
(229, 'place Germain', '498', NULL, '85 955', 'Renarddan', 'State25', 'Syrie', 0, 0),
(230, 'impasse Neveu', '62', NULL, '18277', 'Brun-sur-Mer', NULL, 'Équateur', 0, 0),
(231, 'rue Langlois', '330', NULL, '17 801', 'Jourdan-sur-Mer', 'State27', 'Kiribati', 0, 0),
(232, 'rue de Blondel', '851', NULL, '63 386', 'Remyboeuf', NULL, 'Lesotho', 0, 0),
(233, 'chemin Ferrand', '759', NULL, '69 993', 'Massenec', 'State29', 'Malte', 0, 0),
(234, 'place de Leclercq', '227', NULL, '78912', 'Lemaire', NULL, 'Rwanda', 0, 0),
(235, 'rue de Hubert', '245', NULL, '46 505', 'Maury', 'State31', 'Espagne', 0, 0),
(236, 'boulevard Roger', '511', NULL, '20646', 'Maillot', NULL, 'Cuba', 0, 0),
(237, 'impasse Guichard', '683', NULL, '35335', 'Grenier-sur-Marchand', 'State33', 'Ouganda', 0, 0),
(238, 'place Alfred Dupre', '37', NULL, '74557', 'CourtoisBourg', NULL, 'Pays-Bas', 0, 0),
(239, 'rue de Voisin', '541', NULL, '98 536', 'Girardboeuf', 'State35', 'Croatie', 0, 0),
(240, 'place de Guilbert', '282', NULL, '20319', 'MeyerVille', NULL, 'Soudan', 0, 0),
(241, 'avenue de Maillard', '423', NULL, '07 867', 'Joubert-les-Bains', 'State37', 'Polynésie française', 0, 0),
(242, 'chemin de Dijoux', '668', NULL, '27 084', 'PoulainVille', NULL, 'Samoa', 0, 0),
(243, 'impasse Fouquet', '212', NULL, '98 826', 'Joly', 'State39', 'Sri Lanka', 0, 0),
(244, 'place Dominique Vallee', '465', NULL, '94 329', 'CousinVille', NULL, 'Bhoutan', 0, 0),
(245, 'rue Grégoire Courtois', '361', NULL, '16 534', 'Gautier', 'State41', 'Bosnie-Herzégovine', 0, 0),
(246, 'chemin de Mendes', '393', NULL, '33 997', 'PotierVille', NULL, 'Émirats arabes unis', 0, 0),
(247, 'boulevard de Vidal', '593', NULL, '75 474', 'Bouchet', 'State43', 'Madagascar', 0, 0),
(248, 'rue de Moulin', '54', NULL, '90160', 'Gauthier', NULL, 'Tadjikistan', 0, 0),
(249, 'chemin de Guillon', '350', NULL, '39291', 'Bigot', 'State45', 'Guam', 0, 0),
(250, 'rue de Raymond', '969', NULL, '90006', 'GarnierVille', NULL, 'Brunei', 0, 0),
(251, 'avenue Jean', '86', NULL, '95 626', 'Barondan', 'State47', 'Tadjikistan', 0, 0),
(252, 'rue Pottier', '837', NULL, '98575', 'Morin', NULL, 'Jamaïque', 0, 0),
(253, 'rue Grégoire Roche', '124', NULL, '35 252', 'Traorenec', 'State49', 'Sierra Leone', 0, 0),
(254, 'boulevard Henri Coste', '435', NULL, '41 961', 'Bazin', NULL, 'Canada', 0, 0),
(255, 'place François Rolland', '951', NULL, '62271', 'Perret', 'State51', 'Royaume-Uni', 0, 0),
(256, 'place Frédéric Lebon', '846', NULL, '34364', 'LemonnierBourg', NULL, 'Pérou', 0, 0),
(257, 'boulevard Josette Schmitt', '53', NULL, '24 309', 'Delahaye', 'State53', 'Côte d\'Ivoire', 0, 0),
(258, 'chemin Charles Prevost', '84', NULL, '50 824', 'MailletBourg', NULL, 'Espagne', 0, 0),
(259, 'avenue Salmon', '510', NULL, '57 171', 'Grondin-sur-Dias', 'State55', 'Guam', 0, 0),
(260, 'avenue de Rodrigues', '932', NULL, '54 313', 'Delattre', NULL, 'Tokelau', 0, 0),
(261, 'chemin Marianne Tessier', '944', NULL, '34 762', 'Joly', 'State57', 'Kenya', 0, 0),
(262, 'impasse Grondin', '991', NULL, '35 621', 'Voisin', NULL, 'Maroc', 0, 0),
(263, 'boulevard Morvan', '515', NULL, '94 044', 'Chartier-les-Bains', 'State59', 'Palau', 0, 0),
(264, 'place Thomas', '601', NULL, '51 010', 'FouquetVille', NULL, 'Fidji (République des)', 0, 0),
(265, 'place de Delannoy', '796', NULL, '80644', 'Lamy', 'State61', 'Guinée', 0, 0),
(266, 'rue de Moreau', '510', NULL, '52647', 'Fournier', NULL, 'Mozambique', 0, 0),
(267, 'impasse Margaud Benard', '571', NULL, '13 453', 'Lefebvre-sur-Mer', 'State63', 'Vierges britanniques (Îles)', 0, 0),
(268, 'place Guillon', '110', NULL, '77 177', 'Benard', NULL, 'Cuba', 0, 0),
(269, 'rue Auguste Letellier', '805', NULL, '19 145', 'Neveu-la-Forêt', 'State65', 'Australie', 0, 0),
(270, 'rue Mary', '951', NULL, '67 726', 'Lefort', NULL, 'Lettonie', 0, 0),
(271, 'boulevard Lucas Toussaint', '227', NULL, '53629', 'Lebon-sur-Godard', 'State67', 'Belize', 0, 0),
(272, 'place de Raynaud', '404', NULL, '61 959', 'De Sousa', NULL, 'Wallis et Futuna (Îles)', 0, 0),
(273, 'rue Diane Pascal', '681', NULL, '10 584', 'Paul', 'State69', 'Kirghizistan', 0, 0),
(274, 'rue de Rodrigues', '703', NULL, '40443', 'Clement', NULL, 'Svalbard et Jan Mayen (Îles)', 0, 0),
(275, 'rue Éric Bailly', '259', NULL, '94360', 'FerreiraBourg', 'State71', 'Paraguay', 0, 0),
(276, 'avenue Monnier', '535', NULL, '90528', 'Perret', NULL, 'Nouvelle Calédonie', 0, 0),
(277, 'avenue de Navarro', '778', NULL, '21 240', 'Laroche-la-Forêt', 'State73', 'Géorgie', 0, 0),
(278, 'place Sanchez', '228', NULL, '57 651', 'Pascalboeuf', NULL, 'Vanuatu', 0, 0),
(279, 'rue Bernadette Coulon', '300', NULL, '50 218', 'Hoareau', 'State75', 'Burundi', 0, 0),
(280, 'place Odette Morin', '887', NULL, '38 555', 'Costa', NULL, 'Qatar', 0, 0),
(281, 'rue Jacques Germain', '342', NULL, '95100', 'Hamel', 'State77', 'Saint-Marin (Rép. de)', 0, 0),
(282, 'place de Baudry', '802', NULL, '32 629', 'Goncalves', NULL, 'Cap Vert', 0, 0),
(283, 'boulevard Honoré Marechal', '287', NULL, '10 685', 'Bruneau', 'State79', 'Bahamas', 0, 0),
(284, 'impasse Morin', '351', NULL, '22 008', 'Techer-sur-Guerin', NULL, 'Nouvelle-Zélande', 0, 0),
(285, 'rue Germain', '274', NULL, '32 607', 'Masson', 'State81', 'Christmas (Île)', 0, 0),
(286, 'boulevard Thomas', '948', NULL, '43242', 'Roche', NULL, 'Guyane', 0, 0),
(287, 'impasse Roux', '407', NULL, '82 388', 'Pasquier', 'State83', 'Taiwan', 0, 0),
(288, 'impasse Salmon', '633', NULL, '06673', 'Reynaud', NULL, 'Afrique du sud', 0, 0),
(289, 'chemin de Roche', '6', NULL, '29546', 'Rossi', 'State85', 'Christmas (Île)', 0, 0),
(290, 'avenue Tanguy', '27', NULL, '19608', 'Noel', NULL, 'Arménie', 0, 0),
(291, 'place Dupuy', '680', NULL, '34 027', 'Gilbert', 'State87', 'Fidji (République des)', 0, 0),
(292, 'boulevard Pénélope Clement', '609', NULL, '92750', 'Gautier', NULL, 'Allemagne', 0, 0),
(293, 'place Danielle Jourdan', '126', NULL, '26 561', 'Jean-sur-Mahe', 'State89', 'Hong Kong', 0, 0),
(294, 'rue de Ramos', '459', NULL, '00054', 'Hoareauboeuf', NULL, 'Pakistan', 0, 0),
(295, 'rue de Simon', '117', NULL, '25 845', 'Chretien-sur-Mercier', 'State91', 'Nepal', 0, 0),
(296, 'chemin Martinez', '548', NULL, '68568', 'Guillot', NULL, 'Guam', 0, 0),
(297, 'rue Legrand', '687', NULL, '88187', 'Fernandes', 'State93', 'Cuba', 0, 0),
(298, 'avenue Leduc', '877', NULL, '94 799', 'Riviere', NULL, 'Autriche', 0, 0),
(299, 'avenue Leduc', '129', NULL, '86732', 'Greniernec', 'State95', 'Suède', 0, 0),
(300, 'chemin de Bernier', '269', NULL, '14 622', 'Vidal', NULL, 'Vierges (Îles)', 0, 0),
(301, 'boulevard Édouard Marie', '412', NULL, '80974', 'Martineznec', 'State97', 'Myanmar', 0, 0),
(302, 'avenue Victoire Pelletier', '959', NULL, '38691', 'Toussaint', NULL, 'Inde', 0, 0),
(303, 'avenue Regnier', '192', NULL, '89000', 'Payetboeuf', 'State99', 'Namibie', 0, 0),
(304, 'Rue de Mont', '68', NULL, '5530', 'Godinne', NULL, 'BE', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `advert`
--

CREATE TABLE `advert` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `title` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra_kilometer_cost` double DEFAULT NULL,
  `included_cleaning` tinyint(1) DEFAULT NULL,
  `cleaning_cost` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `advert`
--

INSERT INTO `advert` (`id`, `vehicle_id`, `description`, `created_at`, `updated_at`, `expires_at`, `title`, `extra_kilometer_cost`, `included_cleaning`, `cleaning_cost`) VALUES
(5, 103, 'Une petite description modifiée du véhicule lié à l\'annonce n°1', '2019-03-24 13:43:34', NULL, '2020-03-24 13:43:34', 'Le titre de l\'annonce n°1', 0.6, 1, NULL),
(6, 1, 'La petite description du véhicule lié à l\'annonce n°2', '2019-03-25 13:41:13', NULL, '2020-03-25 13:41:13', 'Le titre de l\'annonce n°2', 0.6, 0, 60),
(7, 2, 'La petite description du véhicule lié à l\'annonce n°3', '2019-03-25 19:56:52', NULL, '2020-03-25 19:56:52', 'Titre de l\'annonce n°3', NULL, NULL, NULL),
(208, 204, 'Voluptas eaque quasi esse est vitae. Delectus deserunt est voluptas quas ut. Voluptates qui eligendi libero reiciendis.', '1983-02-26 01:31:32', NULL, '1984-02-26 01:31:32', 'odio ipsam maiores', 0.3, 0, 81),
(209, 205, 'Itaque quia sit repellendus. Iste sunt cumque cum. Veniam consequatur perspiciatis aut nisi et est non.', '1913-09-07 06:51:07', NULL, '1914-09-07 06:51:07', 'aut nobis temporibus', 1, 1, NULL),
(210, 206, 'Quas aut recusandae commodi inventore. Velit est sit harum corporis. Molestias ut culpa vel.', '1980-10-15 12:22:19', NULL, '1981-10-15 12:22:19', 'est dolorum beatae', 1, 0, 64),
(211, 207, 'Dicta qui itaque cum consectetur adipisci tempora neque. Quo saepe voluptatem nihil dolorem facere odit quod velit. Sed facere alias sit qui.', '2005-12-28 23:10:05', NULL, '2006-12-28 23:10:05', 'quaerat nam et', 0.7, 1, NULL),
(212, 208, 'Ea dolor autem eius ea. Temporibus consequatur hic quos magni. Consequatur atque ut facere laboriosam.', '1940-04-06 12:19:58', NULL, '1941-04-06 12:19:58', 'minima molestiae fuga', 0.2, 0, 90),
(213, 209, 'Nihil quis sed provident eaque eius. Amet voluptatem quos omnis quaerat doloribus ut. Nihil ut aut natus.', '1925-12-27 10:38:06', NULL, '1926-12-27 10:38:06', 'harum sed quibusdam', 0.3, 1, NULL),
(214, 210, 'Deserunt et optio incidunt deleniti vitae quibusdam quasi. Quia et qui rerum et nihil asperiores. In rerum autem vero id deleniti.', '1947-11-30 10:29:35', NULL, '1948-11-30 10:29:35', 'ipsum fugiat culpa', 0.1, 0, 107),
(215, 211, 'Dolor quaerat dicta voluptas. Quibusdam sit officiis quia ipsa soluta. Necessitatibus vero veniam fuga quo tempora.', '1959-04-21 06:16:49', NULL, '1960-04-21 06:16:49', 'facere fuga sit', 0.2, 1, NULL),
(216, 212, 'Delectus nulla vel est dignissimos non aut ea ut. Possimus debitis eaque quia tenetur totam assumenda. Velit nisi omnis eum ea.', '1991-10-24 17:33:57', NULL, '1992-10-24 17:33:57', 'assumenda blanditiis dolorum', 0.6, 0, 84),
(217, 213, 'Iste ut et ipsa nobis explicabo eaque sequi. Ut temporibus alias quibusdam accusantium sequi. Voluptate sed qui excepturi et.', '2010-06-13 14:47:49', NULL, '2011-06-13 14:47:49', 'odio consequuntur labore', 1, 1, NULL),
(219, 215, 'Similique at omnis voluptatum architecto et. Corporis ut ad nam ut omnis magni perspiciatis. Voluptas optio similique eos magnam aperiam.', '1929-04-01 17:48:15', NULL, '1930-04-01 17:48:15', 'iure provident deserunt', 1, 1, NULL),
(220, 216, 'Cumque ducimus veritatis id beatae. Ut optio itaque eius velit. Pariatur omnis tempore animi dolorem animi dolor.', '1923-05-17 18:19:43', NULL, '1924-05-17 18:19:43', 'sed quam quia', 0.5, 0, 61),
(221, 217, 'Et voluptatum voluptatem et et expedita est alias. Quas perspiciatis quae et qui deserunt non blanditiis. Dolor sit distinctio magnam.', '1916-01-30 00:57:10', NULL, '1917-01-30 00:57:10', 'ut magnam officiis', 1, 1, NULL),
(222, 218, 'Et maxime consequatur nihil necessitatibus quod quas. Non voluptas ut sunt dignissimos illo nihil. Fuga eaque doloremque ad vel.', '1973-08-17 23:26:47', NULL, '1974-08-17 23:26:47', 'numquam et voluptatem', 1, 0, 100),
(223, 219, 'In error magnam enim porro animi dicta id. Deserunt eum a doloremque porro. Doloribus dolores aut eaque aperiam.', '2000-08-26 06:06:44', NULL, '2001-08-26 06:06:44', 'tempora provident aspernatur', 1, 1, NULL),
(224, 220, 'Qui facere quo at doloribus et. Omnis ipsum cumque odio fugiat tempora assumenda omnis. Itaque voluptates reiciendis voluptatum dignissimos.', '2007-04-23 14:08:25', NULL, '2008-04-23 14:08:25', 'doloribus corrupti vel', 0.3, 0, 89),
(225, 221, 'Labore suscipit est facilis qui blanditiis cupiditate. Aut officia excepturi aut eveniet cupiditate. Eligendi voluptas hic maiores doloremque tempore.', '1946-06-27 02:44:11', NULL, '1947-06-27 02:44:11', 'atque vero et', 0.5, 1, NULL),
(226, 222, 'Voluptas esse exercitationem tempore vitae aut. Reiciendis veniam tenetur quae nesciunt aperiam ipsum numquam. Qui ullam amet quo qui quisquam necessitatibus similique perferendis.', '1951-12-13 03:33:50', NULL, '1952-12-13 03:33:50', 'hic eius similique', 0.2, 0, 147),
(227, 223, 'Et id aut qui mollitia qui quis. Ab est accusamus sequi quasi labore. Nobis aut itaque est soluta.', '1984-08-04 09:34:06', NULL, '1985-08-04 09:34:06', 'doloribus sit laborum', 0.4, 1, NULL),
(228, 224, 'Officiis deleniti fugiat expedita aliquid tenetur sint asperiores. Consectetur neque odit dignissimos exercitationem qui. Aut deserunt consequuntur eligendi rerum.', '2015-08-20 19:02:22', NULL, '2016-08-20 19:02:22', 'cumque tenetur doloremque', 0.9, 0, 64),
(229, 225, 'Eos dolores voluptatibus magni optio. Atque necessitatibus quia sunt deserunt ducimus. Eum magni aut assumenda perspiciatis sequi reprehenderit quos ea.', '1917-06-01 03:06:11', NULL, '1918-06-01 03:06:11', 'occaecati mollitia nesciunt', 0.8, 1, NULL),
(230, 226, 'Voluptatem atque voluptatem autem repellat veritatis. Inventore neque eum expedita occaecati eum. Sunt itaque non mollitia laborum qui cum pariatur nostrum.', '1962-05-13 10:28:02', NULL, '1963-05-13 10:28:02', 'sint eos ab', 0.5, 0, 68),
(231, 227, 'Sit ab saepe et ab. Debitis aut velit in id corporis. Cupiditate animi doloremque aut eos voluptatem impedit.', '1975-01-09 08:24:50', NULL, '1976-01-09 08:24:50', 'nesciunt et perferendis', 0.7, 1, NULL),
(232, 228, 'Et sint dolores soluta animi reprehenderit iure. Omnis repellat culpa praesentium quis voluptate. Et maxime qui quae delectus.', '1927-06-19 04:17:37', NULL, '1928-06-19 04:17:37', 'facere asperiores ipsa', 0.8, 0, 83),
(233, 229, 'Quia ipsa enim est nesciunt sunt sed debitis. Qui quia odio eum repudiandae totam. Ab quidem aliquid sunt sint et error ut.', '2004-12-26 22:19:51', NULL, '2005-12-26 22:19:51', 'aut aut magnam', 1, 1, NULL),
(234, 230, 'Architecto qui cum repellat earum quos. Error beatae maiores recusandae quos iste necessitatibus omnis. Et cum voluptas molestiae.', '1932-11-26 03:43:46', NULL, '1933-11-26 03:43:46', 'fuga minus doloribus', 0.6, 0, 80),
(235, 231, 'Omnis placeat sit in itaque. Ut qui voluptate non quos inventore. Perferendis ab nisi voluptates officiis.', '1953-07-01 18:07:37', NULL, '1954-07-01 18:07:37', 'et magnam sequi', 0.7, 1, NULL),
(236, 232, 'Dolorem molestias qui aspernatur quod quod incidunt sint. Ut est error reiciendis iusto. Error molestiae tempore ea.', '2014-01-10 12:10:41', NULL, '2015-01-10 12:10:41', 'beatae eaque commodi', 0.1, 0, 89),
(237, 233, 'Velit illo eum suscipit omnis. Ut sint dolores corrupti possimus. Ut numquam sit rem quia.', '1966-03-26 18:14:20', NULL, '1967-03-26 18:14:20', 'doloremque ut quae', 0.4, 1, NULL),
(238, 234, 'Consequatur ut et nesciunt nesciunt impedit quis est dignissimos. Exercitationem laborum iure quisquam eligendi vero impedit. Accusantium a amet et consequatur.', '1936-04-25 11:16:51', NULL, '1937-04-25 11:16:51', 'qui a labore', 0.9, 0, 56),
(239, 235, 'Asperiores dolor ut sint. Accusamus iure distinctio corporis cum. Nulla aut repudiandae qui minima eius.', '1920-02-09 10:52:25', NULL, '1921-02-09 10:52:25', 'nisi sed porro', 0.3, 1, NULL),
(240, 236, 'Voluptas quia quia qui odit suscipit corrupti amet cumque. Quia voluptates voluptatem sit voluptatum. Quaerat et laborum fugiat reprehenderit laboriosam suscipit ut.', '1931-06-27 04:22:24', NULL, '1932-06-27 04:22:24', 'dolores est nihil', 0.3, 0, 94),
(241, 237, 'Ratione dolorem perferendis omnis omnis corrupti quia. Aliquid aut fugit blanditiis qui. Assumenda ipsam dolorum tempore.', '1942-02-09 10:10:37', NULL, '1943-02-09 10:10:37', 'ipsum eligendi aut', 0.3, 1, NULL),
(242, 238, 'Molestiae et autem quas adipisci dolorem ipsam. Et perferendis ut numquam ut. Aut ipsum aspernatur veritatis cumque numquam omnis.', '1946-05-09 09:38:53', NULL, '1947-05-09 09:38:53', 'tempora sed quo', 0.3, 0, 114),
(243, 239, 'Est vitae molestiae minus. Doloribus eius voluptatem vel quod eveniet tenetur ipsum. Qui sed et soluta distinctio dolorem aut velit.', '1998-12-19 00:47:03', NULL, '1999-12-19 00:47:03', 'voluptatem deleniti qui', 0.9, 1, NULL),
(244, 240, 'Perspiciatis corporis perspiciatis enim cum. Et consequatur sit voluptas ducimus impedit sapiente. Fugiat dolores saepe quia nostrum excepturi non.', '1977-11-09 08:19:26', NULL, '1978-11-09 08:19:26', 'doloremque sed facere', 0.3, 0, 119),
(245, 241, 'Praesentium labore officiis distinctio saepe. Architecto pariatur mollitia asperiores ea. Nam est repudiandae commodi repellendus.', '1907-07-26 17:34:57', NULL, '1908-07-26 17:34:57', 'optio ea velit', 0.7, 1, NULL),
(246, 242, 'Eos sed dicta nam qui soluta commodi sunt consequatur. Et ex reprehenderit rem unde aliquam quod pariatur. Possimus aliquid qui saepe.', '1995-01-16 02:07:36', NULL, '1996-01-16 02:07:36', 'dolor omnis laborum', 0.5, 0, 87),
(247, 243, 'Expedita fugit magnam et quo. Non odit eos dolor corporis. Quidem aut reprehenderit ullam dignissimos iure cupiditate cumque.', '1930-08-30 21:00:14', NULL, '1931-08-30 21:00:14', 'quos magnam ut', 0.3, 1, NULL),
(248, 244, 'Perferendis unde necessitatibus earum quaerat et. Temporibus in tenetur enim blanditiis omnis nulla sunt. Nihil voluptas facere quos aperiam voluptatem vero.', '2018-10-05 09:53:42', NULL, '2019-10-05 09:53:42', 'ut corporis dolor', 0.1, 0, 56),
(249, 245, 'Odio et consectetur ratione quas qui nulla. Consequatur corrupti expedita aut dolore autem nemo soluta deserunt. Et qui quisquam soluta enim sit rerum rem.', '1936-11-24 11:09:02', NULL, '1937-11-24 11:09:02', 'quo doloribus sint', 0.3, 1, NULL),
(250, 246, 'Et odit dicta rem qui et maxime et sed. Voluptatem delectus sunt cupiditate. Voluptatem ut accusantium voluptatibus quia.', '1958-05-18 00:40:56', NULL, '1959-05-18 00:40:56', 'at voluptas id', 0.5, 0, 76),
(251, 247, 'Doloribus et voluptas voluptatem quos. Dolorum et doloremque aspernatur. Sed occaecati tempore qui illo pariatur doloremque.', '1912-01-06 21:53:40', NULL, '1913-01-06 21:53:40', 'quo soluta quis', 0.1, 1, NULL),
(252, 248, 'Quo dicta at placeat architecto omnis nisi. Voluptatem aut ipsam quisquam vitae. Cupiditate aut et et omnis harum nihil id eaque.', '2015-04-19 03:24:04', NULL, '2016-04-19 03:24:04', 'et dignissimos a', 0.8, 0, 109),
(253, 249, 'Mollitia perferendis deserunt ipsam. Qui cum et exercitationem aut quos magni. Sed veritatis sunt adipisci in est in.', '1907-12-09 11:59:24', NULL, '1908-12-09 11:59:24', 'ex aut quia', 0.1, 1, NULL),
(254, 250, 'Nesciunt cupiditate cumque mollitia. Aliquam praesentium sit fugit sit error occaecati at. Maxime voluptatem explicabo aut voluptatibus voluptatum.', '1911-12-24 14:18:40', NULL, '1912-12-24 14:18:40', 'nobis voluptate dolore', 0.8, 0, 88),
(255, 251, 'Rerum ut error voluptas placeat eius nam aspernatur. Molestias rerum voluptatum similique totam praesentium perferendis. Molestias reiciendis mollitia modi cumque ut.', '1928-10-03 02:47:16', NULL, '1929-10-03 02:47:16', 'ea tempore incidunt', 0.2, 1, NULL),
(256, 252, 'Quaerat ut nostrum placeat architecto rem. Rerum consequatur aspernatur nostrum non dolorum sed ea. Laborum distinctio modi ab omnis.', '1935-04-27 19:49:08', NULL, '1936-04-27 19:49:08', 'dicta possimus alias', 0.1, 0, 93),
(257, 253, 'Velit rem explicabo aperiam saepe. Modi quia accusamus laboriosam repudiandae qui minus quam ab. Commodi dignissimos et ab assumenda mollitia deserunt.', '1937-07-31 15:21:45', NULL, '1938-07-31 15:21:45', 'et ea qui', 0.2, 1, NULL),
(258, 254, 'Saepe quia rerum consequatur odit ut. Minus assumenda perspiciatis totam. Aut quia voluptate alias dolor dolorum soluta accusantium.', '2001-07-10 16:08:45', NULL, '2002-07-10 16:08:45', 'sed sint perferendis', 0.7, 0, 137),
(259, 255, 'Et atque voluptatibus illum. Deserunt et sapiente totam autem repudiandae numquam. Laboriosam harum reprehenderit esse voluptatem consectetur sint ut.', '1941-04-24 09:49:50', NULL, '1942-04-24 09:49:50', 'impedit qui dignissimos', 0.1, 1, NULL),
(260, 256, 'Tenetur libero autem iusto quia molestiae rerum rerum nihil. Quia et eaque vero odit. Voluptatem est sed laboriosam autem.', '1921-05-30 05:27:52', NULL, '1922-05-30 05:27:52', 'excepturi asperiores ipsam', 0.3, 0, 128),
(261, 257, 'Quo qui commodi harum expedita. Quaerat natus deserunt quis et dolore velit sequi. Et vel aut voluptates molestiae labore molestias.', '1916-03-21 12:49:17', NULL, '1917-03-21 12:49:17', 'aut animi nobis', 0.7, 1, NULL),
(262, 258, 'Eligendi enim ut perferendis minus et voluptatibus impedit. Molestiae maiores sapiente occaecati officia dolor. Repellat blanditiis officia omnis expedita.', '1937-03-04 16:11:33', NULL, '1938-03-04 16:11:33', 'illo consectetur maxime', 0.4, 0, 144),
(263, 259, 'Adipisci exercitationem consequatur aperiam ut cum atque. Dolorum minus deserunt sit ipsam alias exercitationem mollitia. Facere maiores dolorem dolorum expedita mollitia in nemo.', '1971-07-26 15:35:22', NULL, '1972-07-26 15:35:22', 'minus molestiae magni', 0.6, 1, NULL),
(264, 260, 'Quia quis et quo et quidem necessitatibus quia libero. Dolorum incidunt excepturi laborum officiis atque sunt. Ut tempora officia voluptates omnis.', '2015-03-11 10:12:42', NULL, '2016-03-11 10:12:42', 'facere dolorem tempore', 0.2, 0, 94),
(265, 261, 'Atque in temporibus accusantium consequatur. Distinctio odio ipsum recusandae labore. Molestias in quaerat sit enim.', '1925-01-24 01:27:12', NULL, '1926-01-24 01:27:12', 'qui est qui', 0.5, 1, NULL),
(266, 262, 'Blanditiis eos dolorem quasi et totam hic neque. Est quis numquam praesentium minus voluptatibus molestias qui voluptatibus. Quo assumenda sed quaerat doloribus voluptate ut.', '1915-01-03 14:57:11', NULL, '1916-01-03 14:57:11', 'rerum dolorum sed', 1, 0, 130),
(267, 263, 'Alias facilis et ab quaerat est id. Et eum hic repudiandae ut dicta. Quia hic et rerum molestiae rem tempore maxime.', '1924-12-21 21:37:28', NULL, '1925-12-21 21:37:28', 'ipsum explicabo corporis', 0.2, 1, NULL),
(268, 264, 'Dolorum facere amet accusantium. Ea deleniti et magni nesciunt ut esse asperiores. Ratione beatae deleniti aut delectus eligendi et unde voluptas.', '1915-12-21 20:00:43', NULL, '1916-12-21 20:00:43', 'aut voluptatem incidunt', 1, 0, 137),
(269, 265, 'Aut eaque nobis repellendus beatae molestiae. Quia cupiditate et necessitatibus voluptatibus molestias sit enim. Natus omnis perferendis aliquam adipisci occaecati est.', '1914-03-07 23:41:11', NULL, '1915-03-07 23:41:11', 'veniam dicta temporibus', 0.9, 1, NULL),
(270, 266, 'Accusantium qui sit ab. Molestias vitae pariatur occaecati alias libero est. Rem sequi delectus dolor mollitia sed eius nam.', '1946-03-03 12:53:06', NULL, '1947-03-03 12:53:06', 'voluptatem minus itaque', 0.3, 0, 66),
(271, 267, 'Similique deleniti et maiores nisi quibusdam nihil dolor eveniet. Sint ipsam cum non cupiditate deleniti quia. Vero autem modi illo ut.', '1930-08-04 10:49:25', NULL, '1931-08-04 10:49:25', 'quia molestiae cum', 0.6, 1, NULL),
(272, 268, 'Numquam occaecati nostrum quos qui dolor in. Doloremque vero a et. Omnis ut animi enim beatae culpa ipsa ea.', '1978-01-02 09:56:32', NULL, '1979-01-02 09:56:32', 'reprehenderit aut odit', 0.2, 0, 53),
(273, 269, 'Dignissimos culpa dolor facilis excepturi ipsum voluptatem placeat est. Quibusdam quia omnis ipsam at ullam sint. Temporibus sint architecto et voluptatem.', '2018-03-01 20:14:05', NULL, '2019-03-01 20:14:05', 'at voluptas rem', 0.5, 1, NULL),
(274, 270, 'Iste aut quod et numquam eius. Molestiae delectus quas laboriosam perspiciatis molestiae. Possimus suscipit quaerat perferendis accusamus corporis molestiae.', '1933-03-14 14:47:51', NULL, '1934-03-14 14:47:51', 'unde aperiam laborum', 0.5, 0, 107),
(275, 271, 'Dicta repellendus est aspernatur quod quis quia itaque. Est ut dicta alias sed illum et. Quia aut doloremque quisquam consectetur sunt rerum sit.', '1907-04-06 04:10:11', NULL, '1908-04-06 04:10:11', 'quas quae ut', 0.4, 1, NULL),
(276, 272, 'Laboriosam dolorem temporibus nobis omnis quia. Voluptate a nostrum repudiandae id. Vel commodi libero unde tempora ipsum.', '1951-01-10 02:53:08', NULL, '1952-01-10 02:53:08', 'quisquam fuga vitae', 0.3, 0, 132),
(277, 273, 'Animi labore in et quo est odit. Aut corporis voluptatibus aliquam ducimus et quia. Modi quasi libero nostrum sed alias.', '1970-12-23 11:12:10', NULL, '1971-12-23 11:12:10', 'et et nulla', 0.8, 1, NULL),
(278, 274, 'Ut nihil illum repellendus sint excepturi. Illo nostrum autem iste. Aut et dolorum ipsam.', '1940-05-16 23:58:01', NULL, '1941-05-16 23:58:01', 'iusto cum repudiandae', 0.5, 0, 148),
(279, 275, 'Corrupti minima similique eum unde assumenda. Doloribus explicabo dolores necessitatibus voluptate magnam ab itaque. Nemo rerum iure iusto velit.', '2013-10-29 16:26:21', NULL, '2014-10-29 16:26:21', 'est est qui', 0.7, 1, NULL),
(280, 276, 'Aliquam accusantium quas reprehenderit quam est perferendis. Quidem autem asperiores dolorem nihil. Non minima est molestias dignissimos.', '1940-03-10 15:53:21', NULL, '1941-03-10 15:53:21', 'accusantium qui ut', 0.6, 0, 102),
(281, 277, 'Tempore aut mollitia consequatur minus. Fuga enim pariatur et. Quis dolores sit assumenda vel quia ut.', '1928-05-05 19:40:31', NULL, '1929-05-05 19:40:31', 'non rem error', 1, 1, NULL),
(282, 278, 'Ut provident veritatis et libero. Aliquam sit beatae illum dolore quibusdam. Autem iure et sint perspiciatis et accusantium non.', '1936-10-19 00:20:04', NULL, '1937-10-19 00:20:04', 'corporis qui veniam', 1, 0, 136),
(283, 279, 'Molestiae velit quos fuga qui dolores voluptate suscipit. Iure voluptatem est alias nihil esse. Occaecati similique quod explicabo quia.', '1944-02-20 14:36:51', NULL, '1945-02-20 14:36:51', 'voluptatem aperiam expedita', 0.9, 1, NULL),
(284, 280, 'Aliquam quibusdam consectetur consequatur fugit assumenda est autem et. Dolor dolores et omnis assumenda. Sit quos voluptatem esse ipsum.', '1928-07-12 16:06:27', NULL, '1929-07-12 16:06:27', 'at eveniet neque', 0.1, 0, 128),
(285, 281, 'Ratione qui commodi delectus. Optio officiis hic placeat dolorem aliquam consequatur. Eius et quidem quo quia aut itaque totam repellat.', '2003-12-31 00:12:06', NULL, '2004-12-31 00:12:06', 'praesentium est est', 0.7, 1, NULL),
(286, 282, 'Voluptatem aliquam doloremque mollitia quo quod eos. Sit alias est assumenda et vero dolorem deserunt. Quis nesciunt rerum cumque voluptas.', '1962-08-13 22:57:27', NULL, '1963-08-13 22:57:27', 'velit aperiam sit', 0.9, 0, 52),
(287, 283, 'Ut autem perspiciatis et aut. Maiores veritatis nam ut. Cupiditate soluta perspiciatis mollitia hic perferendis qui.', '1962-04-25 17:02:00', NULL, '1963-04-25 17:02:00', 'voluptates porro aperiam', 0.5, 1, NULL),
(288, 284, 'Consequatur quasi fugit est architecto. Consequatur vel quidem aperiam corrupti fugiat mollitia. Facilis blanditiis corrupti quo.', '2005-02-26 22:37:11', NULL, '2006-02-26 22:37:11', 'eos ut quis', 0.7, 0, 101),
(289, 285, 'Beatae nihil esse officiis necessitatibus qui repudiandae. Pariatur ut laborum minus nemo facere. Quo sequi quaerat aut explicabo sapiente iste.', '1984-06-13 02:21:37', NULL, '1985-06-13 02:21:37', 'vel pariatur ipsam', 0.9, 1, NULL),
(290, 286, 'Sed qui quis alias temporibus nam reprehenderit. Ratione incidunt non nam quos accusantium dolorem quod. Accusantium quisquam fugiat fugit blanditiis illo quos omnis.', '1913-03-02 06:58:19', NULL, '1914-03-02 06:58:19', 'exercitationem cupiditate facilis', 0.5, 0, 122),
(291, 287, 'Deleniti et a est. Nesciunt autem natus dignissimos ipsam incidunt tempora. Quia tempore eos voluptatem nihil.', '1951-09-22 12:05:18', NULL, '1952-09-22 12:05:18', 'repudiandae enim cumque', 0.4, 1, NULL),
(292, 288, 'Unde iusto nemo et. Eligendi aliquid qui ut a consequatur sequi sed. Et incidunt fugit modi sequi.', '1907-04-22 02:42:52', NULL, '1908-04-22 02:42:52', 'rerum minima ratione', 0.3, 0, 143),
(293, 289, 'Vel magni laudantium rerum optio. Impedit qui qui eos quia et est possimus. Voluptatem earum ratione sequi et beatae qui et.', '1926-08-19 02:40:59', NULL, '1927-08-19 02:40:59', 'architecto tenetur atque', 0.9, 1, NULL),
(294, 290, 'Sit magnam qui sit aut vero nisi. Rerum est provident nobis ad totam enim. Velit consequuntur blanditiis sunt omnis delectus enim eveniet.', '1998-04-03 07:08:59', NULL, '1999-04-03 07:08:59', 'esse blanditiis qui', 0.7, 0, 53),
(295, 291, 'Nulla inventore autem soluta et. Ea dolore accusamus adipisci rerum. Qui assumenda eveniet pariatur voluptates.', '1982-09-23 07:15:35', NULL, '1983-09-23 07:15:35', 'non et et', 0.3, 1, NULL),
(296, 292, 'Adipisci rerum laboriosam cum quam sequi id corrupti est. Voluptatem corporis praesentium ut non consequatur itaque. Asperiores praesentium expedita recusandae voluptatem.', '1917-12-06 05:50:58', NULL, '1918-12-06 05:50:58', 'molestias sapiente delectus', 0.8, 0, 52),
(297, 293, 'Possimus similique aspernatur alias quibusdam libero in qui. Ab id voluptas quam sint veritatis repellendus enim. Qui aut rerum dolorum non.', '1953-05-11 10:08:03', NULL, '1954-05-11 10:08:03', 'deleniti nulla nostrum', 0.5, 1, NULL),
(298, 294, 'Recusandae atque perferendis tempora esse non beatae. Et soluta est dolorem eius quia sapiente. Facilis ipsam itaque voluptatem.', '1903-10-08 14:13:30', NULL, '1904-10-08 14:13:30', 'ut voluptates sed', 0.6, 0, 101),
(299, 295, 'Suscipit nobis facere itaque aliquam non. Aut commodi quos porro. Voluptatem porro optio quisquam est.', '1973-01-09 04:11:56', NULL, '1974-01-09 04:11:56', 'adipisci omnis non', 0.4, 1, NULL),
(300, 296, 'Maxime enim saepe quasi rem ad qui necessitatibus ex. Omnis optio qui reprehenderit eum. Odit aspernatur reprehenderit est et veritatis odit.', '1953-03-21 17:58:12', NULL, '1954-03-21 17:58:12', 'delectus aut temporibus', 0.9, 0, 124),
(301, 297, 'Recusandae nam dolorem libero eum. Neque aut laboriosam dolorem quo tempore voluptatibus aut. Minima eius quis tenetur a sunt neque aut animi.', '1997-03-16 06:04:56', NULL, '1998-03-16 06:04:56', 'laboriosam adipisci hic', 0.1, 1, NULL),
(302, 298, 'Odit nobis soluta aut ipsum eos sint est. Ut perspiciatis ducimus minus quis velit aspernatur ea totam. Repellendus nihil consequatur quo dolor.', '1963-06-21 20:01:24', NULL, '1964-06-21 20:01:24', 'aut eos ullam', 0.6, 0, 111),
(303, 299, 'Non corrupti eveniet consequatur ut id provident et. Voluptas et sit commodi temporibus. Repudiandae sed quibusdam quia dolor ut.', '1984-07-16 18:26:10', NULL, '1985-07-16 18:26:10', 'deleniti temporibus dolorem', 1, 1, NULL),
(304, 300, 'Qui beatae corrupti quae et rem et. Ut aliquid et distinctio vero amet ad ipsum sunt. Asperiores ex omnis molestiae temporibus enim vero quia.', '1999-10-24 00:39:59', NULL, '2000-10-24 00:39:59', 'ad rerum corrupti', 0.2, 0, 67),
(305, 301, 'Voluptatem dolor accusamus repudiandae sit. Dolorem modi ipsa tempore ab magnam delectus. Impedit ut quasi dicta eum numquam non modi.', '2006-03-09 10:39:11', NULL, '2007-03-09 10:39:11', 'tenetur nam vero', 0.5, 1, NULL),
(306, 302, 'Sunt aut adipisci corrupti quia maiores. Aliquid minima voluptatem eum aliquam accusantium cum beatae. Animi rem culpa omnis aut soluta necessitatibus.', '1985-10-20 04:58:52', NULL, '1986-10-20 04:58:52', 'est ut eius', 0.5, 0, 122),
(307, 303, 'Saepe sed nesciunt ut reiciendis eaque. Earum ut et optio totam ducimus. Dolorem labore eius facere itaque recusandae.', '1914-06-06 05:22:10', NULL, '1915-06-06 05:22:10', 'non ea occaecati', 0.7, 1, NULL),
(308, 304, 'La description liée au véhicule de la nouvelle annonce', '2019-04-14 10:37:37', NULL, '2020-04-14 10:37:37', 'Le titre de la nouvelle annonce', 0.6, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `duration`
--

CREATE TABLE `duration` (
  `id` int(11) NOT NULL,
  `duration` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `duration`
--

INSERT INTO `duration` (`id`, `duration`) VALUES
(1, 'Week-end'),
(2, 'Long week-end'),
(4, 'Semaine');

-- --------------------------------------------------------

--
-- Structure de la table `equipment`
--

CREATE TABLE `equipment` (
  `id` int(11) NOT NULL,
  `equipment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `belonging` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `equipment`
--

INSERT INTO `equipment` (`id`, `equipment`, `belonging`) VALUES
(2, 'Climatisation', 'Cellule'),
(4, 'Airbag', 'Porteur'),
(5, 'Régulateur de vitesse', 'Porteur');

-- --------------------------------------------------------

--
-- Structure de la table `equipment_vehicle`
--

CREATE TABLE `equipment_vehicle` (
  `equipment_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `equipment_vehicle`
--

INSERT INTO `equipment_vehicle` (`equipment_id`, `vehicle_id`) VALUES
(2, 1),
(2, 2),
(2, 103),
(2, 205),
(2, 207),
(2, 209),
(2, 211),
(2, 213),
(2, 215),
(2, 217),
(2, 219),
(2, 221),
(2, 223),
(2, 225),
(2, 227),
(2, 229),
(2, 231),
(2, 233),
(2, 235),
(2, 237),
(2, 239),
(2, 241),
(2, 243),
(2, 245),
(2, 247),
(2, 249),
(2, 251),
(2, 253),
(2, 255),
(2, 257),
(2, 259),
(2, 261),
(2, 263),
(2, 265),
(2, 267),
(2, 269),
(2, 271),
(2, 273),
(2, 275),
(2, 277),
(2, 279),
(2, 281),
(2, 283),
(2, 285),
(2, 287),
(2, 289),
(2, 291),
(2, 293),
(2, 295),
(2, 297),
(2, 299),
(2, 301),
(2, 303),
(2, 304),
(4, 1),
(4, 2),
(4, 103),
(4, 206),
(4, 209),
(4, 216),
(4, 217),
(4, 224),
(4, 225),
(4, 229),
(4, 231),
(4, 248),
(4, 258),
(4, 262),
(4, 264),
(4, 267),
(4, 269),
(4, 271),
(4, 275),
(4, 276),
(4, 287),
(4, 297),
(4, 303),
(4, 304),
(5, 2);

-- --------------------------------------------------------

--
-- Structure de la table `fuel`
--

CREATE TABLE `fuel` (
  `id` int(11) NOT NULL,
  `fuel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fuel`
--

INSERT INTO `fuel` (`id`, `fuel`) VALUES
(1, 'Electricité'),
(2, 'Essence'),
(3, 'Diesel'),
(4, 'L.P.G.');

-- --------------------------------------------------------

--
-- Structure de la table `included_mileage`
--

CREATE TABLE `included_mileage` (
  `id` int(11) NOT NULL,
  `mileage` int(11) NOT NULL,
  `advert_id` int(11) NOT NULL,
  `duration_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `included_mileage`
--

INSERT INTO `included_mileage` (`id`, `mileage`, `advert_id`, `duration_id`) VALUES
(1, 600, 6, 1),
(2, 800, 6, 2),
(3, 1000, 6, 4),
(304, 600, 5, 1),
(305, 2000, 5, 4),
(306, 2433, 208, 1),
(307, 1068, 208, 2),
(308, 1086, 208, 4),
(309, 2855, 209, 1),
(310, 1484, 209, 2),
(311, 2533, 209, 4),
(312, 1236, 210, 1),
(313, 1211, 210, 2),
(314, 963, 210, 4),
(315, 1384, 211, 1),
(316, 2198, 211, 2),
(317, 2379, 211, 4),
(318, 2680, 212, 1),
(319, 1853, 212, 2),
(320, 1423, 212, 4),
(321, 2170, 213, 1),
(322, 2770, 213, 2),
(323, 612, 213, 4),
(324, 1542, 214, 1),
(325, 1887, 214, 2),
(326, 1813, 214, 4),
(327, 987, 215, 1),
(328, 1530, 215, 2),
(329, 1277, 215, 4),
(330, 1351, 216, 1),
(331, 2527, 216, 2),
(332, 2959, 216, 4),
(333, 2794, 217, 1),
(334, 1218, 217, 2),
(335, 1552, 217, 4),
(339, 821, 219, 1),
(340, 2370, 219, 2),
(341, 806, 219, 4),
(342, 2865, 220, 1),
(343, 2432, 220, 2),
(344, 2124, 220, 4),
(345, 2086, 221, 1),
(346, 1708, 221, 2),
(347, 653, 221, 4),
(348, 664, 222, 1),
(349, 1214, 222, 2),
(350, 825, 222, 4),
(351, 2266, 223, 1),
(352, 2959, 223, 2),
(353, 2341, 223, 4),
(354, 1618, 224, 1),
(355, 1870, 224, 2),
(356, 2488, 224, 4),
(357, 2733, 225, 1),
(358, 752, 225, 2),
(359, 2162, 225, 4),
(360, 1092, 226, 1),
(361, 1408, 226, 2),
(362, 1358, 226, 4),
(363, 1245, 227, 1),
(364, 1923, 227, 2),
(365, 2163, 227, 4),
(366, 1522, 228, 1),
(367, 2570, 228, 2),
(368, 1023, 228, 4),
(369, 572, 229, 1),
(370, 2235, 229, 2),
(371, 2828, 229, 4),
(372, 1433, 230, 1),
(373, 2723, 230, 2),
(374, 2812, 230, 4),
(375, 1489, 231, 1),
(376, 645, 231, 2),
(377, 2253, 231, 4),
(378, 1577, 232, 1),
(379, 2323, 232, 2),
(380, 2885, 232, 4),
(381, 2190, 233, 1),
(382, 2872, 233, 2),
(383, 1222, 233, 4),
(384, 2156, 234, 1),
(385, 2794, 234, 2),
(386, 1974, 234, 4),
(387, 2144, 235, 1),
(388, 2177, 235, 2),
(389, 2156, 235, 4),
(390, 2894, 236, 1),
(391, 2489, 236, 2),
(392, 1485, 236, 4),
(393, 507, 237, 1),
(394, 2229, 237, 2),
(395, 2762, 237, 4),
(396, 2861, 238, 1),
(397, 2498, 238, 2),
(398, 1041, 238, 4),
(399, 2618, 239, 1),
(400, 1756, 239, 2),
(401, 2119, 239, 4),
(402, 502, 240, 1),
(403, 1898, 240, 2),
(404, 2291, 240, 4),
(405, 1110, 241, 1),
(406, 685, 241, 2),
(407, 2306, 241, 4),
(408, 1868, 242, 1),
(409, 923, 242, 2),
(410, 1986, 242, 4),
(411, 1591, 243, 1),
(412, 1560, 243, 2),
(413, 2636, 243, 4),
(414, 2952, 244, 1),
(415, 2954, 244, 2),
(416, 847, 244, 4),
(417, 636, 245, 1),
(418, 1198, 245, 2),
(419, 598, 245, 4),
(420, 1707, 246, 1),
(421, 1224, 246, 2),
(422, 1910, 246, 4),
(423, 2061, 247, 1),
(424, 1762, 247, 2),
(425, 950, 247, 4),
(426, 1202, 248, 1),
(427, 971, 248, 2),
(428, 2682, 248, 4),
(429, 2602, 249, 1),
(430, 2701, 249, 2),
(431, 2238, 249, 4),
(432, 1302, 250, 1),
(433, 2738, 250, 2),
(434, 1924, 250, 4),
(435, 1504, 251, 1),
(436, 2192, 251, 2),
(437, 2101, 251, 4),
(438, 629, 252, 1),
(439, 882, 252, 2),
(440, 1025, 252, 4),
(441, 554, 253, 1),
(442, 2208, 253, 2),
(443, 665, 253, 4),
(444, 707, 254, 1),
(445, 2478, 254, 2),
(446, 2884, 254, 4),
(447, 1477, 255, 1),
(448, 776, 255, 2),
(449, 1576, 255, 4),
(450, 2525, 256, 1),
(451, 1678, 256, 2),
(452, 1710, 256, 4),
(453, 1353, 257, 1),
(454, 2504, 257, 2),
(455, 2915, 257, 4),
(456, 2166, 258, 1),
(457, 953, 258, 2),
(458, 2119, 258, 4),
(459, 2593, 259, 1),
(460, 2489, 259, 2),
(461, 2602, 259, 4),
(462, 1916, 260, 1),
(463, 1157, 260, 2),
(464, 1836, 260, 4),
(465, 1970, 261, 1),
(466, 1611, 261, 2),
(467, 2502, 261, 4),
(468, 2755, 262, 1),
(469, 1816, 262, 2),
(470, 1445, 262, 4),
(471, 1637, 263, 1),
(472, 2975, 263, 2),
(473, 808, 263, 4),
(474, 2657, 264, 1),
(475, 1622, 264, 2),
(476, 1892, 264, 4),
(477, 1980, 265, 1),
(478, 950, 265, 2),
(479, 2547, 265, 4),
(480, 2498, 266, 1),
(481, 2216, 266, 2),
(482, 1553, 266, 4),
(483, 2784, 267, 1),
(484, 1095, 267, 2),
(485, 1156, 267, 4),
(486, 2205, 268, 1),
(487, 2609, 268, 2),
(488, 2145, 268, 4),
(489, 898, 269, 1),
(490, 1616, 269, 2),
(491, 2756, 269, 4),
(492, 610, 270, 1),
(493, 2532, 270, 2),
(494, 781, 270, 4),
(495, 2031, 271, 1),
(496, 2932, 271, 2),
(497, 2124, 271, 4),
(498, 1825, 272, 1),
(499, 1112, 272, 2),
(500, 1753, 272, 4),
(501, 1108, 273, 1),
(502, 1750, 273, 2),
(503, 1073, 273, 4),
(504, 1556, 274, 1),
(505, 2797, 274, 2),
(506, 2290, 274, 4),
(507, 1716, 275, 1),
(508, 714, 275, 2),
(509, 1054, 275, 4),
(510, 1969, 276, 1),
(511, 2834, 276, 2),
(512, 763, 276, 4),
(513, 1498, 277, 1),
(514, 1188, 277, 2),
(515, 1436, 277, 4),
(516, 1599, 278, 1),
(517, 895, 278, 2),
(518, 859, 278, 4),
(519, 1298, 279, 1),
(520, 2358, 279, 2),
(521, 2890, 279, 4),
(522, 959, 280, 1),
(523, 2525, 280, 2),
(524, 2491, 280, 4),
(525, 2058, 281, 1),
(526, 2191, 281, 2),
(527, 2138, 281, 4),
(528, 1768, 282, 1),
(529, 630, 282, 2),
(530, 1346, 282, 4),
(531, 2757, 283, 1),
(532, 2121, 283, 2),
(533, 1875, 283, 4),
(534, 1529, 284, 1),
(535, 1204, 284, 2),
(536, 661, 284, 4),
(537, 2298, 285, 1),
(538, 2879, 285, 2),
(539, 1231, 285, 4),
(540, 1569, 286, 1),
(541, 1328, 286, 2),
(542, 568, 286, 4),
(543, 1568, 287, 1),
(544, 1761, 287, 2),
(545, 747, 287, 4),
(546, 623, 288, 1),
(547, 1848, 288, 2),
(548, 1550, 288, 4),
(549, 928, 289, 1),
(550, 2388, 289, 2),
(551, 1175, 289, 4),
(552, 2360, 290, 1),
(553, 2838, 290, 2),
(554, 2114, 290, 4),
(555, 1361, 291, 1),
(556, 2169, 291, 2),
(557, 2527, 291, 4),
(558, 514, 292, 1),
(559, 2918, 292, 2),
(560, 1567, 292, 4),
(561, 1544, 293, 1),
(562, 2091, 293, 2),
(563, 857, 293, 4),
(564, 1233, 294, 1),
(565, 1561, 294, 2),
(566, 971, 294, 4),
(567, 769, 295, 1),
(568, 1301, 295, 2),
(569, 557, 295, 4),
(570, 2076, 296, 1),
(571, 2973, 296, 2),
(572, 1065, 296, 4),
(573, 2092, 297, 1),
(574, 2510, 297, 2),
(575, 2422, 297, 4),
(576, 2642, 298, 1),
(577, 1265, 298, 2),
(578, 2345, 298, 4),
(579, 1406, 299, 1),
(580, 1004, 299, 2),
(581, 2767, 299, 4),
(582, 721, 300, 1),
(583, 2292, 300, 2),
(584, 602, 300, 4),
(585, 1029, 301, 1),
(586, 665, 301, 2),
(587, 544, 301, 4),
(588, 2810, 302, 1),
(589, 792, 302, 2),
(590, 2715, 302, 4),
(591, 2069, 303, 1),
(592, 1569, 303, 2),
(593, 2647, 303, 4),
(594, 543, 304, 1),
(595, 1033, 304, 2),
(596, 1562, 304, 4),
(597, 510, 305, 1),
(598, 1194, 305, 2),
(599, 2425, 305, 4),
(600, 2619, 306, 1),
(601, 1851, 306, 2),
(602, 1083, 306, 4),
(603, 2349, 307, 1),
(604, 1097, 307, 2),
(605, 2958, 307, 4),
(606, 2000, 308, 4);

-- --------------------------------------------------------

--
-- Structure de la table `insurance`
--

CREATE TABLE `insurance` (
  `id` int(11) NOT NULL,
  `advert_id` int(11) NOT NULL,
  `deductible` int(11) NOT NULL,
  `included` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `insurance`
--

INSERT INTO `insurance` (`id`, `advert_id`, `deductible`, `included`) VALUES
(1, 6, 1250, 0),
(102, 5, 1230, 0),
(103, 208, 1412, 0),
(104, 209, 1227, 1),
(105, 210, 843, 0),
(106, 211, 1719, 1),
(107, 212, 1662, 0),
(108, 213, 889, 1),
(109, 214, 1906, 0),
(110, 215, 1655, 1),
(111, 216, 522, 0),
(112, 217, 1936, 1),
(114, 219, 1002, 1),
(115, 220, 703, 0),
(116, 221, 551, 1),
(117, 222, 333, 0),
(118, 223, 647, 1),
(119, 224, 758, 0),
(120, 225, 1450, 1),
(121, 226, 1534, 0),
(122, 227, 1568, 1),
(123, 228, 692, 0),
(124, 229, 1523, 1),
(125, 230, 1915, 0),
(126, 231, 1775, 1),
(127, 232, 1258, 0),
(128, 233, 278, 1),
(129, 234, 1344, 0),
(130, 235, 404, 1),
(131, 236, 1911, 0),
(132, 237, 1579, 1),
(133, 238, 1046, 0),
(134, 239, 1603, 1),
(135, 240, 1527, 0),
(136, 241, 1288, 1),
(137, 242, 1228, 0),
(138, 243, 1114, 1),
(139, 244, 822, 0),
(140, 245, 483, 1),
(141, 246, 1652, 0),
(142, 247, 1228, 1),
(143, 248, 1393, 0),
(144, 249, 977, 1),
(145, 250, 555, 0),
(146, 251, 1432, 1),
(147, 252, 1708, 0),
(148, 253, 837, 1),
(149, 254, 924, 0),
(150, 255, 760, 1),
(151, 256, 1164, 0),
(152, 257, 1590, 1),
(153, 258, 1414, 0),
(154, 259, 396, 1),
(155, 260, 290, 0),
(156, 261, 823, 1),
(157, 262, 1922, 0),
(158, 263, 340, 1),
(159, 264, 1285, 0),
(160, 265, 938, 1),
(161, 266, 997, 0),
(162, 267, 747, 1),
(163, 268, 1034, 0),
(164, 269, 1868, 1),
(165, 270, 1950, 0),
(166, 271, 1723, 1),
(167, 272, 362, 0),
(168, 273, 1142, 1),
(169, 274, 1295, 0),
(170, 275, 663, 1),
(171, 276, 1183, 0),
(172, 277, 771, 1),
(173, 278, 998, 0),
(174, 279, 1075, 1),
(175, 280, 1634, 0),
(176, 281, 1188, 1),
(177, 282, 1962, 0),
(178, 283, 1734, 1),
(179, 284, 430, 0),
(180, 285, 848, 1),
(181, 286, 1774, 0),
(182, 287, 1084, 1),
(183, 288, 320, 0),
(184, 289, 1944, 1),
(185, 290, 985, 0),
(186, 291, 1526, 1),
(187, 292, 847, 0),
(188, 293, 542, 1),
(189, 294, 1728, 0),
(190, 295, 702, 1),
(191, 296, 297, 0),
(192, 297, 599, 1),
(193, 298, 595, 0),
(194, 299, 896, 1),
(195, 300, 509, 0),
(196, 301, 1321, 1),
(197, 302, 889, 0),
(198, 303, 489, 1),
(199, 304, 785, 0),
(200, 305, 1196, 1),
(201, 306, 1460, 0),
(202, 307, 556, 1),
(203, 308, 1250, 1);

-- --------------------------------------------------------

--
-- Structure de la table `insurance_price`
--

CREATE TABLE `insurance_price` (
  `id` int(11) NOT NULL,
  `duration_id` int(11) NOT NULL,
  `insurance_id` int(11) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `insurance_price`
--

INSERT INTO `insurance_price` (`id`, `duration_id`, `insurance_id`, `price`) VALUES
(1, 1, 1, 50),
(2, 2, 1, 80),
(3, 4, 1, 100),
(154, 1, 102, 400),
(155, 4, 102, 1000),
(156, 1, 103, 76),
(157, 2, 103, 54),
(158, 4, 103, 141),
(159, 1, 105, 77),
(160, 2, 105, 121),
(161, 4, 105, 58),
(162, 1, 107, 138),
(163, 2, 107, 73),
(164, 4, 107, 133),
(165, 1, 109, 144),
(166, 2, 109, 92),
(167, 4, 109, 91),
(168, 1, 111, 95),
(169, 2, 111, 93),
(170, 4, 111, 108),
(174, 1, 115, 145),
(175, 2, 115, 136),
(176, 4, 115, 64),
(177, 1, 117, 92),
(178, 2, 117, 148),
(179, 4, 117, 125),
(180, 1, 119, 73),
(181, 2, 119, 146),
(182, 4, 119, 143),
(183, 1, 121, 69),
(184, 2, 121, 60),
(185, 4, 121, 108),
(186, 1, 123, 114),
(187, 2, 123, 51),
(188, 4, 123, 85),
(189, 1, 125, 103),
(190, 2, 125, 73),
(191, 4, 125, 92),
(192, 1, 127, 64),
(193, 2, 127, 126),
(194, 4, 127, 77),
(195, 1, 129, 74),
(196, 2, 129, 104),
(197, 4, 129, 130),
(198, 1, 131, 126),
(199, 2, 131, 62),
(200, 4, 131, 146),
(201, 1, 133, 107),
(202, 2, 133, 143),
(203, 4, 133, 122),
(204, 1, 135, 122),
(205, 2, 135, 94),
(206, 4, 135, 115),
(207, 1, 137, 60),
(208, 2, 137, 67),
(209, 4, 137, 100),
(210, 1, 139, 78),
(211, 2, 139, 97),
(212, 4, 139, 82),
(213, 1, 141, 104),
(214, 2, 141, 147),
(215, 4, 141, 136),
(216, 1, 143, 130),
(217, 2, 143, 125),
(218, 4, 143, 64),
(219, 1, 145, 59),
(220, 2, 145, 96),
(221, 4, 145, 133),
(222, 1, 147, 61),
(223, 2, 147, 140),
(224, 4, 147, 112),
(225, 1, 149, 112),
(226, 2, 149, 125),
(227, 4, 149, 141),
(228, 1, 151, 69),
(229, 2, 151, 129),
(230, 4, 151, 141),
(231, 1, 153, 67),
(232, 2, 153, 83),
(233, 4, 153, 60),
(234, 1, 155, 96),
(235, 2, 155, 150),
(236, 4, 155, 135),
(237, 1, 157, 77),
(238, 2, 157, 131),
(239, 4, 157, 98),
(240, 1, 159, 79),
(241, 2, 159, 90),
(242, 4, 159, 53),
(243, 1, 161, 106),
(244, 2, 161, 141),
(245, 4, 161, 102),
(246, 1, 163, 132),
(247, 2, 163, 66),
(248, 4, 163, 141),
(249, 1, 165, 79),
(250, 2, 165, 137),
(251, 4, 165, 138),
(252, 1, 167, 98),
(253, 2, 167, 123),
(254, 4, 167, 126),
(255, 1, 169, 59),
(256, 2, 169, 82),
(257, 4, 169, 75),
(258, 1, 171, 83),
(259, 2, 171, 124),
(260, 4, 171, 96),
(261, 1, 173, 92),
(262, 2, 173, 116),
(263, 4, 173, 77),
(264, 1, 175, 107),
(265, 2, 175, 149),
(266, 4, 175, 106),
(267, 1, 177, 125),
(268, 2, 177, 64),
(269, 4, 177, 119),
(270, 1, 179, 132),
(271, 2, 179, 145),
(272, 4, 179, 55),
(273, 1, 181, 116),
(274, 2, 181, 147),
(275, 4, 181, 100),
(276, 1, 183, 114),
(277, 2, 183, 143),
(278, 4, 183, 52),
(279, 1, 185, 128),
(280, 2, 185, 105),
(281, 4, 185, 93),
(282, 1, 187, 126),
(283, 2, 187, 140),
(284, 4, 187, 143),
(285, 1, 189, 63),
(286, 2, 189, 147),
(287, 4, 189, 63),
(288, 1, 191, 96),
(289, 2, 191, 145),
(290, 4, 191, 133),
(291, 1, 193, 50),
(292, 2, 193, 58),
(293, 4, 193, 102),
(294, 1, 195, 114),
(295, 2, 195, 146),
(296, 4, 195, 70),
(297, 1, 197, 106),
(298, 2, 197, 123),
(299, 4, 197, 70),
(300, 1, 199, 55),
(301, 2, 199, 105),
(302, 4, 199, 57),
(303, 1, 201, 123),
(304, 2, 201, 74),
(305, 4, 201, 79);

-- --------------------------------------------------------

--
-- Structure de la table `mark`
--

CREATE TABLE `mark` (
  `id` int(11) NOT NULL,
  `mark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mark`
--

INSERT INTO `mark` (`id`, `mark`) VALUES
(1, 'ACE Caravans'),
(2, 'Alcar'),
(3, 'Adria'),
(4, 'Alpes Camping Car');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20190306134339'),
('20190313162541'),
('20190313163852'),
('20190315125313'),
('20190317114824'),
('20190317120141'),
('20190317120744'),
('20190317124335'),
('20190319134356'),
('20190322142732'),
('20190324113414'),
('20190326172725'),
('20190327191041'),
('20190404102304'),
('20190405084643'),
('20190411190712'),
('20190412090854'),
('20190414100707'),
('20190423183014');

-- --------------------------------------------------------

--
-- Structure de la table `period`
--

CREATE TABLE `period` (
  `id` int(11) NOT NULL,
  `season_id` int(11) NOT NULL,
  `advert_id` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `period`
--

INSERT INTO `period` (`id`, `season_id`, `advert_id`, `start`, `end`) VALUES
(4, 1, 6, '2019-03-26 00:00:00', '2019-03-28 00:00:00'),
(5, 2, 6, '2019-03-26 00:00:00', '2019-03-28 00:00:00'),
(6, 3, 6, '2019-03-30 00:00:00', '2019-04-01 00:00:00'),
(7, 4, 6, '2019-04-01 00:00:00', '2019-04-07 00:00:00'),
(296, 2, 5, '2019-04-14 00:00:00', '2019-04-29 00:00:00'),
(297, 2, 209, '2019-05-08 20:11:53', '2019-05-18 20:11:53'),
(298, 4, 209, '2020-01-20 11:42:26', '2020-01-30 11:42:26'),
(299, 1, 209, '2019-07-29 07:19:15', '2019-08-08 07:19:15'),
(300, 2, 209, '2020-04-07 20:30:51', '2020-04-17 20:30:51'),
(301, 4, 210, '2019-12-20 03:28:16', '2019-12-30 03:28:16'),
(302, 3, 210, '2019-06-13 20:55:30', '2019-06-23 20:55:30'),
(303, 3, 210, '2020-02-02 20:13:46', '2020-02-12 20:13:46'),
(304, 4, 210, '2019-04-30 00:08:19', '2019-05-10 00:08:19'),
(305, 3, 211, '2020-02-08 21:09:05', '2020-02-18 21:09:05'),
(306, 4, 211, '2019-04-29 14:47:44', '2019-05-09 14:47:44'),
(307, 4, 211, '2020-01-20 19:24:41', '2020-01-30 19:24:41'),
(308, 2, 211, '2019-10-20 08:04:36', '2019-10-30 08:04:36'),
(309, 3, 211, '2019-11-26 18:15:02', '2019-12-06 18:15:02'),
(310, 1, 212, '2019-07-07 14:08:42', '2019-07-17 14:08:42'),
(311, 1, 212, '2019-10-28 05:56:43', '2019-11-07 05:56:43'),
(312, 4, 212, '2020-02-24 03:53:30', '2020-03-05 03:53:30'),
(313, 2, 212, '2020-02-01 18:37:46', '2020-02-11 18:37:46'),
(314, 4, 213, '2019-06-05 02:15:03', '2019-06-15 02:15:03'),
(315, 1, 213, '2019-10-06 21:08:42', '2019-10-16 21:08:42'),
(316, 2, 214, '2019-08-25 17:31:56', '2019-09-04 17:31:56'),
(317, 2, 214, '2020-01-03 01:57:48', '2020-01-13 01:57:48'),
(318, 3, 214, '2019-07-03 09:07:40', '2019-07-13 09:07:40'),
(319, 2, 214, '2019-12-05 18:17:25', '2019-12-15 18:17:25'),
(320, 3, 216, '2019-08-21 10:16:16', '2019-08-31 10:16:16'),
(321, 2, 216, '2019-08-31 07:57:01', '2019-09-10 07:57:01'),
(322, 3, 216, '2020-01-15 13:15:31', '2020-01-25 13:15:31'),
(323, 1, 216, '2019-12-09 11:12:52', '2019-12-19 11:12:52'),
(324, 3, 216, '2019-10-28 01:55:36', '2019-11-07 01:55:36'),
(325, 2, 217, '2019-09-30 19:18:02', '2019-10-10 19:18:02'),
(326, 4, 217, '2019-09-20 07:56:09', '2019-09-30 07:56:09'),
(331, 3, 220, '2019-05-08 04:37:20', '2019-05-18 04:37:20'),
(332, 4, 220, '2020-01-12 06:58:30', '2020-01-22 06:58:30'),
(333, 4, 220, '2020-01-18 13:37:34', '2020-01-28 13:37:34'),
(334, 1, 220, '2019-05-22 15:59:54', '2019-06-01 15:59:54'),
(335, 3, 221, '2020-02-19 19:57:20', '2020-02-29 19:57:20'),
(336, 3, 221, '2019-06-30 17:51:18', '2019-07-10 17:51:18'),
(337, 1, 221, '2020-01-23 08:26:31', '2020-02-02 08:26:31'),
(338, 2, 222, '2020-02-07 13:25:34', '2020-02-17 13:25:34'),
(339, 2, 222, '2019-05-06 10:27:25', '2019-05-16 10:27:25'),
(340, 4, 223, '2019-06-04 15:46:23', '2019-06-14 15:46:23'),
(341, 4, 224, '2019-12-13 23:55:35', '2019-12-23 23:55:35'),
(342, 4, 224, '2019-08-21 03:08:12', '2019-08-31 03:08:12'),
(343, 3, 225, '2020-03-26 18:48:28', '2020-04-05 18:48:28'),
(344, 2, 225, '2020-01-29 14:15:33', '2020-02-08 14:15:33'),
(345, 1, 225, '2019-12-12 13:48:14', '2019-12-22 13:48:14'),
(346, 3, 226, '2019-09-29 17:33:02', '2019-10-09 17:33:02'),
(347, 3, 226, '2019-10-25 07:46:51', '2019-11-04 07:46:51'),
(348, 2, 226, '2020-01-01 17:05:58', '2020-01-11 17:05:58'),
(349, 1, 227, '2019-09-30 23:02:14', '2019-10-10 23:02:14'),
(350, 2, 227, '2019-11-14 12:54:36', '2019-11-24 12:54:36'),
(351, 2, 227, '2020-02-28 07:53:01', '2020-03-09 07:53:01'),
(352, 4, 227, '2019-07-09 21:08:24', '2019-07-19 21:08:24'),
(353, 4, 228, '2020-03-28 17:50:45', '2020-04-07 17:50:45'),
(354, 4, 228, '2019-06-08 05:04:03', '2019-06-18 05:04:03'),
(355, 1, 228, '2020-02-15 20:36:07', '2020-02-25 20:36:07'),
(356, 1, 228, '2019-07-14 00:08:30', '2019-07-24 00:08:30'),
(357, 4, 228, '2020-04-07 03:46:55', '2020-04-17 03:46:55'),
(358, 2, 228, '2019-11-21 16:44:32', '2019-12-01 16:44:32'),
(359, 2, 228, '2020-01-11 08:26:56', '2020-01-21 08:26:56'),
(360, 2, 228, '2020-01-06 21:41:50', '2020-01-16 21:41:50'),
(361, 3, 229, '2020-01-15 09:02:44', '2020-01-25 09:02:44'),
(362, 1, 229, '2019-05-20 16:38:41', '2019-05-30 16:38:41'),
(363, 4, 229, '2019-07-17 12:34:34', '2019-07-27 12:34:34'),
(364, 2, 230, '2019-11-12 02:04:11', '2019-11-22 02:04:11'),
(365, 3, 230, '2019-09-13 05:26:43', '2019-09-23 05:26:43'),
(366, 4, 231, '2019-06-08 18:08:15', '2019-06-18 18:08:15'),
(367, 1, 232, '2019-12-18 02:07:53', '2019-12-28 02:07:53'),
(368, 1, 232, '2019-10-12 15:42:04', '2019-10-22 15:42:04'),
(369, 2, 232, '2019-07-16 10:05:08', '2019-07-26 10:05:08'),
(370, 1, 232, '2019-12-01 04:53:11', '2019-12-11 04:53:11'),
(371, 2, 233, '2019-11-24 07:41:26', '2019-12-04 07:41:26'),
(372, 2, 233, '2019-11-27 22:16:16', '2019-12-07 22:16:16'),
(373, 4, 234, '2020-03-20 00:52:44', '2020-03-30 00:52:44'),
(374, 3, 234, '2019-08-16 21:44:49', '2019-08-26 21:44:49'),
(375, 4, 234, '2019-06-10 05:00:52', '2019-06-20 05:00:52'),
(376, 4, 235, '2019-10-01 06:03:06', '2019-10-11 06:03:06'),
(377, 3, 235, '2019-08-26 11:07:01', '2019-09-05 11:07:01'),
(378, 3, 237, '2019-05-31 02:27:44', '2019-06-10 02:27:44'),
(379, 1, 238, '2019-05-14 00:31:35', '2019-05-24 00:31:35'),
(380, 3, 238, '2019-05-30 03:20:34', '2019-06-09 03:20:34'),
(381, 4, 238, '2019-05-24 20:37:10', '2019-06-03 20:37:10'),
(382, 2, 239, '2019-12-07 16:41:09', '2019-12-17 16:41:09'),
(383, 3, 239, '2019-11-11 10:00:02', '2019-11-21 10:00:02'),
(384, 4, 239, '2019-09-23 11:55:28', '2019-10-03 11:55:28'),
(385, 2, 240, '2019-08-22 10:10:23', '2019-09-01 10:10:23'),
(386, 2, 240, '2019-12-02 15:42:13', '2019-12-12 15:42:13'),
(387, 1, 240, '2020-02-26 16:21:54', '2020-03-07 16:21:54'),
(388, 1, 241, '2019-10-01 14:09:39', '2019-10-11 14:09:39'),
(389, 3, 241, '2019-11-03 08:01:28', '2019-11-13 08:01:28'),
(390, 3, 241, '2020-03-31 17:44:21', '2020-04-10 17:44:21'),
(391, 2, 243, '2019-07-25 17:33:06', '2019-08-04 17:33:06'),
(392, 1, 243, '2019-07-29 05:55:57', '2019-08-08 05:55:57'),
(393, 2, 243, '2020-02-22 04:00:26', '2020-03-03 04:00:26'),
(394, 2, 244, '2020-04-06 13:10:07', '2020-04-16 13:10:07'),
(395, 2, 244, '2019-11-22 14:25:15', '2019-12-02 14:25:15'),
(396, 2, 245, '2020-01-20 23:56:39', '2020-01-30 23:56:39'),
(397, 4, 245, '2020-03-24 11:00:39', '2020-04-03 11:00:39'),
(398, 1, 245, '2019-10-07 16:16:56', '2019-10-17 16:16:56'),
(399, 2, 245, '2020-01-11 22:03:50', '2020-01-21 22:03:50'),
(400, 4, 245, '2019-04-15 21:29:19', '2019-04-25 21:29:19'),
(401, 1, 246, '2019-05-27 07:45:35', '2019-06-06 07:45:35'),
(402, 1, 246, '2019-08-27 05:00:59', '2019-09-06 05:00:59'),
(403, 2, 246, '2019-06-24 05:44:01', '2019-07-04 05:44:01'),
(404, 4, 246, '2020-02-18 07:06:10', '2020-02-28 07:06:10'),
(405, 1, 246, '2019-04-28 14:38:57', '2019-05-08 14:38:57'),
(406, 4, 247, '2019-12-08 18:43:21', '2019-12-18 18:43:21'),
(407, 2, 247, '2019-04-29 03:01:52', '2019-05-09 03:01:52'),
(408, 2, 248, '2019-07-06 09:21:17', '2019-07-16 09:21:17'),
(409, 4, 248, '2019-07-07 03:55:43', '2019-07-17 03:55:43'),
(410, 4, 249, '2019-11-17 18:48:48', '2019-11-27 18:48:48'),
(411, 4, 249, '2020-01-02 01:34:12', '2020-01-12 01:34:12'),
(412, 1, 249, '2019-06-24 20:12:00', '2019-07-04 20:12:00'),
(413, 2, 249, '2019-11-11 19:06:14', '2019-11-21 19:06:14'),
(414, 1, 249, '2020-02-29 08:24:24', '2020-03-10 08:24:24'),
(415, 3, 250, '2019-05-31 17:58:11', '2019-06-10 17:58:11'),
(416, 3, 250, '2019-08-28 19:52:53', '2019-09-07 19:52:53'),
(417, 3, 251, '2020-01-21 19:38:26', '2020-01-31 19:38:26'),
(418, 2, 251, '2019-09-09 09:34:43', '2019-09-19 09:34:43'),
(419, 4, 252, '2019-04-14 14:07:07', '2019-04-24 14:07:07'),
(420, 4, 252, '2020-03-20 06:14:18', '2020-03-30 06:14:18'),
(421, 1, 252, '2019-07-25 06:47:55', '2019-08-04 06:47:55'),
(422, 3, 252, '2020-03-15 21:32:46', '2020-03-25 21:32:46'),
(423, 3, 252, '2019-05-25 00:34:32', '2019-06-04 00:34:32'),
(424, 1, 252, '2019-08-16 12:00:10', '2019-08-26 12:00:10'),
(425, 3, 252, '2019-12-03 01:55:57', '2019-12-13 01:55:57'),
(426, 4, 253, '2020-03-12 19:45:40', '2020-03-22 19:45:40'),
(427, 3, 253, '2019-11-08 13:01:09', '2019-11-18 13:01:09'),
(428, 1, 253, '2019-05-04 08:23:56', '2019-05-14 08:23:56'),
(429, 2, 253, '2020-03-15 22:30:19', '2020-03-25 22:30:19'),
(430, 1, 254, '2020-03-16 22:52:36', '2020-03-26 22:52:36'),
(431, 4, 254, '2019-05-31 22:25:58', '2019-06-10 22:25:58'),
(432, 4, 254, '2019-12-03 14:47:30', '2019-12-13 14:47:30'),
(433, 3, 255, '2019-07-14 06:05:16', '2019-07-24 06:05:16'),
(434, 4, 255, '2019-05-23 04:12:43', '2019-06-02 04:12:43'),
(435, 3, 255, '2020-01-23 03:18:26', '2020-02-02 03:18:26'),
(436, 3, 255, '2020-01-04 14:29:27', '2020-01-14 14:29:27'),
(437, 4, 256, '2020-02-06 19:28:34', '2020-02-16 19:28:34'),
(438, 2, 256, '2019-07-20 06:56:55', '2019-07-30 06:56:55'),
(439, 4, 256, '2019-08-16 06:08:46', '2019-08-26 06:08:46'),
(440, 4, 256, '2019-04-27 23:53:36', '2019-05-07 23:53:36'),
(441, 3, 257, '2019-04-17 05:22:16', '2019-04-27 05:22:16'),
(442, 3, 257, '2019-07-08 14:51:17', '2019-07-18 14:51:17'),
(443, 3, 257, '2020-03-08 21:42:28', '2020-03-18 21:42:28'),
(444, 2, 257, '2019-12-30 05:03:04', '2020-01-09 05:03:04'),
(445, 2, 258, '2019-07-10 17:32:23', '2019-07-20 17:32:23'),
(446, 3, 258, '2019-11-19 22:56:19', '2019-11-29 22:56:19'),
(447, 1, 259, '2019-12-25 05:38:10', '2020-01-04 05:38:10'),
(448, 2, 260, '2019-07-29 10:49:51', '2019-08-08 10:49:51'),
(449, 2, 260, '2019-10-08 21:32:22', '2019-10-18 21:32:22'),
(450, 1, 260, '2019-04-23 15:12:33', '2019-05-03 15:12:33'),
(451, 3, 261, '2019-08-15 02:21:28', '2019-08-25 02:21:28'),
(452, 3, 261, '2019-11-12 16:23:31', '2019-11-22 16:23:31'),
(453, 2, 261, '2019-12-20 06:59:19', '2019-12-30 06:59:19'),
(454, 2, 261, '2020-01-06 19:21:17', '2020-01-16 19:21:17'),
(455, 2, 261, '2020-01-08 04:44:42', '2020-01-18 04:44:42'),
(456, 4, 262, '2019-08-19 21:33:47', '2019-08-29 21:33:47'),
(457, 4, 262, '2020-01-10 03:14:57', '2020-01-20 03:14:57'),
(458, 2, 263, '2019-10-13 22:15:03', '2019-10-23 22:15:03'),
(459, 4, 263, '2019-07-20 19:11:21', '2019-07-30 19:11:21'),
(460, 4, 264, '2020-03-07 09:06:37', '2020-03-17 09:06:37'),
(461, 1, 264, '2019-11-12 19:29:51', '2019-11-22 19:29:51'),
(462, 3, 264, '2020-03-23 11:35:58', '2020-04-02 11:35:58'),
(463, 1, 264, '2020-03-29 13:03:10', '2020-04-08 13:03:10'),
(464, 3, 264, '2019-06-22 03:18:29', '2019-07-02 03:18:29'),
(465, 2, 264, '2020-01-20 05:01:28', '2020-01-30 05:01:28'),
(466, 1, 264, '2019-12-22 10:18:44', '2020-01-01 10:18:44'),
(467, 4, 265, '2020-02-22 16:21:34', '2020-03-03 16:21:34'),
(468, 1, 265, '2020-03-18 07:51:21', '2020-03-28 07:51:21'),
(469, 4, 265, '2019-07-30 19:18:12', '2019-08-09 19:18:12'),
(470, 4, 265, '2020-01-08 23:23:01', '2020-01-18 23:23:01'),
(471, 1, 266, '2019-11-08 18:24:38', '2019-11-18 18:24:38'),
(472, 2, 266, '2019-09-18 04:47:10', '2019-09-28 04:47:10'),
(473, 3, 266, '2019-06-23 19:54:18', '2019-07-03 19:54:18'),
(474, 1, 266, '2019-09-14 10:47:46', '2019-09-24 10:47:46'),
(475, 2, 267, '2020-02-06 13:24:21', '2020-02-16 13:24:21'),
(476, 1, 267, '2020-01-31 23:54:38', '2020-02-10 23:54:38'),
(477, 1, 268, '2019-10-31 11:44:45', '2019-11-10 11:44:45'),
(478, 1, 268, '2019-05-25 17:04:22', '2019-06-04 17:04:22'),
(479, 4, 268, '2019-06-13 00:39:00', '2019-06-23 00:39:00'),
(480, 4, 268, '2019-06-29 12:49:30', '2019-07-09 12:49:30'),
(481, 4, 268, '2019-06-15 18:44:35', '2019-06-25 18:44:35'),
(482, 4, 269, '2019-08-19 09:12:16', '2019-08-29 09:12:16'),
(483, 3, 269, '2019-09-17 08:21:35', '2019-09-27 08:21:35'),
(484, 1, 269, '2020-02-07 08:41:07', '2020-02-17 08:41:07'),
(485, 4, 270, '2019-09-05 04:24:06', '2019-09-15 04:24:06'),
(486, 3, 271, '2020-03-29 14:39:28', '2020-04-08 14:39:28'),
(487, 1, 271, '2019-10-24 23:32:02', '2019-11-03 23:32:02'),
(488, 2, 271, '2020-01-19 07:55:38', '2020-01-29 07:55:38'),
(489, 4, 271, '2019-08-07 09:32:00', '2019-08-17 09:32:00'),
(490, 4, 271, '2020-02-01 01:17:04', '2020-02-11 01:17:04'),
(491, 2, 272, '2020-03-31 03:16:45', '2020-04-10 03:16:45'),
(492, 3, 272, '2019-10-03 02:41:08', '2019-10-13 02:41:08'),
(493, 1, 273, '2019-11-20 13:50:18', '2019-11-30 13:50:18'),
(494, 3, 274, '2019-11-21 16:11:47', '2019-12-01 16:11:47'),
(495, 4, 274, '2019-11-03 14:31:23', '2019-11-13 14:31:23'),
(496, 1, 275, '2019-05-29 04:48:58', '2019-06-08 04:48:58'),
(497, 1, 275, '2019-12-22 17:18:34', '2020-01-01 17:18:34'),
(498, 2, 275, '2019-09-17 17:40:40', '2019-09-27 17:40:40'),
(499, 3, 275, '2019-12-17 01:48:14', '2019-12-27 01:48:14'),
(500, 3, 276, '2020-02-26 10:45:55', '2020-03-07 10:45:55'),
(501, 2, 276, '2019-06-25 07:14:16', '2019-07-05 07:14:16'),
(502, 2, 276, '2019-06-27 02:59:27', '2019-07-07 02:59:27'),
(503, 4, 276, '2019-07-17 07:11:18', '2019-07-27 07:11:18'),
(504, 2, 276, '2020-03-09 23:14:53', '2020-03-19 23:14:53'),
(505, 2, 277, '2020-01-03 05:26:11', '2020-01-13 05:26:11'),
(506, 2, 277, '2019-07-02 20:32:24', '2019-07-12 20:32:24'),
(507, 1, 277, '2019-09-09 22:21:54', '2019-09-19 22:21:54'),
(508, 1, 277, '2020-02-18 13:16:10', '2020-02-28 13:16:10'),
(509, 3, 278, '2019-12-28 01:52:06', '2020-01-07 01:52:06'),
(510, 1, 279, '2019-06-14 01:06:07', '2019-06-24 01:06:07'),
(511, 3, 279, '2019-04-25 11:47:14', '2019-05-05 11:47:14'),
(512, 2, 280, '2019-12-26 02:48:00', '2020-01-05 02:48:00'),
(513, 4, 280, '2019-07-07 00:33:25', '2019-07-17 00:33:25'),
(514, 3, 280, '2019-08-17 02:07:01', '2019-08-27 02:07:01'),
(515, 2, 281, '2020-02-08 22:14:22', '2020-02-18 22:14:22'),
(516, 2, 281, '2019-06-24 15:04:13', '2019-07-04 15:04:13'),
(517, 2, 281, '2019-11-18 10:41:13', '2019-11-28 10:41:13'),
(518, 3, 282, '2019-08-10 05:40:46', '2019-08-20 05:40:46'),
(519, 2, 283, '2019-10-31 05:39:36', '2019-11-10 05:39:36'),
(520, 4, 283, '2019-08-19 19:26:06', '2019-08-29 19:26:06'),
(521, 2, 283, '2019-12-26 21:44:58', '2020-01-05 21:44:58'),
(522, 3, 283, '2019-05-27 12:53:18', '2019-06-06 12:53:18'),
(523, 1, 284, '2020-02-03 12:11:22', '2020-02-13 12:11:22'),
(524, 3, 285, '2019-07-27 12:14:57', '2019-08-06 12:14:57'),
(525, 3, 285, '2019-10-03 08:07:12', '2019-10-13 08:07:12'),
(526, 1, 287, '2019-12-31 04:05:56', '2020-01-10 04:05:56'),
(527, 3, 287, '2020-01-27 01:54:22', '2020-02-06 01:54:22'),
(528, 4, 287, '2019-04-19 06:54:19', '2019-04-29 06:54:19'),
(529, 4, 287, '2020-03-07 09:12:06', '2020-03-17 09:12:06'),
(530, 2, 287, '2019-12-07 13:53:00', '2019-12-17 13:53:00'),
(531, 1, 287, '2019-11-04 09:33:56', '2019-11-14 09:33:56'),
(532, 1, 288, '2019-07-16 13:18:34', '2019-07-26 13:18:34'),
(533, 4, 288, '2019-05-26 04:17:57', '2019-06-05 04:17:57'),
(534, 1, 288, '2019-10-18 20:15:33', '2019-10-28 20:15:33'),
(535, 2, 288, '2019-08-16 10:31:15', '2019-08-26 10:31:15'),
(536, 1, 288, '2019-10-09 21:42:43', '2019-10-19 21:42:43'),
(537, 1, 289, '2019-08-28 09:06:17', '2019-09-07 09:06:17'),
(538, 1, 289, '2019-06-30 06:54:44', '2019-07-10 06:54:44'),
(539, 4, 289, '2019-05-06 09:41:44', '2019-05-16 09:41:44'),
(540, 1, 290, '2020-03-28 11:03:45', '2020-04-07 11:03:45'),
(541, 2, 290, '2020-03-10 06:24:56', '2020-03-20 06:24:56'),
(542, 3, 291, '2020-01-02 17:20:54', '2020-01-12 17:20:54'),
(543, 4, 291, '2019-10-06 01:52:32', '2019-10-16 01:52:32'),
(544, 2, 292, '2019-04-21 20:02:30', '2019-05-01 20:02:30'),
(545, 4, 292, '2019-11-06 08:03:53', '2019-11-16 08:03:53'),
(546, 4, 292, '2020-04-03 05:28:26', '2020-04-13 05:28:26'),
(547, 2, 292, '2019-07-16 03:31:57', '2019-07-26 03:31:57'),
(548, 2, 292, '2019-11-23 18:19:18', '2019-12-03 18:19:18'),
(549, 1, 293, '2019-11-09 10:14:23', '2019-11-19 10:14:23'),
(550, 4, 293, '2019-08-03 05:34:17', '2019-08-13 05:34:17'),
(551, 3, 293, '2019-09-18 13:18:02', '2019-09-28 13:18:02'),
(552, 3, 294, '2019-08-22 15:37:35', '2019-09-01 15:37:35'),
(553, 4, 294, '2019-05-05 03:45:28', '2019-05-15 03:45:28'),
(554, 1, 294, '2019-08-25 11:20:32', '2019-09-04 11:20:32'),
(555, 4, 294, '2019-04-20 13:03:32', '2019-04-30 13:03:32'),
(556, 2, 294, '2020-01-19 05:48:11', '2020-01-29 05:48:11'),
(557, 4, 294, '2019-10-09 22:14:42', '2019-10-19 22:14:42'),
(558, 4, 295, '2019-09-03 04:32:53', '2019-09-13 04:32:53'),
(559, 3, 296, '2020-03-27 13:10:30', '2020-04-06 13:10:30'),
(560, 4, 296, '2019-08-01 06:19:53', '2019-08-11 06:19:53'),
(561, 3, 296, '2019-11-20 14:31:58', '2019-11-30 14:31:58'),
(562, 4, 296, '2019-05-23 12:52:11', '2019-06-02 12:52:11'),
(563, 3, 297, '2020-01-24 13:44:05', '2020-02-03 13:44:05'),
(564, 3, 297, '2019-11-13 13:25:38', '2019-11-23 13:25:38'),
(565, 1, 297, '2020-03-01 19:44:45', '2020-03-11 19:44:45'),
(566, 2, 298, '2019-07-24 01:42:35', '2019-08-03 01:42:35'),
(567, 4, 298, '2019-07-11 02:05:58', '2019-07-21 02:05:58'),
(568, 3, 298, '2019-08-26 00:53:58', '2019-09-05 00:53:58'),
(569, 2, 298, '2019-10-13 08:26:51', '2019-10-23 08:26:51'),
(570, 4, 298, '2019-10-05 09:34:46', '2019-10-15 09:34:46'),
(571, 4, 299, '2019-07-24 03:29:58', '2019-08-03 03:29:58'),
(572, 4, 299, '2020-01-24 22:43:44', '2020-02-03 22:43:44'),
(573, 1, 299, '2019-04-23 04:39:07', '2019-05-03 04:39:07'),
(574, 4, 300, '2019-09-03 16:15:51', '2019-09-13 16:15:51'),
(575, 1, 300, '2019-10-27 02:42:59', '2019-11-06 02:42:59'),
(576, 2, 300, '2019-05-11 19:51:14', '2019-05-21 19:51:14'),
(577, 3, 301, '2020-03-29 11:25:27', '2020-04-08 11:25:27'),
(578, 4, 301, '2019-07-30 04:07:19', '2019-08-09 04:07:19'),
(579, 3, 301, '2019-05-05 13:12:27', '2019-05-15 13:12:27'),
(580, 3, 301, '2020-02-02 09:10:27', '2020-02-12 09:10:27'),
(581, 2, 301, '2019-08-02 04:50:41', '2019-08-12 04:50:41'),
(582, 2, 302, '2019-04-28 21:59:12', '2019-05-08 21:59:12'),
(583, 3, 302, '2020-04-05 16:24:06', '2020-04-15 16:24:06'),
(584, 3, 302, '2020-03-08 15:44:53', '2020-03-18 15:44:53'),
(585, 2, 303, '2019-12-22 02:44:22', '2020-01-01 02:44:22'),
(586, 2, 303, '2020-01-16 02:44:39', '2020-01-26 02:44:39'),
(587, 3, 303, '2019-10-02 13:29:55', '2019-10-12 13:29:55'),
(588, 2, 304, '2020-02-11 16:24:25', '2020-02-21 16:24:25'),
(589, 3, 304, '2019-10-16 03:09:02', '2019-10-26 03:09:02'),
(590, 3, 304, '2019-11-26 18:05:51', '2019-12-06 18:05:51'),
(591, 4, 305, '2020-02-11 01:22:52', '2020-02-21 01:22:52'),
(592, 3, 305, '2019-12-05 01:25:25', '2019-12-15 01:25:25'),
(593, 2, 305, '2019-10-20 20:02:50', '2019-10-30 20:02:50'),
(594, 2, 305, '2019-11-02 02:38:39', '2019-11-12 02:38:39'),
(595, 4, 305, '2019-10-05 17:17:14', '2019-10-15 17:17:14'),
(596, 2, 306, '2019-05-27 00:33:43', '2019-06-06 00:33:43'),
(597, 1, 307, '2019-10-02 12:02:42', '2019-10-12 12:02:42'),
(598, 1, 307, '2019-08-18 09:43:53', '2019-08-28 09:43:53'),
(599, 1, 308, '2019-04-14 00:00:00', '2019-04-16 00:00:00'),
(600, 2, 308, '2019-04-16 00:00:00', '2019-04-18 00:00:00'),
(601, 3, 308, '2019-04-18 00:00:00', '2019-04-20 00:00:00'),
(602, 4, 308, '2019-04-20 00:00:00', '2019-04-22 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id` int(11) NOT NULL,
  `advert_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_photo` tinyint(1) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `photo`
--

INSERT INTO `photo` (`id`, `advert_id`, `name`, `main_photo`, `updated_at`) VALUES
(539, 5, '405994c1d541a9dc06bccf087f21046f.png', 1, '0000-00-00 00:00:00'),
(829, 6, '5cb1c7b8eb668161604600.jpg', 1, NULL),
(830, 308, '5cb2f2056dab3952676380.jpg', 1, NULL),
(836, 308, '5cb2f5138a3bb436790359.jpg', 0, NULL),
(837, 308, '5cb2f5138af73439914189.jpg', 0, NULL),
(838, 308, '5cb3002324abb988647358.jpg', 0, NULL),
(839, 308, '5cb3002325a5b164061238.jpg', 0, NULL),
(841, 308, '5cbd994f413c5025314671.jpg', 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `price`
--

CREATE TABLE `price` (
  `id` int(11) NOT NULL,
  `advert_id` int(11) NOT NULL,
  `season_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `duration_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `price`
--

INSERT INTO `price` (`id`, `advert_id`, `season_id`, `price`, `duration_id`) VALUES
(1, 6, 1, 400, 1),
(2, 6, 1, 600, 2),
(3, 6, 1, 800, 4),
(4, 6, 2, 400, 1),
(5, 6, 2, 600, 2),
(6, 6, 2, 800, 4),
(7, 6, 3, 400, 1),
(8, 6, 3, 600, 2),
(9, 6, 3, 800, 4),
(10, 6, 4, 400, 1),
(11, 6, 4, 600, 2),
(12, 6, 4, 800, 4),
(628, 5, 2, 300, 1),
(629, 5, 2, 600, 4),
(630, 209, 2, 573, 1),
(631, 209, 2, 782, 2),
(632, 209, 2, 488, 4),
(633, 209, 4, 854, 1),
(634, 209, 4, 657, 2),
(635, 209, 4, 527, 4),
(636, 209, 1, 567, 1),
(637, 209, 1, 296, 2),
(638, 209, 1, 683, 4),
(639, 210, 4, 881, 1),
(640, 210, 4, 632, 2),
(641, 210, 4, 301, 4),
(642, 210, 3, 703, 1),
(643, 210, 3, 903, 2),
(644, 210, 3, 984, 4),
(645, 211, 3, 517, 1),
(646, 211, 3, 915, 2),
(647, 211, 3, 287, 4),
(648, 211, 4, 384, 1),
(649, 211, 4, 992, 2),
(650, 211, 4, 386, 4),
(651, 211, 2, 630, 1),
(652, 211, 2, 312, 2),
(653, 211, 2, 342, 4),
(654, 212, 1, 876, 1),
(655, 212, 1, 675, 2),
(656, 212, 1, 994, 4),
(657, 212, 4, 335, 1),
(658, 212, 4, 728, 2),
(659, 212, 4, 833, 4),
(660, 212, 2, 990, 1),
(661, 212, 2, 548, 2),
(662, 212, 2, 887, 4),
(663, 213, 4, 915, 1),
(664, 213, 4, 528, 2),
(665, 213, 4, 645, 4),
(666, 213, 1, 297, 1),
(667, 213, 1, 561, 2),
(668, 213, 1, 558, 4),
(669, 214, 2, 599, 1),
(670, 214, 2, 867, 2),
(671, 214, 2, 394, 4),
(672, 214, 3, 792, 1),
(673, 214, 3, 974, 2),
(674, 214, 3, 591, 4),
(675, 216, 3, 501, 1),
(676, 216, 3, 364, 2),
(677, 216, 3, 975, 4),
(678, 216, 2, 996, 1),
(679, 216, 2, 695, 2),
(680, 216, 2, 337, 4),
(681, 216, 1, 371, 1),
(682, 216, 1, 886, 2),
(683, 216, 1, 282, 4),
(684, 217, 2, 990, 1),
(685, 217, 2, 907, 2),
(686, 217, 2, 261, 4),
(687, 217, 4, 967, 1),
(688, 217, 4, 913, 2),
(689, 217, 4, 705, 4),
(702, 220, 3, 330, 1),
(703, 220, 3, 621, 2),
(704, 220, 3, 258, 4),
(705, 220, 4, 867, 1),
(706, 220, 4, 678, 2),
(707, 220, 4, 548, 4),
(708, 220, 1, 430, 1),
(709, 220, 1, 719, 2),
(710, 220, 1, 314, 4),
(711, 221, 3, 698, 1),
(712, 221, 3, 318, 2),
(713, 221, 3, 735, 4),
(714, 221, 1, 489, 1),
(715, 221, 1, 510, 2),
(716, 221, 1, 273, 4),
(717, 222, 2, 556, 1),
(718, 222, 2, 512, 2),
(719, 222, 2, 570, 4),
(720, 223, 4, 955, 1),
(721, 223, 4, 538, 2),
(722, 223, 4, 387, 4),
(723, 224, 4, 285, 1),
(724, 224, 4, 514, 2),
(725, 224, 4, 884, 4),
(726, 225, 3, 445, 1),
(727, 225, 3, 955, 2),
(728, 225, 3, 826, 4),
(729, 225, 2, 341, 1),
(730, 225, 2, 559, 2),
(731, 225, 2, 370, 4),
(732, 225, 1, 723, 1),
(733, 225, 1, 390, 2),
(734, 225, 1, 394, 4),
(735, 226, 3, 480, 1),
(736, 226, 3, 557, 2),
(737, 226, 3, 696, 4),
(738, 226, 2, 388, 1),
(739, 226, 2, 705, 2),
(740, 226, 2, 535, 4),
(741, 227, 1, 977, 1),
(742, 227, 1, 594, 2),
(743, 227, 1, 910, 4),
(744, 227, 2, 813, 1),
(745, 227, 2, 514, 2),
(746, 227, 2, 884, 4),
(747, 227, 4, 939, 1),
(748, 227, 4, 560, 2),
(749, 227, 4, 886, 4),
(750, 228, 4, 871, 1),
(751, 228, 4, 943, 2),
(752, 228, 4, 693, 4),
(753, 228, 1, 354, 1),
(754, 228, 1, 715, 2),
(755, 228, 1, 889, 4),
(756, 228, 2, 277, 1),
(757, 228, 2, 886, 2),
(758, 228, 2, 263, 4),
(759, 229, 3, 557, 1),
(760, 229, 3, 491, 2),
(761, 229, 3, 806, 4),
(762, 229, 1, 925, 1),
(763, 229, 1, 440, 2),
(764, 229, 1, 523, 4),
(765, 229, 4, 920, 1),
(766, 229, 4, 613, 2),
(767, 229, 4, 560, 4),
(768, 230, 2, 602, 1),
(769, 230, 2, 821, 2),
(770, 230, 2, 637, 4),
(771, 230, 3, 903, 1),
(772, 230, 3, 497, 2),
(773, 230, 3, 652, 4),
(774, 231, 4, 788, 1),
(775, 231, 4, 516, 2),
(776, 231, 4, 562, 4),
(777, 232, 1, 588, 1),
(778, 232, 1, 618, 2),
(779, 232, 1, 478, 4),
(780, 232, 2, 942, 1),
(781, 232, 2, 287, 2),
(782, 232, 2, 987, 4),
(783, 233, 2, 543, 1),
(784, 233, 2, 434, 2),
(785, 233, 2, 877, 4),
(786, 234, 4, 447, 1),
(787, 234, 4, 266, 2),
(788, 234, 4, 616, 4),
(789, 234, 3, 459, 1),
(790, 234, 3, 943, 2),
(791, 234, 3, 477, 4),
(792, 235, 4, 704, 1),
(793, 235, 4, 296, 2),
(794, 235, 4, 731, 4),
(795, 235, 3, 269, 1),
(796, 235, 3, 583, 2),
(797, 235, 3, 448, 4),
(798, 237, 3, 722, 1),
(799, 237, 3, 975, 2),
(800, 237, 3, 271, 4),
(801, 238, 1, 608, 1),
(802, 238, 1, 257, 2),
(803, 238, 1, 429, 4),
(804, 238, 3, 363, 1),
(805, 238, 3, 385, 2),
(806, 238, 3, 759, 4),
(807, 238, 4, 459, 1),
(808, 238, 4, 251, 2),
(809, 238, 4, 552, 4),
(810, 239, 2, 620, 1),
(811, 239, 2, 604, 2),
(812, 239, 2, 273, 4),
(813, 239, 3, 349, 1),
(814, 239, 3, 882, 2),
(815, 239, 3, 351, 4),
(816, 239, 4, 516, 1),
(817, 239, 4, 649, 2),
(818, 239, 4, 666, 4),
(819, 240, 2, 923, 1),
(820, 240, 2, 906, 2),
(821, 240, 2, 935, 4),
(822, 240, 1, 610, 1),
(823, 240, 1, 853, 2),
(824, 240, 1, 374, 4),
(825, 241, 1, 471, 1),
(826, 241, 1, 791, 2),
(827, 241, 1, 490, 4),
(828, 241, 3, 446, 1),
(829, 241, 3, 693, 2),
(830, 241, 3, 635, 4),
(831, 243, 2, 761, 1),
(832, 243, 2, 362, 2),
(833, 243, 2, 715, 4),
(834, 243, 1, 770, 1),
(835, 243, 1, 990, 2),
(836, 243, 1, 721, 4),
(837, 244, 2, 673, 1),
(838, 244, 2, 746, 2),
(839, 244, 2, 970, 4),
(840, 245, 2, 729, 1),
(841, 245, 2, 848, 2),
(842, 245, 2, 507, 4),
(843, 245, 4, 703, 1),
(844, 245, 4, 975, 2),
(845, 245, 4, 678, 4),
(846, 245, 1, 462, 1),
(847, 245, 1, 859, 2),
(848, 245, 1, 508, 4),
(849, 246, 1, 596, 1),
(850, 246, 1, 542, 2),
(851, 246, 1, 926, 4),
(852, 246, 2, 743, 1),
(853, 246, 2, 399, 2),
(854, 246, 2, 873, 4),
(855, 246, 4, 298, 1),
(856, 246, 4, 706, 2),
(857, 246, 4, 566, 4),
(858, 247, 4, 473, 1),
(859, 247, 4, 815, 2),
(860, 247, 4, 495, 4),
(861, 247, 2, 439, 1),
(862, 247, 2, 933, 2),
(863, 247, 2, 782, 4),
(864, 248, 2, 619, 1),
(865, 248, 2, 805, 2),
(866, 248, 2, 798, 4),
(867, 248, 4, 930, 1),
(868, 248, 4, 883, 2),
(869, 248, 4, 498, 4),
(870, 249, 4, 367, 1),
(871, 249, 4, 375, 2),
(872, 249, 4, 437, 4),
(873, 249, 1, 714, 1),
(874, 249, 1, 959, 2),
(875, 249, 1, 720, 4),
(876, 249, 2, 514, 1),
(877, 249, 2, 363, 2),
(878, 249, 2, 678, 4),
(879, 250, 3, 751, 1),
(880, 250, 3, 459, 2),
(881, 250, 3, 477, 4),
(882, 251, 3, 691, 1),
(883, 251, 3, 844, 2),
(884, 251, 3, 527, 4),
(885, 251, 2, 668, 1),
(886, 251, 2, 783, 2),
(887, 251, 2, 598, 4),
(888, 252, 4, 845, 1),
(889, 252, 4, 653, 2),
(890, 252, 4, 627, 4),
(891, 252, 1, 336, 1),
(892, 252, 1, 595, 2),
(893, 252, 1, 654, 4),
(894, 252, 3, 819, 1),
(895, 252, 3, 715, 2),
(896, 252, 3, 578, 4),
(897, 253, 4, 498, 1),
(898, 253, 4, 807, 2),
(899, 253, 4, 663, 4),
(900, 253, 3, 780, 1),
(901, 253, 3, 449, 2),
(902, 253, 3, 830, 4),
(903, 253, 1, 265, 1),
(904, 253, 1, 622, 2),
(905, 253, 1, 864, 4),
(906, 253, 2, 736, 1),
(907, 253, 2, 511, 2),
(908, 253, 2, 411, 4),
(909, 254, 1, 768, 1),
(910, 254, 1, 940, 2),
(911, 254, 1, 366, 4),
(912, 254, 4, 852, 1),
(913, 254, 4, 320, 2),
(914, 254, 4, 875, 4),
(915, 255, 3, 729, 1),
(916, 255, 3, 783, 2),
(917, 255, 3, 617, 4),
(918, 255, 4, 716, 1),
(919, 255, 4, 683, 2),
(920, 255, 4, 342, 4),
(921, 256, 4, 445, 1),
(922, 256, 4, 335, 2),
(923, 256, 4, 840, 4),
(924, 256, 2, 431, 1),
(925, 256, 2, 542, 2),
(926, 256, 2, 760, 4),
(927, 257, 3, 789, 1),
(928, 257, 3, 787, 2),
(929, 257, 3, 997, 4),
(930, 257, 2, 541, 1),
(931, 257, 2, 553, 2),
(932, 257, 2, 456, 4),
(933, 258, 2, 849, 1),
(934, 258, 2, 997, 2),
(935, 258, 2, 261, 4),
(936, 258, 3, 839, 1),
(937, 258, 3, 313, 2),
(938, 258, 3, 685, 4),
(939, 259, 1, 654, 1),
(940, 259, 1, 435, 2),
(941, 259, 1, 808, 4),
(942, 260, 2, 497, 1),
(943, 260, 2, 669, 2),
(944, 260, 2, 520, 4),
(945, 260, 1, 334, 1),
(946, 260, 1, 412, 2),
(947, 260, 1, 363, 4),
(948, 261, 3, 802, 1),
(949, 261, 3, 767, 2),
(950, 261, 3, 918, 4),
(951, 261, 2, 855, 1),
(952, 261, 2, 719, 2),
(953, 261, 2, 907, 4),
(954, 262, 4, 597, 1),
(955, 262, 4, 798, 2),
(956, 262, 4, 567, 4),
(957, 263, 2, 393, 1),
(958, 263, 2, 809, 2),
(959, 263, 2, 394, 4),
(960, 263, 4, 464, 1),
(961, 263, 4, 941, 2),
(962, 263, 4, 933, 4),
(963, 264, 4, 511, 1),
(964, 264, 4, 957, 2),
(965, 264, 4, 644, 4),
(966, 264, 1, 617, 1),
(967, 264, 1, 751, 2),
(968, 264, 1, 831, 4),
(969, 264, 3, 862, 1),
(970, 264, 3, 321, 2),
(971, 264, 3, 295, 4),
(972, 264, 2, 376, 1),
(973, 264, 2, 520, 2),
(974, 264, 2, 807, 4),
(975, 265, 4, 461, 1),
(976, 265, 4, 842, 2),
(977, 265, 4, 966, 4),
(978, 265, 1, 262, 1),
(979, 265, 1, 539, 2),
(980, 265, 1, 469, 4),
(981, 266, 1, 475, 1),
(982, 266, 1, 583, 2),
(983, 266, 1, 443, 4),
(984, 266, 2, 885, 1),
(985, 266, 2, 634, 2),
(986, 266, 2, 882, 4),
(987, 266, 3, 648, 1),
(988, 266, 3, 520, 2),
(989, 266, 3, 634, 4),
(990, 267, 2, 543, 1),
(991, 267, 2, 658, 2),
(992, 267, 2, 956, 4),
(993, 267, 1, 456, 1),
(994, 267, 1, 647, 2),
(995, 267, 1, 872, 4),
(996, 268, 1, 1000, 1),
(997, 268, 1, 600, 2),
(998, 268, 1, 889, 4),
(999, 268, 4, 663, 1),
(1000, 268, 4, 303, 2),
(1001, 268, 4, 393, 4),
(1002, 269, 4, 324, 1),
(1003, 269, 4, 649, 2),
(1004, 269, 4, 546, 4),
(1005, 269, 3, 802, 1),
(1006, 269, 3, 530, 2),
(1007, 269, 3, 515, 4),
(1008, 269, 1, 354, 1),
(1009, 269, 1, 847, 2),
(1010, 269, 1, 826, 4),
(1011, 270, 4, 756, 1),
(1012, 270, 4, 780, 2),
(1013, 270, 4, 975, 4),
(1014, 271, 3, 951, 1),
(1015, 271, 3, 787, 2),
(1016, 271, 3, 272, 4),
(1017, 271, 1, 438, 1),
(1018, 271, 1, 445, 2),
(1019, 271, 1, 769, 4),
(1020, 271, 2, 698, 1),
(1021, 271, 2, 359, 2),
(1022, 271, 2, 739, 4),
(1023, 271, 4, 792, 1),
(1024, 271, 4, 570, 2),
(1025, 271, 4, 289, 4),
(1026, 272, 2, 477, 1),
(1027, 272, 2, 654, 2),
(1028, 272, 2, 481, 4),
(1029, 272, 3, 308, 1),
(1030, 272, 3, 754, 2),
(1031, 272, 3, 254, 4),
(1032, 273, 1, 698, 1),
(1033, 273, 1, 291, 2),
(1034, 273, 1, 371, 4),
(1035, 274, 3, 523, 1),
(1036, 274, 3, 910, 2),
(1037, 274, 3, 276, 4),
(1038, 274, 4, 284, 1),
(1039, 274, 4, 528, 2),
(1040, 274, 4, 743, 4),
(1041, 275, 1, 323, 1),
(1042, 275, 1, 281, 2),
(1043, 275, 1, 650, 4),
(1044, 275, 2, 666, 1),
(1045, 275, 2, 814, 2),
(1046, 275, 2, 375, 4),
(1047, 275, 3, 512, 1),
(1048, 275, 3, 416, 2),
(1049, 275, 3, 946, 4),
(1050, 276, 3, 496, 1),
(1051, 276, 3, 414, 2),
(1052, 276, 3, 517, 4),
(1053, 276, 2, 440, 1),
(1054, 276, 2, 924, 2),
(1055, 276, 2, 864, 4),
(1056, 276, 4, 353, 1),
(1057, 276, 4, 899, 2),
(1058, 276, 4, 585, 4),
(1059, 277, 2, 758, 1),
(1060, 277, 2, 653, 2),
(1061, 277, 2, 640, 4),
(1062, 277, 1, 703, 1),
(1063, 277, 1, 772, 2),
(1064, 277, 1, 551, 4),
(1065, 278, 3, 468, 1),
(1066, 278, 3, 360, 2),
(1067, 278, 3, 832, 4),
(1068, 279, 1, 404, 1),
(1069, 279, 1, 335, 2),
(1070, 279, 1, 854, 4),
(1071, 279, 3, 876, 1),
(1072, 279, 3, 422, 2),
(1073, 279, 3, 353, 4),
(1074, 280, 2, 597, 1),
(1075, 280, 2, 856, 2),
(1076, 280, 2, 753, 4),
(1077, 280, 4, 449, 1),
(1078, 280, 4, 770, 2),
(1079, 280, 4, 805, 4),
(1080, 280, 3, 806, 1),
(1081, 280, 3, 572, 2),
(1082, 280, 3, 594, 4),
(1083, 281, 2, 476, 1),
(1084, 281, 2, 795, 2),
(1085, 281, 2, 607, 4),
(1086, 282, 3, 459, 1),
(1087, 282, 3, 347, 2),
(1088, 282, 3, 676, 4),
(1089, 283, 2, 661, 1),
(1090, 283, 2, 783, 2),
(1091, 283, 2, 813, 4),
(1092, 283, 4, 538, 1),
(1093, 283, 4, 426, 2),
(1094, 283, 4, 453, 4),
(1095, 283, 3, 485, 1),
(1096, 283, 3, 274, 2),
(1097, 283, 3, 362, 4),
(1098, 284, 1, 477, 1),
(1099, 284, 1, 603, 2),
(1100, 284, 1, 588, 4),
(1101, 285, 3, 438, 1),
(1102, 285, 3, 859, 2),
(1103, 285, 3, 413, 4),
(1104, 287, 1, 875, 1),
(1105, 287, 1, 544, 2),
(1106, 287, 1, 354, 4),
(1107, 287, 3, 431, 1),
(1108, 287, 3, 378, 2),
(1109, 287, 3, 376, 4),
(1110, 287, 4, 622, 1),
(1111, 287, 4, 673, 2),
(1112, 287, 4, 958, 4),
(1113, 287, 2, 391, 1),
(1114, 287, 2, 886, 2),
(1115, 287, 2, 550, 4),
(1116, 288, 1, 841, 1),
(1117, 288, 1, 810, 2),
(1118, 288, 1, 438, 4),
(1119, 288, 4, 995, 1),
(1120, 288, 4, 569, 2),
(1121, 288, 4, 852, 4),
(1122, 288, 2, 986, 1),
(1123, 288, 2, 654, 2),
(1124, 288, 2, 823, 4),
(1125, 289, 1, 715, 1),
(1126, 289, 1, 268, 2),
(1127, 289, 1, 878, 4),
(1128, 289, 4, 256, 1),
(1129, 289, 4, 302, 2),
(1130, 289, 4, 896, 4),
(1131, 290, 1, 322, 1),
(1132, 290, 1, 774, 2),
(1133, 290, 1, 345, 4),
(1134, 290, 2, 406, 1),
(1135, 290, 2, 844, 2),
(1136, 290, 2, 506, 4),
(1137, 291, 3, 467, 1),
(1138, 291, 3, 636, 2),
(1139, 291, 3, 995, 4),
(1140, 291, 4, 846, 1),
(1141, 291, 4, 961, 2),
(1142, 291, 4, 653, 4),
(1143, 292, 2, 628, 1),
(1144, 292, 2, 294, 2),
(1145, 292, 2, 907, 4),
(1146, 292, 4, 722, 1),
(1147, 292, 4, 405, 2),
(1148, 292, 4, 646, 4),
(1149, 293, 1, 419, 1),
(1150, 293, 1, 531, 2),
(1151, 293, 1, 671, 4),
(1152, 293, 4, 972, 1),
(1153, 293, 4, 267, 2),
(1154, 293, 4, 259, 4),
(1155, 293, 3, 522, 1),
(1156, 293, 3, 823, 2),
(1157, 293, 3, 705, 4),
(1158, 294, 3, 919, 1),
(1159, 294, 3, 410, 2),
(1160, 294, 3, 310, 4),
(1161, 294, 4, 345, 1),
(1162, 294, 4, 720, 2),
(1163, 294, 4, 479, 4),
(1164, 294, 1, 433, 1),
(1165, 294, 1, 966, 2),
(1166, 294, 1, 497, 4),
(1167, 294, 2, 663, 1),
(1168, 294, 2, 427, 2),
(1169, 294, 2, 391, 4),
(1170, 295, 4, 495, 1),
(1171, 295, 4, 549, 2),
(1172, 295, 4, 490, 4),
(1173, 296, 3, 439, 1),
(1174, 296, 3, 973, 2),
(1175, 296, 3, 918, 4),
(1176, 296, 4, 336, 1),
(1177, 296, 4, 543, 2),
(1178, 296, 4, 383, 4),
(1179, 297, 3, 609, 1),
(1180, 297, 3, 812, 2),
(1181, 297, 3, 572, 4),
(1182, 297, 1, 649, 1),
(1183, 297, 1, 282, 2),
(1184, 297, 1, 939, 4),
(1185, 298, 2, 467, 1),
(1186, 298, 2, 986, 2),
(1187, 298, 2, 475, 4),
(1188, 298, 4, 413, 1),
(1189, 298, 4, 808, 2),
(1190, 298, 4, 750, 4),
(1191, 298, 3, 464, 1),
(1192, 298, 3, 853, 2),
(1193, 298, 3, 997, 4),
(1194, 299, 4, 324, 1),
(1195, 299, 4, 696, 2),
(1196, 299, 4, 994, 4),
(1197, 299, 1, 270, 1),
(1198, 299, 1, 556, 2),
(1199, 299, 1, 373, 4),
(1200, 300, 4, 620, 1),
(1201, 300, 4, 851, 2),
(1202, 300, 4, 622, 4),
(1203, 300, 1, 784, 1),
(1204, 300, 1, 440, 2),
(1205, 300, 1, 346, 4),
(1206, 300, 2, 653, 1),
(1207, 300, 2, 941, 2),
(1208, 300, 2, 587, 4),
(1209, 301, 3, 619, 1),
(1210, 301, 3, 507, 2),
(1211, 301, 3, 619, 4),
(1212, 301, 4, 879, 1),
(1213, 301, 4, 456, 2),
(1214, 301, 4, 804, 4),
(1215, 301, 2, 851, 1),
(1216, 301, 2, 404, 2),
(1217, 301, 2, 369, 4),
(1218, 302, 2, 762, 1),
(1219, 302, 2, 966, 2),
(1220, 302, 2, 412, 4),
(1221, 302, 3, 882, 1),
(1222, 302, 3, 588, 2),
(1223, 302, 3, 318, 4),
(1224, 303, 2, 655, 1),
(1225, 303, 2, 334, 2),
(1226, 303, 2, 774, 4),
(1227, 303, 3, 812, 1),
(1228, 303, 3, 855, 2),
(1229, 303, 3, 475, 4),
(1230, 304, 2, 282, 1),
(1231, 304, 2, 729, 2),
(1232, 304, 2, 655, 4),
(1233, 304, 3, 737, 1),
(1234, 304, 3, 619, 2),
(1235, 304, 3, 350, 4),
(1236, 305, 4, 319, 1),
(1237, 305, 4, 512, 2),
(1238, 305, 4, 913, 4),
(1239, 305, 3, 986, 1),
(1240, 305, 3, 373, 2),
(1241, 305, 3, 381, 4),
(1242, 305, 2, 710, 1),
(1243, 305, 2, 962, 2),
(1244, 305, 2, 834, 4),
(1245, 306, 2, 740, 1),
(1246, 306, 2, 410, 2),
(1247, 306, 2, 423, 4),
(1248, 307, 1, 562, 1),
(1249, 307, 1, 729, 2),
(1250, 307, 1, 722, 4),
(1251, 308, 1, 600, 4),
(1252, 308, 2, 700, 4),
(1253, 308, 3, 800, 4),
(1254, 308, 4, 900, 4);

-- --------------------------------------------------------

--
-- Structure de la table `price_period`
--

CREATE TABLE `price_period` (
  `price_id` int(11) NOT NULL,
  `period_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `season`
--

CREATE TABLE `season` (
  `id` int(11) NOT NULL,
  `season` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `season`
--

INSERT INTO `season` (`id`, `season`) VALUES
(1, 'Basse'),
(2, 'Moyenne'),
(3, 'Haute'),
(4, 'Top');

-- --------------------------------------------------------

--
-- Structure de la table `sort`
--

CREATE TABLE `sort` (
  `id` int(11) NOT NULL,
  `sort` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sort`
--

INSERT INTO `sort` (`id`, `sort`) VALUES
(1, 'Fourgon aménagé'),
(2, 'Profilé'),
(3, 'Capucine');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(2, 'demo', '$2y$12$Jc32ToMd/CdWamMotXB3B.8i95J7oai6lH/OPp550HZCnsnq8PIBC');

-- --------------------------------------------------------

--
-- Structure de la table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL,
  `sort_id` int(11) NOT NULL,
  `fuel_id` int(11) NOT NULL,
  `mark_id` int(11) NOT NULL,
  `situation_id` int(11) NOT NULL,
  `manufacture_date` datetime NOT NULL,
  `length` double DEFAULT NULL,
  `height` double DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `power` int(11) DEFAULT NULL,
  `gearbox` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `beds_number` int(11) NOT NULL,
  `seats_number` int(11) NOT NULL,
  `advert_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `vehicle`
--

INSERT INTO `vehicle` (`id`, `sort_id`, `fuel_id`, `mark_id`, `situation_id`, `manufacture_date`, `length`, `height`, `weight`, `power`, `gearbox`, `beds_number`, `seats_number`, `advert_id`) VALUES
(1, 1, 1, 1, 1, '2019-03-05 00:00:00', 6, 2, 2500, 150, 'Automatique', 4, 4, NULL),
(2, 2, 1, 1, 2, '2019-02-25 00:00:00', 5, 2.5, 2300, 120, 'Manuelle', 3, 4, NULL),
(103, 2, 1, 2, 103, '2019-02-03 00:00:00', 6, NULL, 2360, 130, 'Manuelle', 4, 5, NULL),
(204, 2, 4, 2, 204, '1917-06-03 09:30:18', 4.3, 3.2, 3175, 225, 'Automatique', 7, 9, NULL),
(205, 1, 3, 2, 205, '1912-07-07 05:14:47', 5.7, 3.8, 1323, 213, 'Manuelle', 1, 6, NULL),
(206, 3, 1, 1, 206, '1951-04-19 12:40:25', 6, 2.5, 3728, 183, 'Automatique', 5, 6, NULL),
(207, 3, 2, 4, 207, '1977-05-01 21:55:36', 6.5, 2.1, 1922, 349, 'Manuelle', 3, 4, NULL),
(208, 3, 1, 4, 208, '1991-11-16 10:44:17', 4.1, 3, 1897, 205, 'Automatique', 5, 1, NULL),
(209, 2, 1, 4, 209, '1978-02-04 11:07:54', 5.5, 3.3, 2193, 200, 'Manuelle', 8, 8, NULL),
(210, 1, 1, 1, 210, '1962-01-20 19:20:58', 4.1, 3.2, 3508, 147, 'Automatique', 10, 8, NULL),
(211, 3, 1, 4, 211, '1995-11-01 03:32:16', 4.9, 3.1, 2274, 117, 'Manuelle', 6, 6, NULL),
(212, 1, 2, 4, 212, '2007-12-16 23:14:11', 4.8, 3.9, 686, 171, 'Automatique', 6, 7, NULL),
(213, 1, 2, 1, 213, '1930-08-04 23:12:19', 3.1, 3.8, 1377, 267, 'Manuelle', 10, 10, NULL),
(215, 2, 1, 3, 215, '1967-03-27 16:30:48', 4.1, 3.9, 984, 175, 'Manuelle', 6, 8, NULL),
(216, 1, 4, 2, 216, '1908-01-05 16:31:01', 6.9, 2.4, 2375, 314, 'Automatique', 6, 7, NULL),
(217, 2, 1, 4, 217, '1910-05-16 08:27:48', 6.3, 2.8, 3888, 203, 'Manuelle', 9, 5, NULL),
(218, 1, 1, 1, 218, '1916-04-07 04:10:38', 4.6, 3.6, 819, 105, 'Automatique', 8, 1, NULL),
(219, 2, 1, 2, 219, '2014-06-26 14:55:35', 5.3, 3.4, 1815, 244, 'Manuelle', 9, 7, NULL),
(220, 1, 1, 1, 220, '1951-07-30 22:47:15', 5.6, 3.9, 587, 350, 'Automatique', 4, 9, NULL),
(221, 1, 1, 4, 221, '1964-09-17 06:25:57', 4.2, 3.9, 3374, 227, 'Manuelle', 6, 3, NULL),
(222, 1, 2, 3, 222, '1983-01-15 00:51:25', 4.8, 3.9, 2680, 173, 'Automatique', 10, 1, NULL),
(223, 2, 4, 2, 223, '2018-01-09 19:51:36', 4.8, 3.8, 2860, 212, 'Manuelle', 9, 4, NULL),
(224, 2, 1, 4, 224, '1909-09-01 17:18:46', 5.1, 4, 3573, 348, 'Automatique', 5, 2, NULL),
(225, 1, 1, 4, 225, '1977-04-23 14:39:11', 6.5, 2.2, 3861, 268, 'Manuelle', 8, 4, NULL),
(226, 1, 2, 4, 226, '1985-10-20 01:45:35', 4.8, 3.1, 2417, 128, 'Automatique', 1, 2, NULL),
(227, 1, 3, 4, 227, '1942-04-30 02:59:16', 4.3, 3.4, 3806, 149, 'Manuelle', 2, 1, NULL),
(228, 2, 1, 2, 228, '1920-02-03 18:44:20', 5.5, 3.4, 851, 126, 'Automatique', 4, 3, NULL),
(229, 3, 4, 1, 229, '1936-10-27 08:04:45', 6.3, 2.4, 1021, 129, 'Manuelle', 5, 2, NULL),
(230, 2, 4, 3, 230, '1995-01-09 23:11:59', 4.6, 3.9, 2911, 327, 'Automatique', 1, 4, NULL),
(231, 2, 4, 1, 231, '1986-01-02 18:26:28', 6.1, 3.3, 3965, 323, 'Manuelle', 2, 1, NULL),
(232, 2, 1, 3, 232, '1927-09-20 19:57:33', 3.1, 2.6, 2716, 322, 'Automatique', 10, 6, NULL),
(233, 3, 4, 4, 233, '1930-12-10 05:51:31', 6.4, 3, 1071, 127, 'Manuelle', 8, 8, NULL),
(234, 3, 1, 2, 234, '1960-02-22 15:25:04', 6.4, 2.2, 2309, 328, 'Automatique', 9, 8, NULL),
(235, 3, 1, 2, 235, '1969-10-15 18:11:48', 5.5, 2.6, 2222, 321, 'Manuelle', 8, 7, NULL),
(236, 2, 2, 1, 236, '1922-02-21 18:59:48', 4.9, 3.2, 1539, 185, 'Automatique', 4, 1, NULL),
(237, 3, 4, 2, 237, '1924-05-01 09:09:30', 4.1, 3.4, 736, 195, 'Manuelle', 8, 1, NULL),
(238, 1, 2, 2, 238, '1942-09-01 09:54:52', 4.5, 3.7, 3515, 204, 'Automatique', 3, 4, NULL),
(239, 1, 3, 3, 239, '1933-12-05 00:10:39', 5.4, 3.4, 3642, 208, 'Manuelle', 10, 5, NULL),
(240, 2, 2, 3, 240, '1979-08-26 10:50:55', 4.8, 2.3, 2578, 346, 'Automatique', 3, 4, NULL),
(241, 1, 3, 3, 241, '1934-06-14 07:35:24', 5.4, 3.3, 893, 236, 'Manuelle', 1, 5, NULL),
(242, 1, 1, 3, 242, '2011-06-26 21:49:26', 4.9, 2.1, 3815, 181, 'Automatique', 6, 5, NULL),
(243, 1, 3, 2, 243, '1929-04-28 03:39:41', 3.2, 2.1, 3410, 236, 'Manuelle', 4, 8, NULL),
(244, 1, 1, 3, 244, '1986-10-01 23:20:14', 3.6, 3, 2997, 142, 'Automatique', 7, 5, NULL),
(245, 3, 4, 3, 245, '1912-07-27 19:15:29', 4.9, 3.3, 3355, 109, 'Manuelle', 8, 9, NULL),
(246, 2, 3, 2, 246, '1933-08-16 23:47:19', 4.8, 3.3, 1166, 303, 'Automatique', 7, 2, NULL),
(247, 2, 1, 4, 247, '1996-02-16 20:38:50', 4.8, 3.8, 3913, 250, 'Manuelle', 3, 1, NULL),
(248, 2, 1, 4, 248, '1967-01-13 09:49:19', 6.2, 3.3, 947, 248, 'Automatique', 3, 7, NULL),
(249, 1, 4, 3, 249, '1940-09-05 09:01:01', 4.8, 3.5, 3240, 131, 'Manuelle', 8, 9, NULL),
(250, 2, 2, 4, 250, '1935-12-24 11:07:22', 4.2, 4, 2331, 307, 'Automatique', 1, 6, NULL),
(251, 2, 2, 4, 251, '1944-08-22 13:41:55', 3.4, 2.1, 3111, 180, 'Manuelle', 2, 5, NULL),
(252, 2, 1, 3, 252, '2001-04-16 05:51:00', 3.6, 3.7, 3639, 311, 'Automatique', 10, 6, NULL),
(253, 2, 1, 2, 253, '1916-05-06 02:03:47', 5.8, 3.3, 2950, 119, 'Manuelle', 3, 3, NULL),
(254, 1, 2, 4, 254, '2001-01-20 12:41:54', 3.1, 2.9, 1133, 344, 'Automatique', 1, 9, NULL),
(255, 2, 4, 4, 255, '1998-07-14 22:26:34', 6.9, 2.2, 1366, 284, 'Manuelle', 8, 7, NULL),
(256, 2, 2, 3, 256, '1967-06-11 17:29:51', 3.6, 2.3, 1707, 340, 'Automatique', 8, 1, NULL),
(257, 3, 4, 2, 257, '1903-06-04 20:11:19', 4.1, 3.2, 3472, 326, 'Manuelle', 6, 5, NULL),
(258, 1, 2, 1, 258, '1916-05-14 15:28:42', 5.7, 2, 2031, 239, 'Automatique', 7, 8, NULL),
(259, 1, 3, 2, 259, '1986-06-28 03:21:13', 6.4, 3.9, 2167, 125, 'Manuelle', 6, 10, NULL),
(260, 1, 1, 3, 260, '1995-06-01 19:43:49', 4.9, 3.7, 1314, 182, 'Automatique', 10, 6, NULL),
(261, 2, 3, 2, 261, '1908-05-16 00:13:25', 4.7, 3.8, 2522, 226, 'Manuelle', 4, 6, NULL),
(262, 2, 4, 1, 262, '1941-01-30 13:05:20', 3.9, 3.6, 2529, 171, 'Automatique', 2, 5, NULL),
(263, 1, 1, 3, 263, '1912-03-09 12:17:11', 3.4, 3.2, 1833, 231, 'Manuelle', 7, 8, NULL),
(264, 3, 4, 4, 264, '1968-05-26 01:53:42', 5.1, 2.2, 875, 247, 'Automatique', 1, 10, NULL),
(265, 3, 2, 2, 265, '1959-12-10 10:46:03', 3.6, 2.7, 3252, 250, 'Manuelle', 6, 4, NULL),
(266, 1, 1, 1, 266, '1933-12-19 05:33:14', 3.8, 3.7, 2611, 228, 'Automatique', 7, 6, NULL),
(267, 3, 3, 2, 267, '1965-06-25 00:17:39', 6.8, 3.8, 942, 329, 'Manuelle', 4, 2, NULL),
(268, 2, 1, 3, 268, '1924-09-28 09:33:22', 5.2, 2.6, 2634, 199, 'Automatique', 8, 2, NULL),
(269, 1, 1, 1, 269, '1931-06-15 04:39:19', 4.6, 2.7, 2595, 134, 'Manuelle', 3, 10, NULL),
(270, 2, 4, 3, 270, '1987-04-03 16:37:07', 4, 3.7, 3454, 266, 'Automatique', 4, 3, NULL),
(271, 2, 3, 2, 271, '2017-07-30 22:02:17', 5.2, 2.9, 2004, 331, 'Manuelle', 7, 9, NULL),
(272, 3, 3, 3, 272, '2013-11-06 23:55:58', 3, 3.6, 906, 206, 'Automatique', 2, 2, NULL),
(273, 1, 3, 4, 273, '1996-01-07 21:42:33', 5, 3.3, 2419, 340, 'Manuelle', 2, 8, NULL),
(274, 3, 3, 3, 274, '1965-01-20 17:03:53', 4.8, 3.4, 3777, 322, 'Automatique', 10, 3, NULL),
(275, 3, 2, 3, 275, '1907-05-10 07:27:58', 6.7, 3.1, 3057, 260, 'Manuelle', 2, 5, NULL),
(276, 1, 3, 3, 276, '1942-07-19 00:59:02', 3.7, 3.5, 1975, 187, 'Automatique', 4, 3, NULL),
(277, 2, 4, 4, 277, '1932-09-05 13:03:11', 6.7, 2, 3414, 245, 'Manuelle', 1, 7, NULL),
(278, 2, 2, 4, 278, '1930-05-04 11:51:26', 4.6, 3.9, 1912, 255, 'Automatique', 6, 1, NULL),
(279, 2, 3, 1, 279, '1975-11-16 06:17:15', 3.6, 3.5, 551, 252, 'Manuelle', 5, 4, NULL),
(280, 2, 1, 3, 280, '1934-02-09 22:55:09', 4, 3, 2216, 136, 'Automatique', 8, 10, NULL),
(281, 1, 1, 4, 281, '1922-02-14 02:27:09', 4.4, 2.7, 979, 202, 'Manuelle', 2, 8, NULL),
(282, 1, 3, 4, 282, '2007-11-09 23:27:06', 3.1, 3.3, 3570, 292, 'Automatique', 9, 4, NULL),
(283, 3, 4, 4, 283, '1934-12-08 08:57:49', 3.4, 3.3, 1549, 134, 'Manuelle', 4, 6, NULL),
(284, 3, 1, 1, 284, '1964-11-11 19:24:00', 6.9, 3.6, 3874, 256, 'Automatique', 6, 10, NULL),
(285, 3, 2, 4, 285, '2002-06-29 04:32:17', 5.9, 2.9, 1424, 102, 'Manuelle', 4, 8, NULL),
(286, 1, 2, 1, 286, '1944-07-20 16:59:11', 4.5, 2.6, 3560, 338, 'Automatique', 3, 5, NULL),
(287, 2, 2, 2, 287, '1986-03-16 18:44:36', 5.3, 2.3, 3657, 270, 'Manuelle', 4, 9, NULL),
(288, 1, 4, 1, 288, '1947-02-23 11:37:56', 4.5, 3.1, 3060, 313, 'Automatique', 8, 2, NULL),
(289, 2, 4, 3, 289, '2007-02-23 04:55:02', 4.8, 3, 2038, 325, 'Manuelle', 4, 1, NULL),
(290, 1, 3, 1, 290, '1959-05-25 13:53:46', 5, 3.8, 1921, 299, 'Automatique', 4, 1, NULL),
(291, 2, 1, 2, 291, '1929-08-24 21:02:54', 4.5, 3.4, 3399, 287, 'Manuelle', 5, 2, NULL),
(292, 1, 4, 4, 292, '1989-04-10 11:00:59', 3.2, 3.4, 2597, 345, 'Automatique', 4, 7, NULL),
(293, 3, 2, 3, 293, '2015-08-13 13:39:36', 3.9, 2.8, 3580, 135, 'Manuelle', 3, 1, NULL),
(294, 3, 4, 3, 294, '1921-09-12 06:37:33', 6.9, 2.3, 1252, 147, 'Automatique', 5, 6, NULL),
(295, 1, 3, 3, 295, '1908-02-20 16:10:38', 4.5, 3.3, 2935, 121, 'Manuelle', 4, 1, NULL),
(296, 1, 4, 1, 296, '1928-03-31 18:54:07', 5, 2.2, 694, 265, 'Automatique', 1, 7, NULL),
(297, 2, 2, 2, 297, '2007-10-12 15:30:53', 4.5, 3.4, 1397, 234, 'Manuelle', 6, 3, NULL),
(298, 3, 1, 4, 298, '1956-04-29 11:42:38', 6.7, 3.8, 1993, 218, 'Automatique', 5, 5, NULL),
(299, 3, 3, 2, 299, '1992-01-25 04:07:02', 3.1, 3.2, 3233, 160, 'Manuelle', 7, 1, NULL),
(300, 3, 3, 1, 300, '1990-10-03 07:29:32', 3.9, 3.9, 3875, 130, 'Automatique', 9, 7, NULL),
(301, 3, 1, 4, 301, '1915-06-02 16:50:22', 4.3, 2.6, 871, 192, 'Manuelle', 9, 4, NULL),
(302, 1, 4, 3, 302, '1913-03-07 03:41:42', 6.9, 3.1, 3916, 271, 'Automatique', 6, 1, NULL),
(303, 3, 4, 2, 303, '1925-09-14 07:56:19', 4.8, 2.7, 1222, 234, 'Manuelle', 4, 9, NULL),
(304, 3, 4, 2, 304, '2019-02-03 00:00:00', 6, 2, 2500, 156, 'Manuelle', 4, 4, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `advert`
--
ALTER TABLE `advert`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_54F1F40B545317D1` (`vehicle_id`);

--
-- Index pour la table `duration`
--
ALTER TABLE `duration`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `equipment_vehicle`
--
ALTER TABLE `equipment_vehicle`
  ADD PRIMARY KEY (`equipment_id`,`vehicle_id`),
  ADD KEY `IDX_6DFB2B69517FE9FE` (`equipment_id`),
  ADD KEY `IDX_6DFB2B69545317D1` (`vehicle_id`);

--
-- Index pour la table `fuel`
--
ALTER TABLE `fuel`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `included_mileage`
--
ALTER TABLE `included_mileage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_EE4B960FD07ECCB6` (`advert_id`),
  ADD KEY `IDX_EE4B960F37B987D8` (`duration_id`);

--
-- Index pour la table `insurance`
--
ALTER TABLE `insurance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_640EAF4CD07ECCB6` (`advert_id`);

--
-- Index pour la table `insurance_price`
--
ALTER TABLE `insurance_price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_651C18DA37B987D8` (`duration_id`),
  ADD KEY `IDX_651C18DAD1E63CD1` (`insurance_id`);

--
-- Index pour la table `mark`
--
ALTER TABLE `mark`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `period`
--
ALTER TABLE `period`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C5B81ECE4EC001D1` (`season_id`),
  ADD KEY `IDX_C5B81ECED07ECCB6` (`advert_id`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_14B78418D07ECCB6` (`advert_id`);

--
-- Index pour la table `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CAC822D9D07ECCB6` (`advert_id`),
  ADD KEY `IDX_CAC822D94EC001D1` (`season_id`),
  ADD KEY `IDX_CAC822D937B987D8` (`duration_id`);

--
-- Index pour la table `price_period`
--
ALTER TABLE `price_period`
  ADD PRIMARY KEY (`price_id`,`period_id`),
  ADD KEY `IDX_8821B69ED614C7E7` (`price_id`),
  ADD KEY `IDX_8821B69EEC8B7ADE` (`period_id`);

--
-- Index pour la table `season`
--
ALTER TABLE `season`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sort`
--
ALTER TABLE `sort`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1B80E486D07ECCB6` (`advert_id`),
  ADD KEY `IDX_1B80E48647013001` (`sort_id`),
  ADD KEY `IDX_1B80E48697C79677` (`fuel_id`),
  ADD KEY `IDX_1B80E4864290F12B` (`mark_id`),
  ADD KEY `IDX_1B80E4863408E8AF` (`situation_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=305;

--
-- AUTO_INCREMENT pour la table `advert`
--
ALTER TABLE `advert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=309;

--
-- AUTO_INCREMENT pour la table `duration`
--
ALTER TABLE `duration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `fuel`
--
ALTER TABLE `fuel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `included_mileage`
--
ALTER TABLE `included_mileage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=607;

--
-- AUTO_INCREMENT pour la table `insurance`
--
ALTER TABLE `insurance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT pour la table `insurance_price`
--
ALTER TABLE `insurance_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;

--
-- AUTO_INCREMENT pour la table `mark`
--
ALTER TABLE `mark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `period`
--
ALTER TABLE `period`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=603;

--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=842;

--
-- AUTO_INCREMENT pour la table `price`
--
ALTER TABLE `price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1255;

--
-- AUTO_INCREMENT pour la table `season`
--
ALTER TABLE `season`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `sort`
--
ALTER TABLE `sort`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=305;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `advert`
--
ALTER TABLE `advert`
  ADD CONSTRAINT `FK_54F1F40B545317D1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`);

--
-- Contraintes pour la table `equipment_vehicle`
--
ALTER TABLE `equipment_vehicle`
  ADD CONSTRAINT `FK_6DFB2B69517FE9FE` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_6DFB2B69545317D1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `included_mileage`
--
ALTER TABLE `included_mileage`
  ADD CONSTRAINT `FK_EE4B960F37B987D8` FOREIGN KEY (`duration_id`) REFERENCES `duration` (`id`),
  ADD CONSTRAINT `FK_EE4B960FD07ECCB6` FOREIGN KEY (`advert_id`) REFERENCES `advert` (`id`);

--
-- Contraintes pour la table `insurance`
--
ALTER TABLE `insurance`
  ADD CONSTRAINT `FK_640EAF4CD07ECCB6` FOREIGN KEY (`advert_id`) REFERENCES `advert` (`id`);

--
-- Contraintes pour la table `insurance_price`
--
ALTER TABLE `insurance_price`
  ADD CONSTRAINT `FK_651C18DA37B987D8` FOREIGN KEY (`duration_id`) REFERENCES `duration` (`id`),
  ADD CONSTRAINT `FK_651C18DAD1E63CD1` FOREIGN KEY (`insurance_id`) REFERENCES `insurance` (`id`);

--
-- Contraintes pour la table `period`
--
ALTER TABLE `period`
  ADD CONSTRAINT `FK_C5B81ECE4EC001D1` FOREIGN KEY (`season_id`) REFERENCES `season` (`id`),
  ADD CONSTRAINT `FK_C5B81ECED07ECCB6` FOREIGN KEY (`advert_id`) REFERENCES `advert` (`id`);

--
-- Contraintes pour la table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `FK_14B78418D07ECCB6` FOREIGN KEY (`advert_id`) REFERENCES `advert` (`id`);

--
-- Contraintes pour la table `price`
--
ALTER TABLE `price`
  ADD CONSTRAINT `FK_CAC822D937B987D8` FOREIGN KEY (`duration_id`) REFERENCES `duration` (`id`),
  ADD CONSTRAINT `FK_CAC822D94EC001D1` FOREIGN KEY (`season_id`) REFERENCES `season` (`id`),
  ADD CONSTRAINT `FK_CAC822D9D07ECCB6` FOREIGN KEY (`advert_id`) REFERENCES `advert` (`id`);

--
-- Contraintes pour la table `price_period`
--
ALTER TABLE `price_period`
  ADD CONSTRAINT `FK_8821B69ED614C7E7` FOREIGN KEY (`price_id`) REFERENCES `price` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_8821B69EEC8B7ADE` FOREIGN KEY (`period_id`) REFERENCES `period` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `FK_1B80E4863408E8AF` FOREIGN KEY (`situation_id`) REFERENCES `address` (`id`),
  ADD CONSTRAINT `FK_1B80E4864290F12B` FOREIGN KEY (`mark_id`) REFERENCES `mark` (`id`),
  ADD CONSTRAINT `FK_1B80E48647013001` FOREIGN KEY (`sort_id`) REFERENCES `sort` (`id`),
  ADD CONSTRAINT `FK_1B80E48697C79677` FOREIGN KEY (`fuel_id`) REFERENCES `fuel` (`id`),
  ADD CONSTRAINT `FK_1B80E486D07ECCB6` FOREIGN KEY (`advert_id`) REFERENCES `advert` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
