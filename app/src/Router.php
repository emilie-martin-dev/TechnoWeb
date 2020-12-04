<?php

require_once("auth/AuthenticationManager.php");
require_once("controller/Controller.php");
require_once("view/View.php");
require_once("storage/bdd/BDDActiviteStorage.php");

class Router {

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

        $pathInfo = $this->getCurrentURL();

        if(isset($_SESSION[SESSION_LAST_URL]) && $_SESSION[SESSION_LAST_URL] != $pathInfo) {
            unset($_SESSION[SESSION_FORM]);
        }

        $_SESSION[SESSION_LAST_URL] = $pathInfo;

        $urls = [
            "GET:/" => array("listActivites", array(), array()),
            "GET:/about" => array("about", array(), array()),
            "GET:/activite" => array("listActivites", array(), array()),
            "GET:/activite/[0-9]+" => array("showActivite", array("1"), array(ROLE_USER, ROLE_ADMIN)),
            "POST:/activite/[0-9]+/addComment" => array("addComment", array("1", $_POST), array(ROLE_USER, ROLE_ADMIN)),
            "GET:/activite/add" => array("showAddActivite", array(), array(ROLE_USER, ROLE_ADMIN)),
            "POST:/activite/add" => array("addActivite", array($_POST), array(ROLE_USER, ROLE_ADMIN)),
            "GET:/activite/[0-9]+/delete" => array("showDeleteActivite", array("1"), array(ROLE_USER, ROLE_ADMIN)),
            "POST:/activite/[0-9]+/delete" => array("deleteActivite", array("1"), array(ROLE_USER, ROLE_ADMIN)),
            "GET:/activite/[0-9]+/update" => array("showUpdateActivite", array("1"), array(ROLE_USER, ROLE_ADMIN)),
            "GET:/activite/[0-9]+/pictures" => array("showPicturesActivite", array("1"), array(ROLE_USER, ROLE_ADMIN)),
            "GET:/pictures/[0-9]+/delete" => array("showPicturesDeleteActivite", array("1", "2"), array(ROLE_USER, ROLE_ADMIN)),
            "POST:/pictures/[0-9]+/delete" => array("picturesDeleteActivite", array("1", "2"), array(ROLE_USER, ROLE_ADMIN)),
            "POST:/activite/[0-9]+/update" => array("updateActivite", array("1", $_POST), array(ROLE_USER, ROLE_ADMIN)),
            "GET:/activite/[0-9]+/upload" => array("showUploadPictureActivite", array("1"), array(ROLE_USER, ROLE_ADMIN)),
            "POST:/activite/[0-9]+/upload" => array("uploadPictureActivite", array("1", $_POST), array(ROLE_USER, ROLE_ADMIN)),
            "GET:/login" => array("showLogin", array(), array()),
            "POST:/login" => array("login", array($_POST), array()),
            "GET:/logout" => array("logout", array(), array()),
            "GET:/configAdmin" => array("showConfigAdmin", array(), array(ROLE_ADMIN)),
            "POST:/updateConfigAdmin/[0-9]+" => array("updateConfigAdmin", array("1",$_POST), array(ROLE_ADMIN)),
            "GET:/sign_up" => array("showSign_up", array(), array()),
            "POST:/sign_up" => array("sign_up", array($_POST), array()),
            "GET:/404" => array("showError404", array(), array())
        ];

        $ctrl = $this->generateControler();
        $this->router($urls, $ctrl);
    }

    private function getCurrentURL() {
        return isset($_SERVER["PATH_INFO"]) ? $_SERVER["PATH_INFO"] : "/";
    }

    private function generateControler() {
        $feedback = isset($_SESSION[SESSION_FEEDBACK]) ? $_SESSION[SESSION_FEEDBACK] : null;
        unset($_SESSION[SESSION_FEEDBACK]);

        return new Controller(new View($feedback));
    }

    private function router($urls, $ctrl) {
        $pathInfo = $this->getCurrentURL();
        $currentUrl = $_SERVER["REQUEST_METHOD"] . ":" . $pathInfo;

        $auth = new AuthenticationManager();
        $shown = false;

        foreach($urls as $u => $property) {
            if(preg_match("/^".str_replace("/", "\/", $u)."\/?$/", $currentUrl)) {
                $methodToCall = $property[0];
                $methodArgs = $property[1];
                $roles = $property[2];

                if(empty($roles) || $auth->isConnected() && in_array($auth->getUser()->getRole()->getLibelle(), $roles)) {
                    $methodArgs = $this->formatArgs($methodArgs, $this->parseUrl($pathInfo));

                    call_user_func(array($ctrl, $methodToCall), ...$methodArgs);
                    $shown = true;
                }

                break;
            }
        }

        if(!$shown) {
            $this->POSTRedirect($this->get404URL());
        }
    }

    private function parseUrl($pathinfo) {
        $urlPath = explode("/", substr($pathinfo, 1));
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
        $_SESSION[SESSION_FEEDBACK] = $feedback;

        header("Location: " . $url, true, 303);
    }

    public function getFormData() {
        return (isset($_SESSION[SESSION_FORM])) ? $_SESSION[SESSION_FORM] : null;
    }

    public function setFormData($formData) {
        $_SESSION[SESSION_FORM] = $formData;
    }

    public function getIndexURL() {
        return "/";
    }

    public function get404URL() {
        return "/404";
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

    public function getActiviteUploadPictureURL($id) {
        return "/activite/" . $id . "/upload";
    }

    public function getActivitePictureURL($id) {
        return "/activite/" . $id . "/pictures";
    }

    public function getPictureDeleteURL($idPhoto) {
        return "/pictures/" . $idPhoto . "/delete";
    }

    public function getActiviteSupprimerURL($id) {
        return "/activite/" . $id . "/delete";
    }

    public function getAddCommentURL($id) {
        return "/activite/" . $id . "/addComment";
    }

    public function getLoginURL() {
        return "/login";
    }

    public function getLogoutURL() {
        return "/logout";
    }

    public function getConfigAdminURL(){
        return "/configAdmin";
    }

    public function getUpdateConfigURL($id){
        return "/updateConfigAdmin/".$id;
    }

    public function getSignUpURL() {
        return "/sign_up";
    }

    public function getAboutURL() {
        return "/about";
    }
}
