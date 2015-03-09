<?php
define(__ROOT__,dirname(dirname(__FILE__)));
#Importamos las clases necesarias
require_once(__ROOT__.'/DAL/Conectar.php');
require_once(__ROOT__.'/Entidades/Artista.php');
class ArtistaDAL{
	private $conectar;
	
	function __construct(){
		$this->conectar = new Conectar();
	}
	
	#Busca Artista por un Nombre
	public function verArtista($nombre){
		$mysqli = $this->conectar->abrirConexion();
		$artista = null;
		$SQL = "SELECT * FROM Artista WHERE nombre LIKE ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("s",$nombre);
		$ps->execute();
		$ps->store_result();
		if($ps->num_rows > 0){
			$ps->bind_result($nNombre,$nResena,$nWeb,$nFacebook,$nTwitter,$nWiki,$nSoundcloud);
			$ps->fetch();
			$artista = new Artista();
			$artista->setNombre($nNombre);
			$artista->setResena($nResena);
			$artista->setWeb($nWeb);
			$artista->setFacebook($nFacebook);
			$artista->setTwitter($nTwitter);
			$artista->setWiki($nWiki);
			$artista->setSoundcloud($nSoundcloud);
			$ps->free_result();
			$ps->close();
		}
		$mysqli->close();
		return $artista;
	}
	
	#Ver todos los Artistas
	public function verArtistas(){
		$mysqli = $this->conectar->abrirConexion();
		$artistas = null;
		$SQL = "SELECT * FROM Artista order by nombre ASC";
		$ps = $mysqli->prepare($SQL);
		$ps->execute();
		$ps->store_result();
		if($ps->num_rows > 0){
			$ps->bind_result($nNombre,$nResena,$nWeb,$nFacebook,$nTwitter,$nWiki,$nSoundcloud);
			$artistas = array();
			while($ps->fetch()){
				$artista = new Artista();
				$artista->setNombre($nNombre);
				$artista->setResena($nResena);
				$artista->setWeb($nWeb);
				$artista->setFacebook($nFacebook);
				$artista->setTwitter($nTwitter);
				$artista->setWiki($nWiki);
				$artista->setSoundcloud($nSoundcloud);
				$artistas[] = $artista;
			}
			$ps->free_result();
			$ps->close();
		}
		$mysqli->close();
		return $artistas;
	}
	
	
	#Ver tipo de arte de artista
	public function verTipoArtedeArtista($artista){
		$mysqli = $this->conectar->abrirConexion();
		$tipos = null;
		$SQL = "SELECT tipo FROM TipoArtista WHERE artista LIKE ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("s",$artista);
		$ps->execute();
		$ps->store_result();
		if($ps->num_rows > 0){
			$tipos = array();
			$ps->bind_result($ntipo);
			while($ps->fetch()){
				$tipos[] = $ntipo;
			}
			$ps->free_result();
			$ps->close();
		}
		$mysqli->close();
		return $tipos;
	}
	
	#Ver tipo de arte de artista
	public function verArtistadeTipo($tipo){
		$mysqli = $this->conectar->abrirConexion();
		$artistas = null;
		$SQL = "SELECT artista FROM TipoArtista WHERE tipo LIKE ? ORDER BY artista ASC";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("s",$tipo);
		$ps->execute();
		$ps->store_result();
		if($ps->num_rows > 0){
			$artistas = array();
			$ps->bind_result($nArtista);
			while($ps->fetch()){
				$artistas[] = $nArtista;
			}
			$ps->free_result();
			$ps->close();
		}
		$mysqli->close();
		return $artistas;
	}
	
	#Buscar Artista que comiencen con una letra
	public function verArtistasQueComiencen($letra){
		$mysqli = $this->conectar->abrirConexion();
		$artistas = null;
		$SQL = "SELECT nombre FROM Artista WHERE nombre LIKE CONCAT(?,'%')";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("s",$letra);
		$ps->execute();
		$ps->store_result();
		if($ps->num_rows > 0){
			$ps->bind_result($nNombre);
			$artistas = array();
			while($ps->fetch()){
				$artista = new Artista();
				$artista->setNombre($nNombre);
				$artistas[] = $artista;
			}
			$ps->free_result();
			$ps->close();
		}
		$mysqli->close();
		return $artistas;
	}
	
	#Ver Generos de un Artista
	public function verGenerosdeArtista($artista){
		$mysqli = $this->conectar->abrirConexion();
		$generos = null;
		$SQL = "SELECT genero FROM GeneroArtista WHERE artista LIKE ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("s",$artista);
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
	
	#Ver Imagenes de un Artista
	public function verImagenesArtista($artista){
		$imagenes = null;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "SELECT imagen from ImagenArtista WHERE artista = ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("s",$artista);
		$ps->execute();
		$ps->store_result();
		$ps->bind_result($nImagen);
		if($ps->num_rows > 0){
			$imagenes = array();
			while($ps->fetch()){
				$imagenes[] = $nImagen;
			}
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $imagenes;
	}
	
	#Ver Artistas de un Genero
	public function verArtistasdeunGenero($genero){
		$mysqli = $this->conectar->abrirConexion();
		$artistas = null;
		$SQL = "SELECT artista FROM GeneroArtista WHERE genero LIKE ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("s",$genero);
		$ps->execute();
		$ps->store_result();
		if($ps->num_rows > 0){
			$artistas = array();
			$ps->bind_result($nNombre);
			while($ps->fetch()){
				$artistas[] = $nNombre;
			}
			$ps->free_result();
			$ps->close();
		}
		$mysqli->close();
		return $artistas;
	}
	
	#Permite saber si un usuario sigue a un artista
	public function sigoAlArtista($usuario,$artista){
		$mysqli = $this->conectar->abrirConexion();
		$res = false;
		$SQL = "SELECT * FROM ArtistaUsuario WHERE usuario = ? AND artista = ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("ss",$usuario,$artista);
		$ps->execute();
		$ps->store_result();
		if($ps->num_rows > 0){
			$res = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $res;
	}
	
	#Permite seguir al artista
	public function seguirArtista($usuario,$artista){
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "INSERT INTO ArtistaUsuario(usuario,artista) VALUES(?,?)";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("ss",$usuario,$artista);
		$res = false;
		if($ps->execute()){
			$res = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $res;
	}
	
	#Permite no seguir al artista
	public function noSeguirArtista($usuario,$artista){
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "DELETE FROM ArtistaUsuario WHERE usuario = ? AND artista = ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("ss",$usuario,$artista);
		$res = false;
		$ps->execute();
		$ps->store_result();
		if($ps->affected_rows > 0){
			$res = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $res;
	}
	
	#Buscar artista
	public function buscarArtista($palabra){
		$artistas = null;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "SELECT nombre FROM Artista WHERE nombre LIKE CONCAT('%',?,'%')";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("s",$palabra);
		$ps->execute();
		$ps->store_result();
		if($ps->num_rows > 0){
			$artistas = array();
			$ps->bind_result($nombre);
			while($ps->fetch()){
				$artistas[] = $nombre;
			}
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $artistas;
	}
	
}
?>