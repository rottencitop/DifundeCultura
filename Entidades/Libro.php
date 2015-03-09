<?php

/**
 * @author Leonel
 */
class Libro {
    var $post;
    var $titulo;
    var $nombre;
    var $artista;
    var $descripcion;
    var $link;
    var $linkCompra;
    var $imagen;
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

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getLink() {
        return $this->link;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function getLinkCompra() {
        return $this->linkCompra;
    }

    public function setLinkCompra($linkCompra) {
        $this->linkCompra = $linkCompra;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }



}

?>
