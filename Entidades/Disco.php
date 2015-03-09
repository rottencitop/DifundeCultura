<?php

/**
 * @author Leonel
 */
class Disco {
    var $post;
    var $titulo;
    var $nombre;
    var $artista;
    var $descarga;
    var $linkCompra;
    var $descripcion;
    var $tracklist;
    var $caratula;
	var $imagenP;
    
    function __construct() {
        
    }
	
	public function getImagenP() {
        return $this->imagenP;
    }

    public function setImagenP($imagenP) {
        $this->imagenP = $imagenP;
    }
    
    public function getPost() {
        return $this->post;
    }

    public function setPost($post) {
        $this->post = $post;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getArtista() {
        return $this->artista;
    }

    public function setArtista($artista) {
        $this->artista = $artista;
    }

    public function getDescarga() {
        return $this->descarga;
    }

    public function setDescarga($descarga) {
        $this->descarga = $descarga;
    }

    public function getLinkCompra() {
        return $this->linkCompra;
    }

    public function setLinkCompra($linkCompra) {
        $this->linkCompra = $linkCompra;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getTracklist() {
        return $this->tracklist;
    }

    public function setTracklist($tracklist) {
        $this->tracklist = $tracklist;
    }

    public function getCaratula() {
        return $this->caratula;
    }

    public function setCaratula($caratula) {
        $this->caratula = $caratula;
    }



}

?>
