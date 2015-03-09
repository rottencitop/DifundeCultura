<?php

/**
 * @author Leonel
 */
class Comentario {
    var $id;
    var $usuario;
    var $post;
    var $fecha;
    var $comentario;
    
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

    public function getPost() {
        return $this->post;
    }

    public function setPost($post) {
        $this->post = $post;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getComentario() {
        return $this->comentario;
    }

    public function setComentario($comentario) {
        $this->comentario = $comentario;
    }



}

?>
