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
        include_once("template/error/error404.php");
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
    
    public function getMenu(){
        $menuDiv = "<nav>";
        $menuDiv .= "<ul>";
        
        $menuDiv .= "<li><a href='" . $this->router->getActiviteListURL() . "'>Activités</a></li>";
        $menuDiv .= "<li><a href='" . $this->router->getAboutURL() . "'>A propos</a></li>";

        $auth = new AuthenticationManager();
        if($auth->isConnected()) {
            $menuDiv .= "<li><a href='" . $this->router->getActiviteCreationURL() . "'>Ajouter une activité</a></li>";

            if($auth->isAdmin()) {                
                $menuDiv .= "<li><a href='" . $this->router->getConfigAdminURL() . "'>Configuration</a></li>";
            }
            
            $menuDiv .= "<li><a href='" . $this->router->getLogoutURL() . "'>Déconnexion</a></li>";
        } else {            
            $menuDiv .= "<li><a href='" . $this->router->getLoginURL() . "'>Connexion</a></li>";
            $menuDiv .= "<li><a href='" . $this->router->getSignUpURL() . "'>Inscription</a></li>";
        }        

        $menuDiv .= "</ul>";
        $menuDiv .= "</nav>";

        return $menuDiv;
    }

    public function getImagePath($imagePath) {
        if($imagePath == null || $imagePath != null && empty($imagePath)) 
            return "/img/placeholder.png";
        else
            return UPLOAD_PATH . $imagePath;
    }


    public function makeAboutPage() {
        $title = "A propos";

        include_once("template/about/about.php");
    }

    public function makeActivitePage(Activite $activite, $imgSrc, $comments, BuilderComment $builder, $isActiviteOwner) {
        $title = $this->escapeHtmlSpecialChars($activite->getNom());
        $lieu = $this->escapeHtmlSpecialChars($activite->getLieu());
        $desc = $this->escapeHtmlSpecialChars($activite->getDescription());
        $shortDesc = $this->escapeHtmlSpecialChars($activite->getShortDescription());

        $img = "<img src=\"" . $this->getImagePath($imgSrc) . "\" class=\"w12\"/>";
        $urlAction = $this->router->getAddCommentUrl($builder->getAttribute(BuilderComment::FIELD_ID_ACTIVITE));

        $commentairesDiv = "";
        foreach($comments as $c) {
            $nomUtilisateur = $this->escapeHtmlSpecialChars($c->getUtilisateur()->getNom());
            $prenomUtilisateur = $this->escapeHtmlSpecialChars($c->getUtilisateur()->getPrenom());
            $texte = $this->escapeHtmlSpecialChars($c->getTexte());
            $commentairesDiv .= "<div class=\"comment\"><p>".$nomUtilisateur." ".$prenomUtilisateur." :</p><p>".$texte."</p></div><hr/>";
        }
        
        $actions = "<div id=\"actions\">";
        if($isActiviteOwner) {
            $actions .= "<p><a href=" . $this->router->getActiviteUploadPictureURL($activite->getId()) . ">Upload</a></p>";
            $actions .= "<p><a href=" . $this->router->getActiviteModifURL($activite->getId()) . ">Modifier</a></p>";
            $actions .= "<p><a href=" . $this->router->getActiviteSupprimerURL($activite->getId()) . ">Supprimer</a></p>";
        }
        $actions .= "</div>";

        include_once("template/activite/consulter.php");
    }

    public function makeListActivitePage($activites, $imgsSrc) {
        $title = "Liste des activités";

        $listeActivitesDiv = "";
        $i = 0;
        foreach($activites as $a) {
            $idActivites = $this->escapeHtmlSpecialChars($a->getId());
            $nomActivites = $this->escapeHtmlSpecialChars($a->getNom());
            $lieuActivites = $this->escapeHtmlSpecialChars($a->getLieu());
            $shortDescriptionActivites = $this->escapeHtmlSpecialChars($a->getShortDescription());
            
            $listeActivitesDiv .= "
                    <div class=\"row\">
                        <div class=\"col w4\">
                            <img src=\"" . $this->getImagePath($imgsSrc[$i]) . "\" class=\"w12 photo\"/>
                        </div>

                        <div class=\"col w7\">
                            <p><a href=" . $this->router->getActiviteUrl($a->getId()) . ">" . $this->escapeHtmlSpecialChars($a->getNom()) . " - " . $this->escapeHtmlSpecialChars($a->getLieu()) ."</a></p>
                            <p>". $this->escapeHtmlSpecialChars($a->getShortDescription()) ."</p>
                        </div>
                    </div>
                    <hr/>";
            $i++;
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

    public function makeConfigAdminFormPage(BuilderConfig $builder){
        $title = "Configuration";
        $urlAction = $this->router->getUpdateConfigURL($builder->getAttribute(BuilderConfig::FIELD_ID));

        $libelleFieldValue = $this->escapeHtmlSpecialChars($builder->getAttribute(BuilderConfig::FIELD_LIBELLE));
        $valeurFieldValue = $this->escapeHtmlSpecialChars($builder->getAttribute(BuilderConfig::FIELD_VALEUR));

        $errorDiv = $this->generateErrorDiv($builder->getError());

        include_once("template/config/config.php");
    }

    public function makeSignUpFormPage(BuilderUtilisateur $builder) {
        $title = "Inscription";
        $urlAction = $this->router->getSignUpURL();
        $errorDiv = $this->generateErrorDiv($builder->getError());

        include_once("template/sign_up/sign_up.php");
    }

}
