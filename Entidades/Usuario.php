<?php

/**
 * @author Leonel
 */
class User {
    var $uid;
    var $tipo;
    
    function __construct() {
        
    }
    
    public function getUid() {
        return $this->uid;
    }

    public function setUid($uid) {
        $this->uid = $uid;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }



}

?>
