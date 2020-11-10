<?php

require_once("lib/FileStore.php");

/*
 * Une classe qui permet de stocker facilement des objets
 * dans un tableau stocké dans un fichier (à l'aide de la classe
 * FileStore). Les méthodes sont proches de l'utilisation
 * d'une table dans une BD.
 */
class ObjectFileDB {

    /* Le FileStore qui permet la persistance des données. */
    private $file_store;

    /* Construit une nouvelle instance, qui utilise le fichier donné
     * en paramètre. Si le fichier n'existe pas, une base vide
     * est créée automatiquement. */
    public function __construct($file) {
        $this->file_store = FileStore::makeStore($file, array());
    }

    /* Génère un nouvel identifiant aléatoire qui n'existe pas
     * encore dans la BD donnée en paramètre. */
    static private function generate_id($db) {
        do {
            /* implémentation simple avec un générateur de relativement
             * bonne qualité ; mais les identifiants sont longs si
             * on veut en avoir beaucoup. (avec 8 octets on en a seulement
             * 10^20 environ -- c'est pas mal, mais pas gigantesque
             * en termes de probabilité de collision lors de la génération) */
            $id = bin2hex(openssl_random_pseudo_bytes(8));

            /* on recommence le tirage si le premier caractère est un chiffre
             * (pour éviter les problèmes d'interprétation de chaînes en
             * nombres avec PHP) ou si l'identifiant est déjà utilisé */
        } while (is_numeric($id[0]) || key_exists($id, $db));

        return $id;
    }

    private function loadArray() {
        $data = $this->file_store->loadData();
        if ( ! is_array($data) ) {
            throw new Exception("File '".$this->file_store->getFileName()."' does not contain an array; maybe it was corrupted?");
        }
        return $data;
    }

    /* Renvoie true si l'identifiant existe dans la base. */
    public function exists($id) {
        $db = $this->loadArray();
        $this->file_store->unlockFile();
        return key_exists($id, $db);
    }

    /* Insère un objet dans la base. Renvoie l'identifiant
     * aléatoire qui lui a été attribué.
     */
    public function insert($obj) {
        $db = $this->loadArray();
        $id = self::generate_id($db);
        $db[$id] = $obj;
        $this->file_store->saveData($db);
        return $id;
    }

    /* Renvoie l'objet d'identifiant $id.
     * Lance une exception si l'identifiant est inconnu.
     */
    public function fetch($id) {
        $db = $this->loadArray();
        $this->file_store->unlockFile();
        if ( ! key_exists($id, $db)) {
            throw new Exception("Key does not exist");
        }
        return $db[$id];
    }

    /* Renvoie tous les objets de la base dans un tableau
     * associatif { identifiant => objet }.
     */
    public function fetchAll() {
        $db = $this->loadArray();
        $this->file_store->unlockFile();
        return $db;
    }

    /* Supprime l'objet d'identifiant $id de la base.
     * Lance une exception si l'identifiant est inconnu.
     */
    public function delete($id) {
        $db = $this->loadArray();
        if ( ! key_exists($id, $db)) {
            throw new Exception("Key does not exist");
        }
        unset($db[$id]);
        $this->file_store->saveData($db);
    }

    /* Remplace l'objet d'identifiant $id dans la base
     * par celui passé en paramètre.
     * Lance une exception si l'identifiant est inconnu.
     */
    public function update($id, $obj) {
        $db = $this->loadArray();
        if ( ! key_exists($id, $db)) {
            throw new Exception("Key does not exist");
        }
        $db[$id] = $obj;
        $this->file_store->saveData($db);
    }

    /* Supprime tous les objets de la base.
     */
    public function deleteAll() {
        $this->file_store->saveData(array());
    }

}

