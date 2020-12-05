<?php

class PhotoUploader {

    const UPLOAD_ERR_MSG = [
        UPLOAD_ERR_OK => "",
        UPLOAD_ERR_INI_SIZE => "La taille du fichier téléchargé excède la valeur autorisée",
        UPLOAD_ERR_FORM_SIZE => "La taille du fichier téléchargé excède la valeur autorisée",
        UPLOAD_ERR_PARTIAL => "Le fichier n'a été que partiellement téléchargé",
        UPLOAD_ERR_NO_FILE => "Aucun fichier n'a été téléchargé",
        UPLOAD_ERR_NO_TMP_DIR => "Un dossier temporaire est manquant",
        UPLOAD_ERR_CANT_WRITE => "Echec de l'écriture du fichier sur le disque",
        UPLOAD_ERR_EXTENSION => "Une extension PHP a arrêté l'envoi de fichier"
    ];

    const EXTS = [
        IMAGETYPE_GIF => ".gif",
        IMAGETYPE_JPEG => ".jpeg",
        IMAGETYPE_PNG => ".png",
        IMAGETYPE_SWF => ".swf",
        IMAGETYPE_PSD => ".psd",
        IMAGETYPE_BMP => ".bmp",
        IMAGETYPE_TIFF_II => ".tiff_ii",
        IMAGETYPE_TIFF_MM => ".tim_mm",
        IMAGETYPE_JPC => ".jpc",
        IMAGETYPE_JP2 => ".jp2",
        IMAGETYPE_JPX => ".jpx",
        IMAGETYPE_JB2 => ".jb2",
        IMAGETYPE_SWC => ".swc",
        IMAGETYPE_IFF => ".iff",
        IMAGETYPE_WBMP => ".wbmp",
        IMAGETYPE_XBM => ".xbm",
        IMAGETYPE_ICO => ".ico",
//        IMAGETYPE_WEBP => ".webp"    <- Non dispo sur PHP 7.0
    ];

    private $file;
    private $fileName;
    private $imgType;

    private $error;

    public function __construct($file) {
        $this->file = $file;
    }

    public function isValid() {
        $this->error = "";

        if($this->file['error'] != UPLOAD_ERR_OK) {
            $this->error = PhotoUploader::UPLOAD_ERR_MSG[$this->file['error']];
            return false;
        }
    
        $this->imgType = exif_imagetype($this->file['tmp_name']);
        if(!$this->imgType) {
            $this->error = "Le fichier uploadé n'est pas une image";
            return false;
        }

        return true;
    }

    public function save() {    
        $name = date('Ymdhis', time());
        $ext = PhotoUploader::EXTS[$this->imgType];
        $this->fileName = $name . $ext;

        if (!move_uploaded_file($this->file['tmp_name'], UPLOAD_SAVE_PATH . $this->fileName)) {
            $this->error = "Une erreur est survenue lors de la copie du fichier";
            return false;
        }

        return true;
    }

    public function getError() {
        return $this->error;
    }

    public function getFileName() {
        return $this->fileName;
    }
}