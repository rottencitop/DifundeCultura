<?php

/**
 * @author Leonel
 */
class Concierto {
    var $post;
    var $nombre;
    var $artista;
    var $youtube;
    var $descripcion;
    var $imagen;
    
    function __construct() {
        
    }
    
    public function getPost() {
        return $this->post;
    }

    public function setPost($post) {
        $this->post = $post;
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

    public function getYoutube() {
        return $this->youtube;
    }

    public function setYoutube($youtube) {
        $this->youtube = $youtube;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }



}

?>
