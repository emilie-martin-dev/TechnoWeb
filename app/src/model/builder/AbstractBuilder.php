<?php

abstract class AbstractBuilder {

    protected $data;
    protected $error;

    public function __construct($data, $error = null) {
        $this->data = $data;
        $this->error = $error;
    }

    public function create(){
        if($this->data == null || $this->data != null && !$this->isValid())
            return null;

        return $this->createModel();
    }

    public abstract function createModel();

    public abstract function isValid();

    public function getAttribute($name) {
        return isset($this->data[$name]) ? $this->data[$name] : "";
    }

    public function setAttribute($name, $value) {
        $this->data[$name] = $value;
    }

    public function getData() {
        return $this->data;
    }

    public function getError() {
        return $this->error;
    }

}
