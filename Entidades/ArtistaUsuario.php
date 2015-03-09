<?php

/**
 * @author Leonel
 */
class ArtistaUsuario {
    var $usuario;
    var $artista;
    
    function __construct() {
        
    }
    
    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getArtista() {
        return $this->artista;
    }

    public function setArtista($artista) {
        $this->artista = $artista;
    }



}

?>
