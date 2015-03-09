<?php

/**
 * @author Leonel
 */
class TipoArtista {
    var $tipo;
    var $artista;
    
    function __construct() {
        
    }
    
    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getArtista() {
        return $this->artista;
    }

    public function setArtista($artista) {
        $this->artista = $artista;
    }



}

?>
