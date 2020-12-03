<?php

require_once("model/Activite.php");
require_once("model/Comment.php");
require_once("model/builder/BuilderActivite.php");
require_once("model/builder/BuilderUtilisateur.php");
require_once("model/builder/BuilderLogin.php");
require_once("Router.php");

class View {

    protected $router;
    protected $feedback;

    public function __construct($feedback="") {
        $this->router = Router::getInstance();
        $this->feedback = $feedback;
    }

    public function escapeHtmlSpecialChars($str) {
        return htmlspecialchars($str, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
    }

    public function make404Page() {
        $title = "Error";
        $content = "Error";

        include_once("template/activite/consulter.php");
    }

    public function generateErrorDiv($errors)  {
        $errorDiv = "";
        if($errors != null && count($errors) > 0) {
            $errorDiv .= "<div class=\"error-block\"><ul>";
            foreach($errors as $e) {
                $errorDiv .= "<li>" . $e . "</li>";
            }
            $errorDiv .= "</ul></div>";
        }

        return $errorDiv;
    }

    public function generateFeedbackDiv() {
        $feedbackDiv = "";

        if(!empty($this->feedback)) {
            $feedbackDiv .= "<div class=\"feedback\">";
            $feedbackDiv .= "<p>" . $this->feedback . "</p>";
            $feedbackDiv .= "</div>";
        }

        return $feedbackDiv;
    }


    public function makeAboutPage() {
        $title = "A propos";

        include_once("template/about/about.php");
    }

    public function makeActivitePage(Activite $activite, $imgSrc, $comment, BuilderComment $builder) {
        $title = $activite->getNom();
        $lieu = $activite->getLieu();
        $desc = $activite->getDescription();
        $shortDesc = $activite->getShortDescription();

        $img = empty($imgSrc) ? "" : "<img src=\"" . UPLOAD_PATH . $imgSrc . "\" class=\"w12\"/>";
        $urlAction = $this->router->getAddCommentUrl($builder->getAttribute(BuilderComment::FIELD_ID_ACTIVITE));

        $commentaire = "";

        if($comment != null) {
            foreach($comment as $c) {
                $nomUtilisateur = $c->getUtilisateur()->getNom();
                $prenomUtilisateur = $c->getUtilisateur()->getPrenom();
                $texte = $c->getTexte();
                $commentaire .= "<p>".$nomUtilisateur." ".$prenomUtilisateur." a écrit:</p><br><p>".$texte."</p><br><hr/>";
            }
        }

        include_once("template/activite/consulter.php");
    }

    public function makeListActivitePage($activites) {
        $title = "Liste des activités";

        $listeActivites = "";
        if($activites != null) {
            foreach($activites as $a) {
                $idActivites = $a->getId();
                $nomActivites = $a->getNom();
                $lieuActivites = $a->getLieu();
                $shortDescriptionActivites = $a->getShortDescription();
                $listeActivites .= "<p><a href='".$this->router->getActiviteUrl($idActivites)."'>".$nomActivites."</a> - ".$lieuActivites.": ".$shortDescriptionActivites."</p><hr/>";
            }
        }

        include_once("template/activite/lister.php");
    }

    public function makeActiviteFormPage(BuilderActivite $builder, $update=false) {
        $title = $update ? "Edition d'une activité" : "Création d'une activité";
        $urlAction = $update ? $this->router->getActiviteModifURL($builder->getAttribute(BuilderActivite::FIELD_ID)) : $this->router->getActiviteCreationURL();

        $nomFieldValue = $this->escapeHtmlSpecialChars($builder->getAttribute(BuilderActivite::FIELD_NOM));
        $lieuFieldValue = $this->escapeHtmlSpecialChars($builder->getAttribute(BuilderActivite::FIELD_LIEU));
        $shortDescriptionFieldValue = $this->escapeHtmlSpecialChars($builder->getAttribute(BuilderActivite::FIELD_SHORT_DESCRIPTION));
        $descriptionFieldValue = $this->escapeHtmlSpecialChars($builder->getAttribute(BuilderActivite::FIELD_DESCRIPTION));
        $errorDiv = $this->generateErrorDiv($builder->getError());

        include_once("template/activite/form.php");
    }

    public function makeUploadPictureActivite($id) {
        $title = "Upload d'une image";
        $urlAction = $this->router->getActiviteUploadPictureURL($id);

        include_once("template/activite/upload_picture.php");
    }

    public function makeDeleteActivitePage($id) {
        $urlAction = $this->router->getActiviteSupprimerURL($id);
        $title = "Confirmation de suppression";

        include_once("template/activite/delete.php");
    }

    public function makeLoginFormPage(BuilderLogin $builder) {
        $title = "Connexion";
        $urlAction = $this->router->getLoginUrl();

        $loginFieldValue = $this->escapeHtmlSpecialChars($builder->getAttribute(BuilderUtilisateur::FIELD_LOGIN));
        $errorDiv = $this->generateErrorDiv($builder->getError());

        include_once("template/login/login.php");
    }

}
