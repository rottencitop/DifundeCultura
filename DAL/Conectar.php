<?php
class Conectar{
	
	private $SERVER = "localhost";
	private $USUARIO = "root";
	private $PASSWORD = "";
	private $DATABASE = "DifundeCultura";
	private $conexion;
	
	public function __construct(){
		
	}
	
	public function abrirConexion(){
		$this->conexion = new MySQLi($this->SERVER,$this->USUARIO,$this->PASSWORD,$this->DATABASE);
		$this->conexion->query("SET NAMES utf8");
		return $this->conexion;
	}
	
	
}
?>