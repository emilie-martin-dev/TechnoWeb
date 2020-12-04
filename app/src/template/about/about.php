<?php
    include("template/base/header_html.php");
?>

<h1>A propos<h1>

<h2>Membres du groupe</h2>

<p>Numéro de groupe : 17</p> 

<div class="w10 center">
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Num étudiant</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>BISSOMBOLO</td>
                <td>Siega</td>
                <td>21814220</td>
            </tr>

            <tr>
                <td>DEROUIN</td>
                <td>Auréline</td>
                <td>21806986</td>
            </tr>

            <tr>
                <td>FLAMBARD</td>
                <td>Théo</td>
                <td>21708078</td>
            </tr>

            <tr>
                <td>MARTIN</td>
                <td>Justine</td>
                <td>21909920</td>
            </tr>
        </tbody>
    </table>
</div>

<h2>Liste des points réalisés</h2>

<p>Tous les points demandés ont été réalisés.</p>

<p>Voici la liste des compléments que nous avons effectué : </p>

<ul>
    <li>Un objet peut être illustré par zéro, une ou plusieurs images (modifiables) uploadées par le créateur de l'objet</li>
    <li>Fonctionnalité rester connecté, avec une durée de validité (plusieurs jours par exemple) paramétrable par l'administrateur du site</li>
    <li>Commentaires sur un objet</li>
</ul>

<h2>Répartition des tâches dans le groupe</h2>

<div class="w10 center">
    <table>
        <thead>
            <tr>
                <th>Libellé</th>
                <th>BISSOMBOLO Siega</th>
                <th>DEROUIN Auréline</th>
                <th>FLAMBARD Théo</th>
                <th>MARTIN Justine</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Présence aux réunions</td>
                <td></td>
                <td>X</td>
                <td>Retard</td>
                <td>X</td>
            </tr>

            <tr>
                <td>Mise en commun du code des TP 12 à 16</td>
                <td></td>
                <td>X</td>
                <td>X</td>
                <td>X</td>
            </tr>

            <tr>
                <td>Une seule connexion à la BDD</td>
                <td></td>
                <td></td>
                <td></td>
                <td>X</td>
            </tr>

            <tr>
                <td>Factory pour la création des IStorage en "Stub" ou "BDD"</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Meilleure gestions des urls (suppression du bloc de if)</td>
                <td></td>
                <td></td>
                <td></td>
                <td>X</td>
            </tr>

            <tr>
                <td>Système de vérification du role utilisateur avant d'accéder à une page</td>
                <td></td>
                <td></td>
                <td></td>
                <td>X</td>
            </tr>

            <tr>
                <td>Redirection d'une page en POST vers GET</td>
                <td></td>
                <td></td>
                <td>*</td>
                <td>X</td>
            </tr>

            <tr>
                <td>Possibilité de se connecter au site</td>
                <td></td>
                <td></td>
                <td></td>
                <td>X</td>
            </tr>

            <tr>
                <td>Gestion de la durée de validité d'un cookie en tant qu'admin</td>
                <td></td>
                <td>X</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Rester connecté selon la durée du cookie</td>
                <td></td>
                <td>X</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Possibilté de s'inscrire sur le site</td>
                <td></td>
                <td>X</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Ajout d'une activité en fonction de l'utilisateur connecté</td>
                <td></td>
                <td></td>
                <td></td>
                <td>X</td>
            </tr>

            <tr>
                <td>Modification ou suppression d'une activité seulement si l'utilisateur connecté en est l'auteur ou est admin</td>
                <td></td>
                <td></td>
                <td></td>
                <td>X</td>
            </tr>

            <tr>
                <td>Possibilité de supprimer une activité</td>
                <td></td>
                <td></td>
                <td></td>
                <td>X</td>
            </tr>

            <tr>
                <td>Possibilité d'ajouter et de modifier des photos pour une activité</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Ajout de commentaire sur une activité</td>
                <td></td>
                <td>X</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Système de "template" réutilisable</td>
                <td></td>
                <td></td>
                <td></td>
                <td>X</td>
            </tr>

            <tr>
                <td>Conception du CSS</td>
                <td></td>
                <td></td>
                <td></td>
                <td>X</td>
            </tr>

            <tr>
                <td>Design du template de base (header, menu, footer, ...)</td>
                <td></td>
                <td></td>
                <td>Menu *</td>
                <td></td>
            </tr>

            <tr>
                <td>Afficher le message de feedback</td>
                <td></td>
                <td></td>
                <td>*</td>
                <td>X</td>
            </tr>

            <tr>
                <td>Afficher les erreurs du formulaire</td>
                <td></td>
                <td></td>
                <td></td>
                <td>X</td>
            </tr>

            <tr>
                <td>Design de la page de listing des activités</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Design de la page 404</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Design de la page d'accueil</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Design de la page de consultation d'une activité</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Design de la page de formulaire des activités</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Design de la page de login</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Design de la page d'inscription</td>
                <td></td>
                <td>X</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Design de la page de configuration du cookie</td>
                <td></td>
                <td>X</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Design de la page à propos</td>
                <td></td>
                <td></td>
                <td></td>
                <td>X</td>
            </tr>
        </tbody>
    </table>
</div>

<p>* fait dans ses TP mais pas adaptable simplement au code du projet repris ou nécessitant des améliorations importantes. Une réécriture était nécessaire.</p>

<p>NB : Certaines tâches comme le listing ou l'ajout d'une activité ne sont pas présentes car tous les membres qui ont rendus leur code pour la mise en commun l'avaient fait.</p>

<p>NB 2 : Les taches de design concernent la création ou la remise au propre des pages pour rendre le site agréable visuellement.</p>

<h2>Choix de design et de code</h2>



<h2>Points à signaler</h2>

<h3>Communication et travail au seins du groupe</h3>

<h4>Discord</h4>

<p>Pour permettre une communication au seins du groupe efficace, nous avons décidé d'utiliser Discord. Cela nous a permis de faire des réunions à l'oral, des partages d'écran ainsi que de se tenir informer de l'avancé du projet par différents salons textuels. Plusieurs rappels incitant au travail y ont d'ailleurs été fait.</p>

<img class="col w3 center" src="/img/about/discord.png"/>

<p>Voici une courte explication pour les différents salons textuels</p>
<ul>
    <li>infos-dm-techno-web : Liste les liens et informations importantes (Lien Trello, GitHub, numéro de groupe)</li>
    <li>news-dm-techno-web : Donne les dernières informations concernant le dépot GitHub (push, commit, pull request, ...)</li>
    <li>important-dm-techno-web : Les informations à ne pas louper concernant l'avancement du projet, les nouvelles fonctionnalités, le code, les réunions, etc</li>
    <li>dev-dm-techno-web : Salon plus général qui permet de demander de l'aide, discuter de certaines proposition (date de réunions par exemple) avant qu'elles se retrouvent poster dans le salon "important-dm-techno-web"</li>
</ul>

<h4>Trello</h4>

<p>Nous avons également décidé d'utiliser Trello, ce qui nous a permis d'avoir une vue d'ensemble des différentes taches à effectuer. Chacun pouvait prendre une tache et la réaliser de son côté sans aucun problème. Bien entendu, en cas de difficulté, les salons Discord étaient là pour aider.</p>

<img class="col w10 center"  src="/img/about/trello.png"/>

<?php
    include("template/base/footer_html.php");
?>