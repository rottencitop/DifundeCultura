<?php

/**
 * @author Leonel
 */
class Recomendacion{
    var $id;
    var $usuario;
    var $tipo;
    var $titulo;
    var $mensaje;
    
    function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }



}

?>
