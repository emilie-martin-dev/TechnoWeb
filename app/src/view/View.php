<?php

require_once("model/Activite.php");
require_once("model/builder/BuilderActivite.php");
require_once("Router.php");

class View {
    protected $title;
    protected $content;

    protected $router;

    public function __construct(Router $router) {
        $this->router = $router;
    }

    public function makeActivitePage(Activite $activite) {
        $this->title = $activite->getNom();
        $this->content = $activite->getLieu();

        include_once("template/activite/consulter.php");
    }

    public function makeListPage($activites) {
        include_once("template/activite/lister.php");
    }

    public function makeErrorPage() {
        $this->title = "Error";
        $this->content = "Error";

        include_once("template/activite/consulter.php");
    }

    public function makeActiviteCreationPage($builder, $update=false) {
        $this->title = "Création d'une activité";

        $nomFieldValue = htmlspecialchars($builder->getAttribute(BuilderActivite::FIELD_NOM), ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
        $lieuFieldValue = htmlspecialchars($builder->getAttribute(BuilderActivite::FIELD_LIEU), ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
        $shortDescriptionFieldValue = htmlspecialchars($builder->getAttribute(BuilderActivite::FIELD_SHORT_DESCRIPTION), ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
        $descriptionFieldValue = htmlspecialchars($builder->getAttribute(BuilderActivite::FIELD_DESCRIPTION), ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
        $errors = $builder->getError();

        $errorDiv = "";
        if(count($errors) > 0) {
            $errorDiv .= "<div><ul>";
            foreach($errors as $e) {
                $errorDiv .= "<li>" . $e . "</li>";
            }
            $errorDiv .= "</ul></div>";
        }

        $urlAction = $update ? $this->router->getActiviteModifURL($builder->getAttribute(BuilderActivite::FIELD_ID)) : $this->router->getActiviteCreationURL();

        include_once("template/activite/form.php");
    }

    public function makeDeleteActivite($id) {
        $urlAction = $this->router->getActiviteSupprimerURL($id);

        include_once("template/activite/delete.php");
    }
}