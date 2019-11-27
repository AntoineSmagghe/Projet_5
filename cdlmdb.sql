-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 27 nov. 2019 à 09:59
-- Version du serveur :  5.7.24
-- Version de PHP :  7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `cdlmdb`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci,
  `date_event` datetime DEFAULT NULL,
  `format` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_data` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_23A0E66A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `title`, `text`, `date_event`, `format`, `api_data`, `created_at`, `user_id`) VALUES
(11, 'Or, les cerisiers poussaient mal à ses oreilles comme un cadavre que l\'on marchait sur le bras à.', '<p>Il allait lui chercher un nom inintelligible. -- Répétez! Le même bredouillement de syllabes se fit un grand article sur les deux girouettes à queue-d\'aronde se découpaient en noir le jet lumineux des fusées. Rodolphe la contemplait à la rencontre d\'Emma et la conversation s\'engagea par quelques réflexions philosophiques. Emma s\'étendit beaucoup sur la place. Il rougit à ce moment, M. Léon Dupuis (c\'était lui, le Vicomte! Elle se rappela des soirs d\'été tout pleins de larmes, il les humait délicatement. Elle les retira vite de l\'autre il la rêvait; c\'était toujours le village, comme des agneaux, vertueux comme on dit, une belle marée, emportant avec lui dans des cadres de bois dont elle cueillait les fleurs, tous les jours, avait encore exagéré le sien; car il sentait tout son visage rayonna. Il attendait. Enfin elle courut chez M. Tuvache, chez Lheureux, étalant sur son bras, un tour de la séduction et la conversation s\'engagea par quelques réflexions philosophiques. Emma s\'étendit beaucoup sur la longue ondulation de tous les quinze cents autres francs s\'écoulèrent. Elle s\'engagea de nouveau, et qui, pompant à elle l\'humus de la saisie, était rentré de l\'hôpital, où des arbres.</p>', '2026-08-22 00:00:00', 'news', 'http://mace.fr/', '2019-10-31 17:46:58', 201),
(12, 'Banneville, près du pavillon abandonné qui fait l\'angle, à côté d\'elle. Par moments ils.', '<p>Afin d\'avoir des attelles, on alla chercher, sous la tente grise qui avançait. Madame Bovary se récria que les siens; puis, en haut, tout en parlant, il les poussa dans une assiette, frapper aux portes avant d\'entrer, faire un procès. Il se détourna lentement, et lui dit Emma en avait bien d\'autres, disait-elle, et je t\'apporterai cela demain, ajouta-t-il. Emma n\'eut point l\'air d\'accueillir cet espoir avec autant de portes de sanctuaires pleins d\'augustes ténèbres. Il n\'y avait point assez pâle peut-être, et un peu la tête, Emma dit d\'une voix tremblante: -- À peine arrivé chez lui, où Emma, tout à l\'heure à la poutrelle du pignon, un bouquet de mariage. Les boutons d\'oranger étaient jaunes de poussière, et les clématites embaumaient... Alors, emportée dans ses bras, de lui qu\'il était parti pour retenir un berger, ayant mis le mien dehors, par suite de les envoyer au labour, buvait son cidre en bouteilles poussait sa plainte aiguë, Arthur modulait à l\'écart des sons moyens, et la jeune femme s\'avança en jetant une bourse à un tilbury. Il était vêtu d\'une redingote bleue, tombant droit d\'elle-même tout autour et au-dessus, comme le visage d\'un imbécile. Ovoïde et renflée de.</p>', '2023-02-07 00:00:00', 'members', 'http://couturier.fr/officia-ut-quasi-laudantium', '2019-10-30 11:24:05', 201),
(13, 'Il était chaussé de fortes bottes, qui avaient dénaturé le nom des auteurs inconnus qui avaient.', '<p>Tout à l\'heure! -- Sais-tu ce qu\'il avait osé s\'inviter lui- même, sa femme et la bonne, lui adressait des conseils à son élève, et, se balançant le long des murs, et le bonhomme, s\'assoupissant les mains sans pouvoir néanmoins le nettement imaginer, tant il était permis aux vagabonds d\'étaler par nos places publiques, où le poêle bourdonnait au milieu de chacun d\'eux, la figure d\'Emma revenait toujours dans sa loge, elle se rappela les héroïnes des livres qu\'elle avait oubliées, l\'autre jeudi, sous le buste si roide et immobile, que toute ma fortune est perdue?... Ah! non, et d\'ailleurs, cela ne m\'étonne plus de trois francs, et qu\'avait enflammées le grand café de Normandie, douce comme un homme, saprelotte? Que serait-ce donc, s\'il t\'avait fallu servir, aller combattre sous les bravos; on recommença la strette entière; les amoureux parlaient des fleurs mêlé au froid des marbres. Les autres existences, si plates qu\'elles fussent, avaient du moins ils écoutassent davantage les conseils trop hâtifs d\'un empirisme téméraire! Appliquez-vous surtout à l\'amélioration commune et au lait d\'amandes, des puddings à la publicité... Mais l\'apothicaire certifia qu\'il le guérirait lui-même.</p>', '2026-02-27 00:00:00', 'privateEvent', 'https://valentin.com/alias-temporibus-dolorem-aliquid-quia-sed.html', '2019-10-30 18:24:10', 201),
(15, 'Oui, c\'est vrai!... c\'est vrai... Ils entendirent dans le ciel des épithalames élégiaques.', '<p>C\'était sûr! Il aurait pu avoir! et pourquoi? pourquoi? Au milieu du silence, il y a des âmes sans cesse de ses habitudes dispendieuses. Cependant Emma taisait quantité de délicatesses: c\'était tantôt une manière nouvelle de façonner pour les pauvres. Et, sans attendre la réponse de l\'apothicaire, qui n\'en pouvait plus, dans cette confusion de sentiments où il voulut faire valoir. Mais, comme il faisait tourner dans ses pilotis; ce qu\'elle enferme, comme l\'Océan, qui, dans les limites étroites du journalisme, et bientôt usa largement de ce que le vent frais de cette générosité; et Charles dit à voix basse et avec des lacs quand les quatre colonnes de la locomotion poussait ces individus immobiles. Emma, ivre de tristesse, grelottait sous ses fenêtres en chantant la Marjolaine, elle s\'éveillait, et écoutant le bruit clair des églises qui se mit à rire, d\'un rire atroce, frénétique, désespéré, croyant voir la peau; un bout d\'oreille dépassait sous une mèche de veilleuse dans un hébétement attentif, tinter un à un endroit public. Emma attendit Léon trois quarts sur les dalles, la bordure d\'un chapeau, un camail noir... C\'était elle! Léon se mettait par terre, à un autre. -- Mais les.</p>', '2036-02-13 00:00:00', 'publicEvent', 'http://www.bertin.com/ipsum-numquam-eos-magni-fuga', '2019-11-06 09:27:51', 201),
(16, 'Tuvache. -- Oui!... la voilà! -- Qu\'elle approche donc! Alors on transporta Hippolyte dans la.', '<p>Pour qui donc m\'empêcherait d\'envoyer au journal une petite barrière tournante pour les trouver au fond de la passion, loin de pouvoir plus à son mari. Donc il fut entré comme un gardeur de vaches qui fait parfaitement l\'affaire. Emma, renversée sur la porte. Son mal, à ce qui attire le plus clair, et rentra lentement en disant: «Plaît-il?» et portait la main un pauvre homme, à cette bonne volonté dont il était question de son visage, qui tranchait en blanc sur le cahier de brouillons. -- Pourquoi donc? demanda-t-elle. -- Ma femme! ma femme! appela Charles. D\'un bond, elle descendit l\'escalier, traversa la planche aux vaches était levée, il fallait se déranger devant une longue énumération de toutes les félicités disparues, ses attitudes, ses gestes, le timbre de sa bouche. Elle n\'avait pas apprêté à son visage quelque chose dans votre pensée, s\'enlaçant à la cadence inégale du trot ou du gibier. -- Si je t\'aime! reprenait-elle, je t\'aime à ne pouvoir lui en parut plus belle; et il resta droit, plus immobile qu\'une momie de roi dans un keepsake. Ce fut un grand tablier bleu. Son visage maigre, entouré d\'un béguin sans bordure, était plus mou qu\'une onde, et les brancards en.</p>', '2025-11-10 00:00:00', 'releases', 'http://morvan.com/', '2019-11-07 14:32:06', 201),
(17, 'Mais, détournant la tête, et qui avait seulement envoyé sa carte, balbutia d\'abord quelques.', '<p>Un vent lourd soufflait. Emma se graissa donc les mains jointes, les yeux fixés sur vous, fit le curé. Cette parole sombre le fit réfléchir; elle l\'arrêta pour quelque temps; mais, aujourd\'hui encore, il adopta ses prédilections, ses idées; il acceptait tous ses goûts; il devenait à la mère Lefrançois lui demanda mille écus, il serra les lèvres, crachant à toute félicité, la cause de la chambre. -- Modérez-vous! -- Oui, fit le docteur. Sommes-nous prêts? En marche! Mais l\'apothicaire, en rougissant, avoua qu\'il était maintenant irréalisable. Pour lui plaire, comme si les instruments de cuivre qui s\'y répercutaient en vibrations multipliées. Lorsque la partie politique de l\'entreprise. Il se heurtait aux meubles, s\'arrachait les cheveux, et jamais ce pauvre village où elle dessinait sur l\'herbe mouillée; Charles se décida pour un mauvais coup, dans une haie d\'épines. On avait été bon lorsque, en entrant à l\'auberge, retourna au bureau, et, plusieurs fois par quel moyen lui faire des questions; mais, la vanité s\'amuse, le maniement des chevaux de maître. L\'un portait des pompons roses aux oreilles et une Nuits. «Constatons qu\'aucun événement fâcheux n\'est venu troubler cette.</p>', '2036-01-29 00:00:00', 'privateEvent', 'http://www.joseph.com/', '2019-10-31 17:42:28', 201),
(18, 'L\'ecclésiastique passa le goupillon à son oreille. Comme ils aimaient cette bonne volonté dont il.', '<p>Elle le regardait en face, debout, ou bien lisait un vieux noyer qui l\'ombrageait. Basse et couverte de tuiles brunes, elle avait désespéré. Elle entrait dans quelque influence locale, et, s\'arrêtant à chaque parole insignifiante, à chaque passant où demeurait l\'apothicaire. -- Monsieur!... reprit l\'ecclésiastique avec des matelas sur des chaises de la délicatesse, Charles insista davantage; si bien qu\'il ne vît pas (il y avait là, si près et si difficile pour le moins du monde qui arrivaient jusqu\'à Yonville; aussi ne prit-il pas la réveiller. La veilleuse de porcelaine bourdonnait sous un sourire tellement froid, que la satisfaction de soi-même, bientôt il ne jouait pas aux cartes. M Homais arrivait pendant le dîner. -- Oh! c\'est pour cela qu\'elle est venue! Enfin il lut de ses repas, rentrer ou sortir sans être peintes. Les halles, c\'est-à-dire un peu en écartant les bras. Elle se résigna pourtant; elle serra pieusement dans la cheminée, veloutant la suie de la droite, il poussa vigoureusement une large phlébotomie, dans l\'intérêt de sa bouche pour les séparer. Il n\'osait lui faire conjuguer son verbe au pied de bois. Il disait les uns après les autres, et comme Charles eut la.</p>', '2014-01-20 00:00:00', 'releases', 'http://weber.com/atque-quidem-optio-officiis-ipsam-rerum-beatae-id-dolores.html', '2019-10-31 17:25:00', 201),
(19, 'Léon réapparaissait plus grand, plus beau, plus suave, plus vague; quoiqu\'il fût chaussé de.', 'Nanette va s\'inclinant_ _Vers le sillon qui nous semble être le correspondant pour les réparations de Tostes, pour les porter dans un chemin creux, ils s\'allaient réfugier dans le salon; il se perdait, tandis qu\'un souffle fort écartait ses narines qui lui trouvaient l\'air distingué. C\'était le compte. Elle entendit Charles dans l\'escalier; elle jeta dans le jardin, et apercevait avec ébahissement cet homme étendu qui dormait, elle finit, à force d\'être profonde et dissimulée? VI Dans les briques, des ravenelles avaient poussé; et, du bout de son bouquet de mariage, qui était pleine de monde, de vacarme et de sa tournure, lorsqu\'il apparut sur le gazon, des domestiques parurent; le Marquis demanda quelques boutures à Bovary, se l\'étant fait dicter, épeler et relire, commanda tout de suite aux Bertaux, disant qu\'il ne manquerait pas de raconter sa guérison à tous les jours, à méditer des changements dans sa tête à la Vaubyessard, et dont les roues tournaient dans la boutique. Elle entendait le bruit des dominos le contrariait; M. Homais vous en donnerai!... Vous m\'ennuyez! -- Hélas! répliqua-t-il, les hommes n\'ont point de vue depuis longtemps. De temps à autre, elle sortait.', '2026-04-26 18:54:36', 'privateEvent', 'http://www.rousseau.fr/', '2019-10-26 13:13:30', 200),
(20, 'Par file à gauche! Et, après, un nécessaire d\'ivoire, avec un air de suffisance bénigne, les.', 'Les oreilles du pharmacien lui tintèrent à croire que la bonne apportait une botte de paille et le haut de taille qu\'aucun de nous tous. Il avait couru le monde: il parlait de temps en temps, dans la fumée des cigares à la publicité... Mais l\'apothicaire s\'arrêta, tant madame Lefrançois et la baisa longuement à la tombée du jour, en pleine campagne, au moment où le fer, le bois, la tôle, le cuir, les vis et les bras croisés: -- Mais dépêchez-vous, mère Rolet! Et elle lui parlait des choses si exorbitantes, qu\'elle n\'y pouvait croire. Alors elle se mit en route pour les groupes d\'hommes causant debout et les planches les éperons vermeils de ses feuilles. Elle avait tout autour et au-dessus, comme le nôtre devrait s\'avouer à la ville, une fois qu\'elle se rétablissait. D\'abord, elle trouva des objections. Un jour, Emma fut surprise de se commander une andouille. Outre la cravache à pommeau de vermeil, Rodolphe avait reçu la lettre avec des palpitations qui la traversait. Alors les encombrements du plaisir, enseignait la vertu. -- _Castigat ridendo mores_, monsieur Bournisien! Ainsi, regardez la plupart des gens accoudés à toutes les larmes qui coulaient lentement sur l\'oreiller.', '2023-10-04 04:35:00', 'members', 'https://perret.fr/fugiat-consectetur-laborum-et-rem-qui-natus-culpa-ea.html', '2019-10-26 13:13:00', 200);

-- --------------------------------------------------------

--
-- Structure de la table `img`
--

DROP TABLE IF EXISTS `img`;
CREATE TABLE IF NOT EXISTS `img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uploaded_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `img`
--

INSERT INTO `img` (`id`, `name`, `uploaded_at`) VALUES
(1, 'img_0826-5db968dccba7a.jpeg', '2019-10-30 10:41:32'),
(2, 'img_0826-5db972d5a8c65.jpeg', '2019-10-30 11:24:05'),
(3, 'img_0813-1850529.jpeg', '2019-10-30 18:24:10'),
(5, 'img_0822-2693190.jpeg', '2019-10-31 17:42:28'),
(6, 'img_0733-1867359.jpeg', '2019-10-31 17:46:58'),
(7, 'img_3325-2450660.jpeg', '2019-11-06 09:27:51'),
(8, 'img_3312-2520024.jpeg', '2019-11-07 14:31:48'),
(9, 'img_3324-2384102.jpeg', '2019-11-07 14:32:06');

-- --------------------------------------------------------

--
-- Structure de la table `img_article`
--

DROP TABLE IF EXISTS `img_article`;
CREATE TABLE IF NOT EXISTS `img_article` (
  `img_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`img_id`,`article_id`),
  KEY `IDX_4F554A8EC06A9F55` (`img_id`),
  KEY `IDX_4F554A8E7294869C` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `img_article`
--

INSERT INTO `img_article` (`img_id`, `article_id`) VALUES
(1, 15),
(2, 12),
(3, 13),
(5, 17),
(6, 11),
(7, 15),
(8, 16),
(9, 16);

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20191008103217', '2019-10-08 10:35:55'),
('20191008160527', '2019-10-08 16:07:36'),
('20191008162701', '2019-10-08 16:27:16'),
('20191021105439', '2019-10-21 10:57:29'),
('20191022134331', '2019-10-22 13:45:03'),
('20191023180910', '2019-10-23 18:11:54'),
('20191023181659', '2019-10-23 18:17:29'),
('20191029091221', '2019-10-29 09:13:19'),
('20191029101604', '2019-10-29 10:16:34'),
('20191029203119', '2019-10-29 20:31:33');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_log` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `roles` json NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E95126AC48` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `mail`, `password`, `last_log`, `created_at`, `roles`, `name`, `surname`) VALUES
(161, 'kdossantos@raynaud.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Dos Santos', 'Aimée'),
(162, 'yves49@dbmail.com', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Charpentier', 'Dominique'),
(163, 'christiane38@gros.com', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Prevost', 'Dominique'),
(164, 'robert.bonnin@tele2.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Joly', 'Sabine'),
(165, 'antoine71@couturier.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-28 11:43:39', '2019-10-26 13:13:30', '[\"ROLE_ADMIN\"]', 'Baudry', 'Thierry'),
(166, 'tristan85@navarro.com', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Durand', 'Laure'),
(167, 'xbertrand@club-internet.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Bailly', 'Emmanuelle'),
(168, 'mmercier@chartier.com', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Benard', 'Henri'),
(169, 'obazin@marques.net', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Renault', 'Bernard'),
(170, 'nicole.wagner@raynaud.org', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Gay', 'Michelle'),
(171, 'collin.thibaut@royer.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Baudry', 'Michel'),
(172, 'julie.bertrand@leconte.org', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Duval', 'Julie'),
(173, 'thomas07@moulin.org', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Carpentier', 'Brigitte'),
(174, 'procher@arnaud.com', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Delaunay', 'Roland'),
(175, 'chantal71@orange.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Leleu', 'Adèle'),
(176, 'meyer.raymond@alves.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Fernandez', 'Benjamin'),
(177, 'adrienne.riviere@jacob.org', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Lebrun', 'Édouard'),
(178, 'edouard.mahe@olivier.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Dupre', 'Victor'),
(179, 'gvasseur@tele2.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Didier', 'Julie'),
(180, 'marie46@lecomte.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Rodriguez', 'Pierre'),
(181, 'susanne.coste@orange.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Pires', 'Hugues'),
(182, 'marie.lenoir@club-internet.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Thibault', 'Hugues'),
(183, 'helene.blanchard@dbmail.com', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Parent', 'Olivie'),
(184, 'sjean@ifrance.com', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Brunel', 'Bernard'),
(185, 'joseph96@hotmail.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Gillet', 'Stéphane'),
(186, 'bernier.auguste@laposte.net', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Lemaire', 'Célina'),
(187, 'ymarion@voila.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Besson', 'Nathalie'),
(188, 'claire81@benoit.org', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Gregoire', 'Sophie'),
(189, 'guillaume05@lemonnier.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:00', '2019-10-26 13:13:00', '[\"ROLE_MEMBER\"]', 'Guichard', 'Martin'),
(191, 'maurice.dupont@noos.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Lamy', 'Vincent'),
(192, 'louis67@tele2.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Garcia', 'Laurent'),
(193, 'timothee43@maillet.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Fouquet', 'Patrick'),
(194, 'bousquet.emile@hotmail.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Payet', 'Luc'),
(195, 'michelle15@yahoo.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Humbert', 'Marguerite'),
(196, 'patrick64@weber.com', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Lemaire', 'Andrée'),
(197, 'richard28@sfr.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Roux', 'Rémy'),
(198, 'michel46@barre.com', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Dubois', 'Julien'),
(199, 'christophe.lacroix@bouygtel.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Bouvier', 'Maurice'),
(200, 'lebreton.eugene@voila.fr', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-10-26 13:13:30', '2019-10-26 13:13:30', '[\"ROLE_MEMBER\"]', 'Bruneau', 'Frédéric'),
(201, 'antoine@smagghe.me', '$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2', '2019-11-26 23:38:14', '2019-10-29 00:00:00', '[\"ROLE_ADMIN\"]', 'Smagghe', 'Antoine');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E66A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `img_article`
--
ALTER TABLE `img_article`
  ADD CONSTRAINT `FK_4F554A8E7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_4F554A8EC06A9F55` FOREIGN KEY (`img_id`) REFERENCES `img` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
