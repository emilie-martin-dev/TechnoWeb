<?php

require_once("controller/Controller.php");
require_once("view/View.php");
require_once("storage/bdd/BDDActiviteStorage.php");

class Router {

    const SESSION_LAST_URL = "lastUrl";
    const SESSION_FORM = "form";
    const SESSION_FEEDBACK = "feedback";

    private static $instance = null;

    private function __construct() {
    }

    public static function getInstance() {
        if(Router::$instance == null) {
            Router::$instance = new Router();  
        }

        return Router::$instance;
    }

    public function main() {
        session_name("ActivNormandie");
        session_start();

        if(isset($_SESSION[Router::SESSION_LAST_URL]) && $_SESSION[Router::SESSION_LAST_URL] != $_SERVER["PATH_INFO"]) {
            unset($_SESSION[Router::SESSION_FORM]);
        }

        $_SESSION[Router::SESSION_LAST_URL] = $_SERVER["PATH_INFO"];

        $feedback = isset($_SESSION[Router::SESSION_FEEDBACK]) ? $_SESSION[Router::SESSION_FEEDBACK] : null;
        unset($_SESSION[Router::SESSION_FEEDBACK]);

        $ctrl = new Controller(new View($feedback));

        $urls = [
            "GET:/activite" => array("showList", array(), array()),
            "GET:/activite/[0-9]+" => array("showInformation", array("1"), array()),
            "GET:/activite/[0-9]+/add" => array("showAddActivite", array(), array()),
            "POST:/activite/[0-9]+/add" => array("saveNewActivite", array($_POST), array()),
            "GET:/activite/[0-9]+/delete" => array("showDeleteActivite", array("1"), array()),
            "POST:/activite/[0-9]+/delete" => array("deleteActivite", array("1"), array()),
            "GET:/activite/[0-9]+/update" => array("showUpdateActivite", array("1"), array()),
            "POST:/activite/[0-9]+/update" => array("modifActivite", array("1", $_POST), array()),
            "GET:/login" => array("showLogin", array(), array()),
            "GET:/logout" => array("logout", array(), array()),
            "POST:/login" => array("login", array($_POST), array()),
            "GET:/" => array("showList", array(), array())
        ];

        $currentUrl = $_SERVER["REQUEST_METHOD"] . ":" . $_SERVER["PATH_INFO"];

        $auth = new AuthenticationManager();
        $shown = false;

        foreach($urls as $u => $property) {
            if(preg_match("/^".str_replace("/", "\/", $u)."\/?$/", $currentUrl)) {                
                $methodToCall = $property[0];
                $methodArgs = $property[1];
                $roles = $property[2];

                if(empty($roles) || $auth->isConnected() && in_array($auth->getUser()->getRole()->getLibelle(), $roles)) {
                    $methodArgs = $this->formatArgs($methodArgs, $this->parseUrl());

                    call_user_func(array($ctrl, $methodToCall), ...$methodArgs);
                    $shown = true;
    
                    break;
                }
            }
        }

        if(!$shown) {
            echo "404";
        }
    } 

    private function parseUrl() {
        $urlPath = explode("/", substr($_SERVER["PATH_INFO"], 1));
        if(!empty($urlPath) && empty($urlPath[count($urlPath) - 1]))
            unset($urlPath[count($urlPath) - 1]);

        return $urlPath;
    } 

    private function formatArgs($methodArgs, $urlPath) {
        foreach($methodArgs as $k => $v) {
            if(is_numeric($v)) {
                $methodArgs[$k] = $urlPath[(int) $v];
            }
        }
        
        return $methodArgs;
    }

    public function POSTRedirect($url, $feedback="") {
        $_SESSION[Router::SESSION_FEEDBACK] = $feedback;

        header("Location: " . $url, true, 303);
    }

    public function getFormData() {
        return (isset($_SESSION[Router::SESSION_FORM])) ? $_SESSION[Router::SESSION_FORM] : null;
    }

    public function setFormData($formData) {
        $_SESSION[Router::SESSION_FORM] = $formData;
    }

    public function isUrl($url, $urlRequested) {
        
    }

    public function getIndexURL() {
        return "/";
    }
    
    public function getActiviteListURL() {
        return "/activite";
    }

    public function getActiviteURL($id) {
        return "/activite/" . $id;
    }

    public function getActiviteCreationURL() {
        return "/activite/add";
    }

    public function getActiviteModifURL($id) {
        return "/activite/" . $id . "/update";
    }

    public function getActiviteSupprimerURL($id) {
        return "/activite/" . $id . "/delete";
    }

    public function getLoginURL() {
        return "/login";
    }

    public function getLogoutURL() {
        return "/logout";
    }
}