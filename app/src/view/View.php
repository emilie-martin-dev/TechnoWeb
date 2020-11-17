<?php

require_once("model/Activite.php");
require_once("model/builder/BuilderActivite.php");
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

    public function generateErrorDiv($errors)  {
        $errorDiv = "";
        if($errors != null && count($errors) > 0) {
            $errorDiv .= "<div><ul>";
            foreach($errors as $e) {
                $errorDiv .= "<li>" . $e . "</li>";
            }
            $errorDiv .= "</ul></div>";
        }

        return $errorDiv;
    }

    public function makeActivitePage(Activite $activite) {
        $title = $activite->getNom();
        $content = $activite->getLieu();

        include_once("template/activite/consulter.php");
    }

    public function makeListPage($activites) {
        $title = "Liste des activités";

        include_once("template/activite/lister.php");
    }

    public function makeErrorPage() {
        $title = "Error";
        $content = "Error";

        include_once("template/activite/consulter.php");
    }

    public function makeActiviteCreationPage(BuilderActivite $builder, $update=false) {
        $title = $update ? "Edition d'une activité" : "Création d'une activité";

        $nomFieldValue = $this->escapeHtmlSpecialChars($builder->getAttribute(BuilderActivite::FIELD_NOM));
        $lieuFieldValue = $this->escapeHtmlSpecialChars($builder->getAttribute(BuilderActivite::FIELD_LIEU));
        $shortDescriptionFieldValue = $this->escapeHtmlSpecialChars($builder->getAttribute(BuilderActivite::FIELD_SHORT_DESCRIPTION));
        $descriptionFieldValue = $this->escapeHtmlSpecialChars($builder->getAttribute(BuilderActivite::FIELD_DESCRIPTION));
        $errorDiv = $this->generateErrorDiv($builder->getError());

        $urlAction = $update ? $this->router->getActiviteModifURL($builder->getAttribute(BuilderActivite::FIELD_ID)) : $this->router->getActiviteCreationURL();

        include_once("template/activite/form.php");
    }

    public function makeDeleteActivite($id) {
        $urlAction = $this->router->getActiviteSupprimerURL($id);
        $title = "Confirmation de suppression";

        include_once("template/activite/delete.php");
    }

}