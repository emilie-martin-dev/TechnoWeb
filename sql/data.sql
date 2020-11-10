INSERT INTO CONFIG VALUES(NULL, "COOKIE_LOGIN_TIMEOUT", "2592000");

INSERT INTO ROLE VALUES(NULL, "ADMIN");
INSERT INTO ROLE VALUES(NULL, "USER");

INSERT INTO UTILISATEUR VALUES(NULL, "Vanier", "Pascal", "vanier", "$2y$10$NaEOQXtS6wZqm.zblKtO0OLZlro59zQ/MxnU5BsccE2.NCNJCSi26", 2);
INSERT INTO UTILISATEUR VALUES(NULL, "Lecarpentier", "Jean-Marc", "lecarpentier", "$2y$10$NaEOQXtS6wZqm.zblKtO0OLZlro59zQ/MxnU5BsccE2.NCNJCSi26", 2);
INSERT INTO UTILISATEUR VALUES(NULL, "admin", "root", "admin", "$2y$10$NaEOQXtS6wZqm.zblKtO0OLZlro59zQ/MxnU5BsccE2.NCNJCSi26", 1);

INSERT INTO ACTIVITE
VALUES(NULL, 'Mont Saint Michel', 'Mont Saint Michel', 
    "Le Mont-Saint-Michel est une commune française située dans le département de la Manche en Normandie. Elle tire son nom de l'îlot rocheux consacré à saint Michel où s'élève aujourd'hui l'abbaye du
Mont-Saint-Michel.", 
    "Le Mont-Saint-Michel est une commune française située dans le département de la Manche en Normandie. Elle tire son nom de l'îlot rocheux consacré à saint Michel où s’élève aujourd’hui l’abbaye du Mont-Saint-Michel.
    \n\nL’architecture du Mont-Saint-Michel et sa baie en font le site touristique le plus fréquenté de Normandie et l'un des dix plus fréquentés en France— premier site après ceux d'Île-de-France — avec près de deux 
    millions et demi de visiteurs chaque année (3 250 000 en 2006, 2 300 000 en 2014).\n\nUne statue de saint Michel placée au sommet de l’église abbatiale culmine à 157,10 mètres au-dessus du rivage. 
    Élément majeur, l'abbaye et ses dépendances sont classées au titre des monuments historiques par la liste de 1862 (60 autres constructions étant protégées par la suite) ; l'îlot et le cordon littoral de la baie 
    figurent depuis 1979 sur la liste du patrimoine mondial de l’UNESCO ainsi que le moulin de Moidrey depuis 2007. Par ailleurs le mont bénéficie d'une seconde reconnaissance mondiale en tant qu'étape des Chemins de 
    Saint-Jacques-de-Compostelle en France pour « les pèlerins du Nord de l'Europe (qui) passaient par le Mont lorsqu'ils se rendaient en Galice ». \n\nEn 2017, la commune comptait 30 habitants, appelés les Montois. 
    L'îlot du mont Saint-Michel est devenu au fil du temps un élément emblématique du patrimoine français.", 1);

INSERT INTO ACTIVITE
VALUES(NULL, 'Le Scriptorial', 'Avranches', 
    "Le Scriptorial est le musée des manuscrits du Mont Saint-Michel, installé à Avranches (Manche).", 
    "Ouvert en août 2006, le Scriptorial est situé à l'abri des remparts de la ville d'Avranches. Son objectif est de valoriser et faire découvrir l'exceptionnelle collection des manuscrits de l'ancienne abbaye du Mont-Saint-Michel. 
    L'architecture du bâtiment s'inspire de celle du Mont-Saint-Michel ; les rampes douces menant à la salle du trésor rappellent celles du célèbre Mont.\n\nLe musée replace les manuscrits médiévaux dans leur contexte historique 
    et local grâce à un parcours chronologique et thématique qui mène à la découverte des œuvres originales. Il permet la découverte des différentes phases de réalisation des manuscrits, la calligraphie, l'enluminure ; il aborde 
    le contenu des textes anciens, puis évoque l'évolution vers l'imprimerie et la bibliothèque du fonds ancien et de ses 14 000 ouvrages.\n\n Le Scriptorial est un musée moderne dédié à l'écriture et aux livres, dessiné par 
    les architectes Emmanuel Berjot, Daniel Cléris et Jean-Michel Daubourg, la scénographie est de Nathalie Chauvier et Nicolas Béquart de l'agence les crayons. Grâce aux outils informatiques, la visite est interactive : bornes 
    multimédia, livres électroniques, projections vidéo. Il propose également des expositions temporaires, des ateliers pédagogiques ainsi que des cycles de conférences. ", 1);

INSERT INTO ACTIVITE
VALUES(NULL, 'Château de Gratot', 'Gratot', 
    "Le château de Gratot est à l'origine une maison forte, dont les vestiges subsistants datent de la fin du XIIIe début du XIVe siècle. Maintes fois remanié, le château présente aujourd'hui une architecture qui s'étage du XIVe au XVIIIe 
    siècle. Il se dresse sur la commune de Gratot dans le département de la Manche en région Normandie.", 
    "Bâti dès le XIIIe siècle, il est maintes fois transformé jusqu'à son apogée au XVIIIe siècle, avant d'être laissé à l'abandon au XIXe siècle, et de devenir aujourd'hui un lieu touristique.\n\n Le château a fait l'objet d'un classement
     partiel au titre des Monuments historiques par arrêté du 4 août 1970. Seuls les ruines, les façades et toitures des communs avec la poterne d'entrée ainsi que les douves sont classés. Le château de Gratot est situé dans le département 
     français de la Manche sur la commune de Gratot. ", 2);

INSERT INTO COMMENTAIRE VALUES(NULL, "Super lieu! Je recommande chaudement la traversée avec un guide!", 1, 1);
INSERT INTO COMMENTAIRE VALUES(NULL, "Le cadre est magnifique!", 1, 2);
INSERT INTO COMMENTAIRE VALUES(NULL, "Une visite très intéressant bien que courte.", 1, 2);
