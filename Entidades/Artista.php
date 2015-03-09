<?php

/**
 * @author Leonel
 */
class Artista {
    var $nombre;
    var $resena;
    var $web;
    var $facebook;
    var $twitter;
    var $wiki;
    var $soundcloud;
    
    function __construct() {
        
    }
    
    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getResena() {
        return $this->resena;
    }

    public function setResena($resena) {
        $this->resena = $resena;
    }

    public function getWeb() {
        return $this->web;
    }

    public function setWeb($web) {
        $this->web = $web;
    }

    public function getFacebook() {
        return $this->facebook;
    }

    public function setFacebook($facebook) {
        $this->facebook = $facebook;
    }

    public function getTwitter() {
        return $this->twitter;
    }

    public function setTwitter($twitter) {
        $this->twitter = $twitter;
    }

    public function getWiki() {
        return $this->wiki;
    }

    public function setWiki($wiki) {
        $this->wiki = $wiki;
    }

    public function getSoundcloud() {
        return $this->soundcloud;
    }

    public function setSoundcloud($soundcloud) {
        $this->soundcloud = $soundcloud;
    }



}

?>
