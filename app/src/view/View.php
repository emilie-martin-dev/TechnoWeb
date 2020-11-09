<?php

require_once("model/Activite.php");
require_once("Router.php");

class View {
    protected $title;
    protected $content;

    protected Router $router;

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
}