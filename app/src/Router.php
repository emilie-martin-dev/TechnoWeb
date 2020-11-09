<?php

require_once("controller/Controller.php");
require_once("view/View.php");
require_once("storage/stub/StubActiviteStorage.php");

class Router {

    public function main() {
        $urlPath = explode("/", substr($_SERVER['PATH_INFO'], 1));

        if($urlPath[0] == "activite") {
            $ctrl = new Controller(new View($this), new StubActiviteStorage());
            if(isset($urlPath[1]))
                $ctrl->showInformation($urlPath[1]);
            else 
                $ctrl->showList();
        } else {
            echo "404";
        }
    } 

    public function getActiviteURL($id) {
        return "/activite/" . $id;
    }

}