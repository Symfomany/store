-- phpMyAdmin SQL Dump
-- version 4.2.6deb1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 07 Avril 2015 à 09:54
-- Version du serveur :  5.5.41-0ubuntu0.14.10.1
-- Version de PHP :  5.5.12-2ubuntu4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `alittlejewerly`
--

-- --------------------------------------------------------

--
-- Structure de la table `business`
--

CREATE TABLE IF NOT EXISTS `business` (
`id` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `message` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_expired` datetime DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
`id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` longtext COLLATE utf8_unicode_ci,
  `date_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
`id` int(11) NOT NULL,
  `jeweler_id` int(11) DEFAULT NULL,
  `title` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `position` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id`, `jeweler_id`, `title`, `description`, `position`, `active`) VALUES
(1, 1, 'Colliers', 'Tous les colliers', 1, 1),
(2, 1, 'Sautoirs', 'Tous les sautoirs', NULL, 1),
(3, NULL, 'Bracelets', 'Tous les bracelets', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `cms`
--

CREATE TABLE IF NOT EXISTS `cms` (
`id` int(11) NOT NULL,
  `jeweler_id` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `image` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `view` int(11) DEFAULT NULL,
  `date_active` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `date_created` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `cms`
--

INSERT INTO `cms` (`id`, `jeweler_id`, `title`, `summary`, `description`, `image`, `video`, `state`, `active`, `view`, `date_active`, `date_updated`, `date_created`) VALUES
(1, 1, 'Pages sur nos colliers design', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tempus pellentesque tincidunt. Aliquam nibh neque, tempor id nibh ac, ultrices porttitor orci. Nam nec dolor ligula. Vivamus bibendum ornare porttitor. Duis dignissim vel metus ornare varius. Phasellus ornare risus velit, a porta ipsum placerat a. Ut at scelerisque est. Duis et arcu turpis.\r\n', 'Sed ut euismod sem. Integer blandit, diam a tincidunt finibus, lectus leo mattis ante, nec facilisis purus purus at elit. Suspendisse hendrerit quis magna et vestibulum. Duis velit neque, pretium vestibulum vehicula ut, fermentum eu lectus. Aliquam erat volutpat. Aliquam facilisis nisl sed leo fringilla, nec vulputate dolor ullamcorper. Duis ac ultricies arcu, at sodales ligula. Donec lacinia lacus lectus, eu aliquet mauris luctus sit amet. Suspendisse vitae tellus id enim auctor fermentum vel in neque. Donec efficitur odio sit amet ipsum dapibus, ac elementum orci finibus. Donec non sodales diam. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.\r\n', NULL, NULL, 1, 1, NULL, '2015-04-05 00:00:00', '2015-04-05 00:00:00', '2015-04-05 00:00:00'),
(2, 1, 'Pages sur nos bracelets Glamours', 'Maecenas eu hendrerit ipsum. Aliquam maximus orci id sapien laoreet, eget elementum ipsum maximus. Morbi efficitur augue ut consequat euismod. Quisque a felis in eros congue cursus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean non leo eu ex imperdiet vulputate. Vivamus varius placerat placerat. Sed ligula mauris, sagittis et ipsum eu, sodales finibus mi. Vivamus nec tortor eu ante vulputate viverra id ac quam. Nullam purus felis, efficitur accumsan vehicula at, efficitur viverra elit.\r\n', 'Aliquam erat volutpat. Quisque viverra rutrum tellus. Proin feugiat iaculis risus, ut faucibus tortor tempor quis. Praesent consequat porttitor augue, ut volutpat nulla tincidunt non. Cras lacus sapien, commodo eget nulla a, tincidunt lacinia mi. Cras et magna sit amet orci interdum ullamcorper. Ut scelerisque lobortis enim sed congue. Etiam lacinia suscipit quam, quis euismod est. Maecenas vulputate molestie magna, et pellentesque magna fermentum ac. Etiam pellentesque at lacus eu mattis. Sed sed pellentesque mauris. Aenean et luctus mi, vel aliquet nisl.\r\n', NULL, NULL, 1, 1, NULL, '2015-04-05 00:00:00', '2015-04-05 00:00:00', '2015-04-05 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
`id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `note` int(11) DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `state` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `comment`
--

INSERT INTO `comment` (`id`, `product_id`, `user_id`, `note`, `content`, `state`, `date_created`) VALUES
(1, 4, 1, 5, 'Très joli collier!', NULL, NULL),
(2, 2, 1, 4, 'C''est beauuuu !!', 1, '2015-04-05 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `jeweler`
--

CREATE TABLE IF NOT EXISTS `jeweler` (
`id` int(11) NOT NULL,
  `username` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `image` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT NULL,
  `locked` tinyint(1) DEFAULT NULL,
  `expired` tinyint(1) DEFAULT NULL,
  `salt` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username_canonical` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_canonical` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credentials_expired` tinyint(4) DEFAULT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fid` int(11) DEFAULT NULL,
  `slug` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accountNonLocked` tinyint(1) DEFAULT NULL,
  `accountNonExpired` tinyint(1) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `jeweler`
--

INSERT INTO `jeweler` (`id`, `username`, `email`, `password`, `title`, `description`, `image`, `type`, `enabled`, `locked`, `expired`, `salt`, `token`, `username_canonical`, `email_canonical`, `credentials_expired`, `credentials_expire_at`, `confirmation_token`, `password_requested_at`, `fid`, `slug`, `accountNonLocked`, `accountNonExpired`, `date_created`) VALUES
(1, 'admin', 'admin@gmail.com', '0c/2Zez1M/U2U0PPr1aDb9I/6/0/v3yMDfLhjjMEvEhNNpM6AfG3UUEB8g9euScmsCI53dKUiG+hRmN47vUX1A==', 'Boutique de Julien', 'Tous les produits de la boutique de Julien', 'https://remixcv-cache.s3-eu-west-1.amazonaws.com/user_thumbnail/1374393875-f175462adf69e6f654469146f8f7ac36.jpeg', 1, 1, 0, 0, '7765e855099f58c3569d3d461e61f153', NULL, 'admin', 'admin@gmail.com', 1, NULL, NULL, NULL, NULL, 'boutique-de-julien', 1, 1, '2015-04-05 12:25:00'),
(2, '3wa', 'contact@3wa.fr', 'wXaySL6/vdz2zclUwNQ2bDrgEKeTjW3lw0CHNyAIQJLSdO49Fa1rqtSfP0l2e7wyMadGyYaxuRF03x9EmB3lmA==', 'Boutique de 3WA', 'Tous les produit de la boutique de la 3WA', 'https://3wa.fr/wp-content/themes/3wa/images/logos/big.gif', 1, 1, 0, 0, '7826bbce220f402cb777b9b2e2c50e15', NULL, '3wa', 'contact@3wa.fr', 1, NULL, NULL, NULL, NULL, 'boutique-de-troiswa', 1, 1, '2015-04-06 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `jeweler_meta`
--

CREATE TABLE IF NOT EXISTS `jeweler_meta` (
`id` int(11) NOT NULL,
  `jeweler_id` int(11) NOT NULL,
  `city` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `retour` text COLLATE utf8_unicode_ci,
  `propos` text COLLATE utf8_unicode_ci,
  `delai` text COLLATE utf8_unicode_ci,
  `longituide` float DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `optin` tinyint(1) DEFAULT NULL,
  `last_activity` int(11) DEFAULT NULL,
  `mention` text COLLATE utf8_unicode_ci,
  `expedition` text COLLATE utf8_unicode_ci,
  `dawanda` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `littlemarket` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `jeweler_meta`
--

INSERT INTO `jeweler_meta` (`id`, `jeweler_id`, `city`, `address`, `phone`, `website`, `retour`, `propos`, `delai`, `longituide`, `latitude`, `optin`, `last_activity`, `mention`, `expedition`, `dawanda`, `littlemarket`) VALUES
(1, 1, 'Lyon', '26 Rue Emile Decorps', '0674585648', 'http://www.meetserious.com', 'Aucun retour possible', NULL, '48h.', NULL, NULL, 1, NULL, NULL, NULL, 'http://fr.dawanda.com/shop/victoireandmatilda', 'http://www.alittlemarket.com/boutique/perea_bijoux-279514.html'),
(2, 2, 'Paris', '12 Rue Mandar', '0148253677', 'http://www.3wa.fr', 'Retour 7 jours', NULL, NULL, 45.2456, 2.5655, 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `like`
--

CREATE TABLE IF NOT EXISTS `like` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
`id` int(11) NOT NULL,
  `jeweler_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `state` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `jeweler_id` int(11) DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `date` date DEFAULT NULL,
  `total` float DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Contenu de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `jeweler_id`, `address`, `date`, `total`, `state`, `date_created`) VALUES
(1, 1, 1, '14 Rue de mandar 75002 Paris', '2015-04-05', 150, 1, '2015-03-16 00:00:00'),
(3, 2, 1, '14 Rue de la Madeleine', '2015-04-03', 85, 1, '2015-01-06 00:00:00'),
(4, 1, 1, '26 Rue EMile Decorps Villeurbanne', '2015-03-02', 85.7, 1, '2015-02-10 00:00:00'),
(5, 1, 1, '26 Rue EMile Decorps Villeurbanne', '2015-02-24', 72.3, 1, '2015-04-05 00:00:00'),
(6, 1, 1, '26 Rue Emile Decorps Villeurbanne', '2015-04-01', 60, 1, '2014-12-24 00:00:00'),
(7, 1, 1, '26 Rue Emile Decorps Villeurbanne', '2015-04-16', 102.6, 1, '2015-03-16 00:00:00'),
(8, 1, 1, '12 Rue Emile Decorps', '2015-04-14', 66.2, 1, '2014-11-10 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `order_detail`
--

CREATE TABLE IF NOT EXISTS `order_detail` (
  `order_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
`id` int(11) NOT NULL,
  `jeweler_id` int(11) NOT NULL,
  `ref` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `composition` text COLLATE utf8_unicode_ci,
  `price` float DEFAULT NULL,
  `taxe` float DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `date_active` datetime DEFAULT NULL,
  `cover` tinyint(1) DEFAULT NULL,
  `shop` tinyint(1) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `slug` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Contenu de la table `product`
--

INSERT INTO `product` (`id`, `jeweler_id`, `ref`, `title`, `summary`, `description`, `composition`, `price`, `taxe`, `quantity`, `active`, `date_active`, `cover`, `shop`, `position`, `slug`, `date_created`, `date_updated`) VALUES
(1, 1, 'FR01', 'LAURA Collier élégant', 'Ce bijou est composé d''un jolie danseuse strassée bleue réhaussée d''une goutte translucide facettée  et d''un anneau bleu bermude SWAROVSKI . Il est accompagné d''une chaîne jaseron en acier inoxydable réglable de grande qualité.', 'Ecrin de bijoux vous propose ce collier très élégant qui donnera une touche de romantisme à tous les styles. A toutes les occasions décontractées ou plus chic, c''est un bijou qui s''adapte à tous les looks.\r\n\r\nRien n''est laissé au hasard pour une  recherche constante de qualité, vous remarquerez la noblesse des composants : cristal SWAROVSKI aux reflets incomparables, beauté aérienne du charm "ballerine" avec ses multiples strasse turquoise, qualité de la chaîne jaseron et des différents apprêts.\r\n\r\nIl est parfait pour ajouter une note élégante et raffinée. Son design aérien créé par l''agencement original et artistique  de ses composants en font une création unique. Pour un cadeau, quelle qu''en soit l''occasion, ce n''est pas un bijou cher compte tenu tenu de tous ses atouts. Vous pouvez l''acheter "les yeux fermés".', 'un anneau évidé bleu bermude SWAROVSKI AB (brillance qualité supérieure) 14 mm, une danseuse en inox strassée bleue 30 mm, une goutte facettée SWAROVSKI translucide12 mm', 40.8, 20, 5, 1, '2015-04-05 00:00:00', 1, 1, NULL, NULL, '2015-04-05 00:00:00', NULL),
(2, 1, 'FR02', 'ALYCIA Collier', 'C''est un collier facile à porter qui confère  une allure élégante et sobre.Sobriété, luminosité et chic sont les termes qui le caractérisent le mieux.\r\n', 'Ce bijou est composé d''une jolie chouette strassée blanche mise en valeur par un câble réglable orné de 2 perles nacrées, de  2 perles disco SWAROVSKI  translucides d''un éclat incomparable et de 2 perles tubes plaqué argent. Fidèle à sa politique de création artistique, Ecrin de Bijoux vous garantit de posséder, pour un prix très attractif, un bijou fantaisie fait main, original, unique et de qualité supérieure compte-tenu de la noblesse des composants choisis.', 'SWAROVSKI AB (brillance supérieure) : 2 perles DISCO facettées translucides + 2 perles nacrées bleu nuit 4 mm', 39.4, 20, 7, 1, '2015-04-05 00:00:00', 1, 1, 2, NULL, '2015-04-05 00:00:00', '2015-04-05 00:00:00'),
(3, 1, 'FR03', 'ZOE Collier', 'Fidèle à sa recherche constante de créativité, d''originalité et de qualité, Ecrin de Bijoux vous propose de bijou  raffiné et très gracieux. Beaucoup de poésie, d''originalité et d''éclat se dégagent de cette création qui mettra en valeur toutes les tenues. Ses couleurs délicates raffinées et très lumineuses apportent une touche de fraîcheur et rendent ce collier très attrayant et seyan', 'Vous pouvez acheter ce collier pour un prix très abordable compte tenu de tous ses atouts, il sera idéal pour faire un cadeau en toutes circonstances : Fête des Mères, anniversaires, Saint-Valentin....ou plus simplement pour faire plaisir, c''est un bijou qui durera longtemps et et qui est facile à assortir à toutes les tenues.\r\n\r\nCe collier est composé d''une chaîne jaseron réglable en acier inoxydable joliement embellie d''éléments SWAROVSKI  et d''un charm pieuvre strassée accompagnée de sa rondelle perlée bleue.', 'charm "pieuvre" acier inoxydable avec strass bleus 3 cm hauteur + rondelle 2 cm diamètre acier perles bleues', 44.2, 20, 10, 1, '2015-04-05 00:00:00', 1, 1, 3, NULL, '2015-04-05 00:00:00', '2015-04-05 00:00:00'),
(4, 1, 'FR05', 'OLGA Collier', 'Très romantique, ce collier est extrêmement raffiné. L''association des perles nacrées et disco convient  parfaitement au thème du collier et lui  donnent beaucoup de glamour.\r\nLa noblesse de ses composants ainsi que leur agencement très original font de ce bjou une création unique que vous pouvez acheter pour un prix très raisonnable.', 'Il se compose d''un câble bleu roi réglable accompagné d''une danseuse strassée bleue nuit réhaussée de 2 perles disco SWAROVSKI qui scintillent de mille feux, de 4 perles nacrées. Il possède en breloque un joli petit coeur SWAROVSKI vitrail et un coeur argenté vieilli finement ciselé.\r\n\r\nCe collier au design léger et aérien donne à toutes les tenues et à tous les style une allure chic et très élégant. C''est un cadeau idéal en toutes occasions, il sera très apprécié et durera longtemps, compte tenu de sa qualité.', 'charm danseuse en inox strassée bleue nuit (40 mm) + un petit coeur SWAROVSKI (10 x10 mm) vitrail AB (qualité brillance supérieure) + un coeur en argent vieilli finement gravé (15mmx10mm)', 41.9, 20, 10, 1, '2015-04-05 00:00:00', 1, 1, 4, NULL, '2015-04-05 00:00:00', '2015-04-05 00:00:00'),
(7, 2, 'FR06', 'STELLA Collier créatif', 'Fidèle à sa politique de création artistique, Ecrin de Bijoux vous propose, pour un prix très attractif, ce joli bijou artisanal, original, unique et de qualité supérieure compte-tenu de la noblesse des composants choisis. Il ressort de ce bijou beaucoup de créativité et d''originalité grâce à  la combinaison subtile des couleurs et le choix des matériaux (émail et éléments SWAROVSKI).', 'Il s''agit d''un joli charm "tortue" émaillé dans une mosaique de couleurs accompagné d''un câble orné de perles nacrées, de toupies SWAROVSKI bleu pétrole, beige rosé et verte néon et de perles tubes plaqué argent. C''est une excellente idée de cadeau à offrir en toutes occasions.', '6 perles nacrées Swarovski 4 mm + 8 perles verre thèque turquoise métallisé et bleu iris', 48.2, 20, 8, 1, '2015-04-05 00:00:00', 1, 1, 6, NULL, '2015-04-05 00:00:00', '2015-04-05 00:00:00'),
(8, 2, 'FR06', 'YOKO collier manga', 'L''originalité et le raffinement  caractérisent ce bijou et l''éclat vert tendre de l''élément SWAROVSKI donne beaucoup de poésie à cette création. C''est un cadeau parfait en toutes circonstances pour les personnes qui apprécient l''originalité alliée à la qualité.', 'S''inspirant des mangas, ce collier se compose d''une poupée strassée verte accompagnée de sa chaîne jaseron réglable en acier ornée d''éléments SWAROVSKI : perles nacrées, toupies et octogone. On peut les  porter d''une façon décalée  ou non : d''un côté un octogone vert  clair et de l''autre côté, des perles nacrées bronze et des toupies de 2 tailles et vert différents. Il est réhaussé d''un trio de perles nacrées SWAROVSKI améthyste, bleu  pâle et rose fushia.  Fidèle à sa recherche d''esthétique et d''originalité, ce bijou possède un design très harmonieux, des couleurs très féminines et très douces. Vous pouvez l''acheter pour un prix attractif,  compte tenu de tous ses atouts.', 'jaseron en acier inoxydable qualité 316 ornée d''un octogone SWAROVSKI vert clair (1,5x1,5 cm), de 4 toupies vertes et 2 perles nacrées bronze SWAROVSKI', 45.6, 20, 5, 1, '2015-04-05 00:00:00', 1, 1, 6, NULL, '2015-04-05 00:00:00', '2015-04-05 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `product_business`
--

CREATE TABLE IF NOT EXISTS `product_business` (
  `product_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product_category`
--

CREATE TABLE IF NOT EXISTS `product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `product_category`
--

INSERT INTO `product_category` (`product_id`, `category_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(7, 1),
(8, 1);

-- --------------------------------------------------------

--
-- Structure de la table `product_cms`
--

CREATE TABLE IF NOT EXISTS `product_cms` (
  `product_id` int(11) NOT NULL,
  `cms_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `product_cms`
--

INSERT INTO `product_cms` (`product_id`, `cms_id`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `product_featured`
--

CREATE TABLE IF NOT EXISTS `product_featured` (
  `product_id` int(11) NOT NULL,
  `product2_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `product_featured`
--

INSERT INTO `product_featured` (`product_id`, `product2_id`) VALUES
(4, 1),
(7, 1),
(1, 2),
(1, 3),
(4, 3),
(8, 3),
(1, 4),
(2, 4),
(3, 4),
(1, 7),
(1, 8),
(2, 8);

-- --------------------------------------------------------

--
-- Structure de la table `product_image`
--

CREATE TABLE IF NOT EXISTS `product_image` (
`id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_thumb` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `product_meta`
--

CREATE TABLE IF NOT EXISTS `product_meta` (
`id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `weight` float DEFAULT NULL,
  `length` float DEFAULT NULL,
  `width` float DEFAULT NULL,
  `video` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extras` text COLLATE utf8_unicode_ci,
  `subtitle` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` float DEFAULT NULL,
  `view` int(11) DEFAULT NULL,
  `meta_keyword` text COLLATE utf8_unicode_ci,
  `meta_description` text COLLATE utf8_unicode_ci,
  `meta_title` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `product_supplier`
--

CREATE TABLE IF NOT EXISTS `product_supplier` (
  `product_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `product_supplier`
--

INSERT INTO `product_supplier` (`product_id`, `supplier_id`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 3);

-- --------------------------------------------------------

--
-- Structure de la table `product_tag`
--

CREATE TABLE IF NOT EXISTS `product_tag` (
  `product_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
`id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `caption` text COLLATE utf8_unicode_ci,
  `image` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
`id` int(11) NOT NULL,
  `name` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `image` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `description`, `image`, `active`, `date_created`, `date_updated`) VALUES
(1, 'Swarovski', 'Swarovski est le nom de marque pour les produits en cristal (verre riche en plomb) qui sont produits par les entreprises appartenant à Swarovski International Holdings. C''est un équivalent moderne de ce qui était connu autrefois en France sous le nom de « strass », l''autre verre au plomb porté par les gens d''opéra et les danseurs de cabaret.\r\n', 'http://upload.wikimedia.org/wikipedia/en/thumb/5/55/Swarovski_logo.jpg/200px-Swarovski_logo.jpg', 1, '2015-04-06 00:00:00', '2015-04-06 00:00:00'),
(2, 'Mauboussin', 'Mauboussin est un joaillier réputé, dont la première affaire a été fondée par Monsieur Mauboussin en 1827. La boutique de la place Vendôme à Paris ouvre en 1955.\r\n\r\nEn 1970, la bijouterie apparaît dans le film de Jean-Pierre Melville intitulé Le Cercle rouge.\r\n\r\nLe rachat de la marque par Dominique Frémont (financier suisse) en 2002, dynamise la marque. La direction artistique est confiée à Alain Némarq.\r\n', 'http://www.mauboussin.com/logo_mauboussin.png', 1, '2015-04-06 00:00:00', '2015-04-06 00:00:00'),
(3, 'Cartier', 'Cartier est une entreprise du secteur de luxe qui conçoit, fabrique, distribue et vend des bijoux, des montres et des lunettes et des portefeuilles. Fondée à Paris en 1847 par Louis-François Cartier, l''entreprise est restée sous le contrôle de la famille jusqu''en 1964. La marque est rendue célèbre par son petit fils Louis Cartier. En 1899, Alfred Cartier décide d’implanter l’entreprise familiale 13 rue de la Paix à Paris, adresse actuelle et cœur historique du savoir-faire de l''entreprise', 'http://goodlogo.com/images/logos/cartier_logo_3143.gif', 1, '2015-04-06 00:00:00', '2015-04-06 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
`id` int(11) NOT NULL,
  `word` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `firstname` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fid` int(11) DEFAULT NULL,
  `password` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `active`, `last_login`, `date_created`, `date_updated`, `firstname`, `lastname`, `email`, `fid`, `password`) VALUES
(1, 1, '2015-04-07 00:00:00', NULL, NULL, 'julien', 'boyer', 'julien@meetserious.com', NULL, 'user'),
(2, 1, '2015-04-05 00:00:00', '2015-04-05 00:00:00', '2015-04-05 00:00:00', 'Ludovic', 'Verrecchia', 'ludo.verrecchia@gmail.com', NULL, 'admin2');

-- --------------------------------------------------------

--
-- Structure de la table `user_address`
--

CREATE TABLE IF NOT EXISTS `user_address` (
`id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `city` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zipcode` int(11) DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `user_address`
--

INSERT INTO `user_address` (`id`, `user_id`, `city`, `zipcode`, `address`) VALUES
(1, 1, '14 Rue MAndar', 75002, 'Paris');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `business`
--
ALTER TABLE `business`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
 ADD PRIMARY KEY (`id`), ADD KEY `jeweler_id` (`jeweler_id`);

--
-- Index pour la table `cms`
--
ALTER TABLE `cms`
 ADD PRIMARY KEY (`id`), ADD KEY `jeweler_id` (`jeweler_id`), ADD KEY `jeweler_id_2` (`jeweler_id`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
 ADD PRIMARY KEY (`id`), ADD KEY `product_id` (`product_id`,`user_id`), ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `jeweler`
--
ALTER TABLE `jeweler`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`), ADD UNIQUE KEY `email_2` (`email`);

--
-- Index pour la table `jeweler_meta`
--
ALTER TABLE `jeweler_meta`
 ADD PRIMARY KEY (`id`), ADD KEY `jeweler_id` (`jeweler_id`);

--
-- Index pour la table `like`
--
ALTER TABLE `like`
 ADD PRIMARY KEY (`user_id`,`product_id`), ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
 ADD PRIMARY KEY (`id`), ADD KEY `jeweler_id` (`user_id`), ADD KEY `jeweler_id_2` (`jeweler_id`,`user_id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`), ADD KEY `jeweler_id` (`jeweler_id`);

--
-- Index pour la table `order_detail`
--
ALTER TABLE `order_detail`
 ADD PRIMARY KEY (`order_id`,`product_id`), ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
 ADD PRIMARY KEY (`id`), ADD KEY `jeweler_id` (`jeweler_id`);

--
-- Index pour la table `product_business`
--
ALTER TABLE `product_business`
 ADD PRIMARY KEY (`product_id`,`business_id`), ADD KEY `product_business_ibfk_2` (`business_id`);

--
-- Index pour la table `product_category`
--
ALTER TABLE `product_category`
 ADD PRIMARY KEY (`product_id`,`category_id`), ADD KEY `category_id` (`category_id`);

--
-- Index pour la table `product_cms`
--
ALTER TABLE `product_cms`
 ADD PRIMARY KEY (`product_id`,`cms_id`), ADD KEY `product_id` (`product_id`), ADD KEY `cms_id` (`cms_id`);

--
-- Index pour la table `product_featured`
--
ALTER TABLE `product_featured`
 ADD PRIMARY KEY (`product_id`,`product2_id`), ADD KEY `product2_id` (`product2_id`);

--
-- Index pour la table `product_image`
--
ALTER TABLE `product_image`
 ADD PRIMARY KEY (`id`), ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `product_meta`
--
ALTER TABLE `product_meta`
 ADD PRIMARY KEY (`id`), ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `product_supplier`
--
ALTER TABLE `product_supplier`
 ADD PRIMARY KEY (`product_id`,`supplier_id`), ADD KEY `supplier_id` (`supplier_id`);

--
-- Index pour la table `product_tag`
--
ALTER TABLE `product_tag`
 ADD PRIMARY KEY (`product_id`,`tag_id`), ADD KEY `tag_id` (`tag_id`);

--
-- Index pour la table `slider`
--
ALTER TABLE `slider`
 ADD PRIMARY KEY (`id`), ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `supplier`
--
ALTER TABLE `supplier`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tag`
--
ALTER TABLE `tag`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `user_address`
--
ALTER TABLE `user_address`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `business`
--
ALTER TABLE `business`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `cms`
--
ALTER TABLE `cms`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `jeweler`
--
ALTER TABLE `jeweler`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `jeweler_meta`
--
ALTER TABLE `jeweler_meta`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `product_image`
--
ALTER TABLE `product_image`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `product_meta`
--
ALTER TABLE `product_meta`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `slider`
--
ALTER TABLE `slider`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `supplier`
--
ALTER TABLE `supplier`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `tag`
--
ALTER TABLE `tag`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `user_address`
--
ALTER TABLE `user_address`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `cart`
--
ALTER TABLE `cart`
ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `category`
--
ALTER TABLE `category`
ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`jeweler_id`) REFERENCES `jeweler` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cms`
--
ALTER TABLE `cms`
ADD CONSTRAINT `cms_ibfk_1` FOREIGN KEY (`jeweler_id`) REFERENCES `jeweler` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `jeweler_meta`
--
ALTER TABLE `jeweler_meta`
ADD CONSTRAINT `jeweler_meta_ibfk_1` FOREIGN KEY (`jeweler_id`) REFERENCES `jeweler` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `like`
--
ALTER TABLE `like`
ADD CONSTRAINT `like_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `like_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`jeweler_id`) REFERENCES `jeweler` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`jeweler_id`) REFERENCES `jeweler` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `order_detail`
--
ALTER TABLE `order_detail`
ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`jeweler_id`) REFERENCES `jeweler` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `product_business`
--
ALTER TABLE `product_business`
ADD CONSTRAINT `product_business_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `product_business_ibfk_2` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `product_category`
--
ALTER TABLE `product_category`
ADD CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `product_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `product_cms`
--
ALTER TABLE `product_cms`
ADD CONSTRAINT `product_cms_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `product_cms_ibfk_2` FOREIGN KEY (`cms_id`) REFERENCES `cms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `product_featured`
--
ALTER TABLE `product_featured`
ADD CONSTRAINT `product_featured_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `product_featured_ibfk_2` FOREIGN KEY (`product2_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `product_image`
--
ALTER TABLE `product_image`
ADD CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `product_meta`
--
ALTER TABLE `product_meta`
ADD CONSTRAINT `product_meta_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `product_supplier`
--
ALTER TABLE `product_supplier`
ADD CONSTRAINT `product_supplier_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `product_supplier_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `product_tag`
--
ALTER TABLE `product_tag`
ADD CONSTRAINT `product_tag_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `product_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `slider`
--
ALTER TABLE `slider`
ADD CONSTRAINT `slider_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user_address`
--
ALTER TABLE `user_address`
ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
