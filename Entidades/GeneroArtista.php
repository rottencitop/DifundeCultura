<?php

/**
 * @author Leonel
 */
class GeneroArtista {
    var $artista;
    var $genero;
    
    function __construct() {
        
    }
    
    public function getArtista() {
        return $this->artista;
    }

    public function setArtista($artista) {
        $this->artista = $artista;
    }

    public function getGenero() {
        return $this->genero;
    }

    public function setGenero($genero) {
        $this->genero = $genero;
    }



}

?>
