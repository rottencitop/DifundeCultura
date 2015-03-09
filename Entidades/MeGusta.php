<?php

/**
 * @author Leonel
 */
class MeGusta {
    var $usuario;
    var $post;
    
    function __construct() {
        
    }
    
    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getPost() {
        return $this->post;
    }

    public function setPost($post) {
        $this->post = $post;
    }



}

?>
