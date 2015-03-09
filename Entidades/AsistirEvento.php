<?php

/**
 * @author Leonel
 */
class AsistirEvento {
    var $evento;
    var $usuario;
    
    function __construct() {
        
    }
    
    public function getEvento() {
        return $this->evento;
    }

    public function setEvento($evento) {
        $this->evento = $evento;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }



}

?>
