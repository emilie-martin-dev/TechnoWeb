<?php

require_once("model/builder/AbstractBuilder.php");
require_once("model/Config.php");

class BuilderConfig extends AbstractBuilder {

    const FIELD_ID = "ID";
    const FIELD_LIBELLE = "LIBELLE";
    const FIELD_VALEUR = "VALEUR";

    public function __construct($data, $error = null) {
        parent::__construct($data, $error);
    }

    public static function buildFromConfig(Config $config) {
        return new BuilderConfig(array(
            BuilderConfig::FIELD_ID => $config->getId(),
            BuilderConfig::FIELD_LIBELLE => $config->getLibelle(),
            BuilderConfig::FIELD_VALEUR => $config->getValeur(),
        ));
    }

    public function create() {
        if($this->data == null || $this->data != null && !$this->isValid())
            return null;

        $c = new Config();

        if(isset($this->data[BuilderConfig::FIELD_ID]))
            $c->setId($this->data[BuilderConfig::FIELD_ID]);

        $c->setLibelle($this->data[BuilderConfig::FIELD_LIBELLE]);
        $c->setValeur($this->data[BuilderConfig::FIELD_VALEUR]);

        return $c;
    }

    public function isValid() {
        $this->error = array();

        if(isset($this->data[BuilderUtilisateur::FIELD_ID]) && !is_numeric($this->data[BuilderUtilisateur::FIELD_ID])) {
            $this->error[BuilderUtilisateur::FIELD_ID] = "La valeur de l'id est incorrect";
        }

        if(empty($this->data[BuilderConfig::FIELD_LIBELLE])) {
            $this->error[BuilderConfig::FIELD_LIBELLE] = "Le libellé est obligatoire";
        }

        if(empty($this->data[BuilderConfig::FIELD_VALEUR])) {
            $this->error[BuilderConfig::FIELD_VALEUR] = "La valeur est obligatoire";
        }

        return count($this->error) == 0;
    }

}
