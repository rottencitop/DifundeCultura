<?php
define(__ROOT__,dirname(dirname(__FILE__)));
#Importamos las clases necesarias
require_once(__ROOT__.'/DAL/Conectar.php');
require_once(__ROOT__.'/Entidades/Usuario.php');
require_once(__ROOT__.'/Entidades/Error.php');
require_once(__ROOT__.'/Entidades/Recomendacion.php');

class UsuarioDAL{
	private $conectar;
	
	function __construct(){
		$this->conectar = new Conectar();
	}
	
	#Buscamos usuario por su UID de Facebook
	function verUsuario($uid){
		$mysqli = $this->conectar->abrirConexion();
		$user = null;
		$SQL = "SELECT * FROM Usuario WHERE uid = ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("s",$uid);
		$ps->execute();
		$ps->store_result();
		if($ps->num_rows > 0){
			$ps->bind_result($nUid,$nTipo);
			$ps->fetch();
			$user = new User();
			$user->setUid($nUid);
			$user->setTipo($nTipo);
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $user;
	}
	
	#Insertamos un usuario de Facebook a la BD
	public function insertarUsuario($user){
		$u = $this->verUsuario($user->getUid());
		$mysqli = $this->conectar->abrirConexion();
		$mysqli->query("SET NAMES utf8");
		$res = 0;
		if($u == null){
			$SQL = "INSERT INTO Usuario(uid,tipo) values (?,?)";
			$ps = $mysqli->prepare($SQL);
			$ps->bind_param("si",$user->getUid(),$user->getTipo());
			if($ps->execute()){
				$res = 1;
			}
			$ps->free_result();
			$ps->close();
			$mysqli->close();
		}
		return $res;
	}
	
	
	#Agregar Recomendacion
	public function addRecomendacion($rec){
		$r = false;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "INSERT INTO Recomendacion(usuario,tipo,titulo,mensaje) VALUES(?,?,?,?)";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("ssss",$rec->getUsuario(),$rec->getTipo(),$rec->getTitulo(),$rec->getMensaje());
		if($ps->execute()){
			$r = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
		
	}
	
	#Reportar un error
	public function addError($e){
		$r = false;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "INSERT INTO Errores(post,usuario,mensaje) VALUES(?,?,?)";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("iss",$e->getPost(),$e->getUsuario(),$e->getMensaje());
		if($ps->execute()){
			$r = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
	}
	
	#Ver todos los Géneros
	public function verGeneros(){
		$mysqli = $this->conectar->abrirConexion();
		$generos = null;
		$SQL = "SELECT * FROM Genero ORDER BY nombre ASC";
		$ps = $mysqli->prepare($SQL);
		$ps->execute();
		$ps->store_result();
		if($ps->num_rows > 0){
			$generos = array();
			$ps->bind_result($nNombre);
			while($ps->fetch()){
				$generos[] = $nNombre;
			}
			$ps->free_result();
			$ps->close();
		}
		$mysqli->close();
		return $generos;
	}
	
}

?>