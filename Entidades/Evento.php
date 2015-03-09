<?php

/**
 * @author Leonel
 */
class Evento {
    var $id;
    var $titulo;
    var $artistas;
    var $fecha;
    var $hora;
    var $lugar;
    var $precio;
    var $link;
    var $informacion;
    var $afiche;
    
    function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getArtistas() {
        return $this->artistas;
    }

    public function setArtistas($artistas) {
        $this->artistas = $artistas;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getHora() {
        return $this->hora;
    }

    public function setHora($hora) {
        $this->hora = $hora;
    }

    public function getLugar() {
        return $this->lugar;
    }

    public function setLugar($lugar) {
        $this->lugar = $lugar;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function getLink() {
        return $this->link;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function getInformacion() {
        return $this->informacion;
    }

    public function setInformacion($informacion) {
        $this->informacion = $informacion;
    }

    public function getAfiche() {
        return $this->afiche;
    }

    public function setAfiche($afiche) {
        $this->afiche = $afiche;
    }



}

?>
