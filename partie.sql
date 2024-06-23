SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `politique_cool`
--

-- --------------------------------------------------------

--
-- Structure de la table `partie`
--

DROP TABLE IF EXISTS `partie`;
CREATE TABLE IF NOT EXISTS `partie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `nucleaire` varchar(20) NOT NULL,
  `education` varchar(20) NOT NULL,
  `emploie` varchar(20) NOT NULL,
  `droit_travail` varchar(20) NOT NULL,
  `droit_lgbtquia` varchar(20) NOT NULL,
  `feminisme` varchar(20) NOT NULL,
  `impot` varchar(20) NOT NULL,
  `pouvoir_achat` varchar(20) NOT NULL,
  `ecologie` varchar(20) NOT NULL,
  `retraite` varchar(20) NOT NULL,
  `salaire` varchar(20) NOT NULL,
  `droit_animeaux` varchar(20) NOT NULL,
  `agriculture` varchar(20) NOT NULL,
  `europe` varchar(20) NOT NULL,
  `immigration` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sante` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `partie`
--

INSERT INTO `partie` (`id`, `image`, `name`, `nucleaire`, `education`, `emploie`, `droit_travail`, `droit_lgbtquia`, `feminisme`, `impot`, `pouvoir_achat`, `ecologie`, `retraite`, `salaire`, `droit_animeaux`, `agriculture`, `europe`, `immigration`, `sante`) VALUES
(9, '../uploads/fondCam.jpg', 'Test', '↑', '-', '-', '↑', '-', '-', '-', '-', '-', '-', '-', '-', '-', '↓', '-', '↑');
COMMIT;
