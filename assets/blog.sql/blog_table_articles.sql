
-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `auteur` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime DEFAULT NULL,
  `statut` enum('actif','inactif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

REPLACE INTO `articles` (`id`, `title`, `content`, `auteur`, `created_at`, `update_at`, `statut`) VALUES
(1, 'J\'ai réussi', 'Aujourd\'hui, petit article sur le fait que j\'ai enfin réussi à créer mon formulaire et à l\'envoyer dans ma base de données MySQL. Archi fière que je suis j\'écris donc un article pour faire un petit test sur ce que ça va donner pour les prochaines étapes. Bientôt blogueuse mode attention. Vive la vie ! (pour l\'instant cet article restera en mode privé).', 'Chloé', '2018-03-20 11:59:38', NULL, 'inactif'),
(2, 'Trottirama', 'Trottirama est un contest de trottinette freestyle organisé au skatepark de Nantes. C\'est un événement organisé par une association. Il se déroule au skatepark de Nantes, le 17 et 18 mars 2018. Le premier prix est de 1000€.', 'Thomas', '2018-03-20 15:51:27', NULL, 'actif'),
(3, 'Projet de licence', 'Ceci est un article concernant l\'alcool chez les femmes enceintes. C\'est un sujet pour le projet de licence. Je suis en troisième année de licence sociologie au campus de Mont-Saint-Aignan. Je voulais juste un petit article sympa tout ça tout ça.', 'Anne-Laure', '2018-03-20 16:02:46', NULL, 'inactif'),
(4, 'Shiatsu', 'Le shiatsu est une pratique ancestrale consistant à faire de l\'acupression plutôt que de l\'acupuncture. C\'est la même chose, mais avec les doigts et non des aiguilles. Il s\'agit donc de débloquer les nerfs coincés. Même effet que l\'ostéopathie à peu près.', 'Lydie', '2018-03-20 16:13:10', NULL, 'actif'),
(5, 'Ambiance', 'Petite vue d\'ensemble de l\'ambiance qui règne dans la classe : entre les gens qui se mettent à roter comme si nous étions tous intimes, ceux qui s\'amusent avec les touillettes à café pour faire des pets de grenouille, d\'autres qui s\'en vont comme bon leur semble, la chaleur de la salle qui tape sur les nerfs, la lumière qui s\'éteint automatiquement au bout de 30 minutes... bref rien à redire, il y a tout de même une bonne ambiance dans cette promo.', 'Chloé', '2018-03-20 16:19:29', NULL, 'inactif'),
(6, 'Réussite', 'Aujourd\'hui mercredi 21 mars je suis fière d\'annoncer que j\'ai compris pourquoi php galère avec le css : c\'est parce qu\'il faut changer le nom à chaque fois. En fait je n\'ai pas tellement compris pourquoi mais j\'ai trouvé la solution. Ce qui est déjà bien. Je saurai pourquoi un jour mon foutu php refuse de coopérer avec mon css (à noter sur ma to-do list).', 'Chloé', '2018-03-21 18:12:02', NULL, 'actif'),
(7, 'CSS de merde', 'Je pète actuellement un méga plomb parce que j\'arrive pas à aligner ce putain de bouton \"lire la suite\" à droite du contenu donc je suis énervée donc j\'écris un article pour que ça m\'en fasse un de plus donc ça me fait du contenu en plus SA MERE LA TCHOIN', 'Chloé', '2018-03-21 19:24:32', NULL, 'actif'),
(8, 'Petit test de privé/public', 'Je crée juste un article pour voir si le statut change correctement, bonjour aurevoir', 'Chloé', '2018-03-21 21:24:53', NULL, 'actif'),
(9, 'Hallelujah', 'Putain de sa mère la race je sais absolument pas comment j\'ai fait mais j\'ai réussi à incruster ce putain de get id de merde dans l\'url ce qui vise chaque article individuellement je suis ARCHI heureuse vive la vie vive le web vive le PHP je chante la vie je danse la vie JE CODE LA VIE et j\'écris le maximum de ligne pour bien me rendre compte à quoi va ressemble mon article toulououlou tralalala JE SUIS FATIGUEE et j\'ai pas encore préparé mes affaires voilà mesdames et messieurs je vous souhaite une bonne nuit merci d\'avoir lu jusqu\'ici bye bitches', 'Chloé', '2018-03-21 22:40:56', NULL, 'actif');
