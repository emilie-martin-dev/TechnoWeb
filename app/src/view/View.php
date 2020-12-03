<?php

require_once("model/Activite.php");
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
        $title = "<div class = \"error-block\">Error 404 </div><br>Oups ! Cette page ne vous est pas autorisé !<br>";

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

    public function makeActivitePage(Activite $activite, $imgSrc) {
        $title = $activite->getNom();
        $lieu = $activite->getLieu();
        $desc = $activite->getDescription();
        $shortDesc = $activite->getShortDescription();

        $img = empty($imgSrc) ? "" : "<img src=\"" . UPLOAD_PATH . $imgSrc . "\" class=\"w12\"/>";

        include_once("template/activite/consulter.php");
    }

    public function makeListActivitePage($activites) {
        $title = "Liste des activités";

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

        $libelleFieldValue = $builder->getAttribute(BuilderConfig::FIELD_LIBELLE);
        $valeurFieldValue = $builder->getAttribute(BuilderConfig::FIELD_VALEUR);

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
