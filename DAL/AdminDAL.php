<?php
define(__ROOT__,dirname(dirname(__FILE__)));
#Importamos las clases necesarias
require_once(__ROOT__.'/DAL/Conectar.php');
require_once(__ROOT__.'/Entidades/Usuario.php');
require_once(__ROOT__.'/Entidades/Recomendacion.php');
require_once(__ROOT__.'/Entidades/Disco.php');
require_once(__ROOT__.'/Entidades/Concierto.php');
require_once(__ROOT__.'/Entidades/Evento.php');
require_once(__ROOT__.'/Entidades/Libro.php');
require_once(__ROOT__.'/Entidades/Error.php');
require_once(__ROOT__.'/Entidades/Comentario.php');

class AdminDAL{
	private $conectar;
	
	function __construct(){
		$this->conectar = new Conectar();
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
	
	#Ver todos los usuarios de la BD
	public function verUsuarios(){
		$mysqli = $this->conectar->abrirConexion();
		$usuarios = null;
		$SQL = "SELECT uid,tipo FROM Usuario";
		$ps = $mysqli->prepare($SQL);
		$ps->execute();
		$ps->store_result();
		if($ps->num_rows > 0){
			$usuarios = array();
			$ps->bind_result($nUid,$nTipo);
			while($ps->fetch()){
				$user = new User();
				$user->setUid($nUid);
				$user->setTipo($nTipo);
				$usuarios[] = $user;
			}
			$ps->free_result();
			$ps->close();
		}
		$mysqli->close();
		return $usuarios;
	}
	
	#Ver Recomendacion/es
	public function verRecomendaciones($id){
		$recomendaciones = null;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "SELECT * FROM Recomendacion";
		if($id != null){
			$SQL .= " WHERE id = ?";
		}
		$ps = $mysqli->prepare($SQL);
		if($id != null){
			$ps->bind_param("i",$id);
		}
		$ps->execute();
		$ps->store_result();
		$ps->bind_result($nId,$nUsuario,$nTipo,$nTitulo,$nMensaje);
		if($ps->num_rows > 0){
			$recomendaciones = array();
			while($ps->fetch()){
				$r = new Recomendacion();
				$r->setId($nId);
				$r->setUsuario($nUsuario);
				$r->setTipo($nTipo);
				$r->setTitulo($nTitulo);
				$r->setMensaje($nMensaje);
				$recomendaciones[] = $r;
			}
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $recomendaciones;
	}
	
	#Eliminar recomendacion
	public function eliminarRecomendacion($id){
		$r = false;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "DELETE FROM Recomendacion WHERE id = ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("i",$id);
		$ps->execute();
		$ps->store_result();
		if($ps->affected_rows > 0){
			$r = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
	}
	
	#Insertar post
	public function addPost(){
		$mysqli = $this->conectar->abrirConexion();
		$mysqli->query("INSERT INTO Post() VALUES()");
		$post = null;
		$res = $mysqli->query("SELECT id FROM Post ORDER BY id DESC LIMIT 1");
		$fila = $res->fetch_assoc();
		$post = $fila['id'];
		return $post;
	}
	
	#Agregar Concierto
	public function addConcierto($concierto){
		$post = $this->addPost();
		$r = null;
		if($post != null){
			$r = false;
			$mysqli = $this->conectar->abrirConexion();
			$SQL = "INSERT INTO Concierto(post,nombre,artista,youtube,descripcion,imagen) VALUES(?,?,?,?,?,?)";
			$ps = $mysqli->prepare($SQL);
			$ps->bind_param("isssss",$post,$concierto->getNombre(), $concierto->getArtista(), $concierto->getYoutube(), $concierto->getDescripcion(),$concierto->getImagen());
			if($ps->execute()){
				$r = true;
			}
			$ps->free_result();
			$ps->close();
			$mysqli->close();
		}
		return $r;
	}
	
	#Agregar un Disco
	public function addDisco($disco){
		$post = $this->addPost();
		$r = null;
		if($post != null){
			$r = false;
			$mysqli = $this->conectar->abrirConexion();
			$SQL = "INSERT INTO Disco(post,nombre,artista,descarga,linkCompra, descripcion, tracklist, imagen,imagenP) ";
			$SQL.= "VALUES(?,?,?,?,?,?,?,?,?)";
			$ps = $mysqli->prepare($SQL);
			$ps->bind_param("issssssss",$post,$disco->getNombre(),$disco->getArtista(),$disco->getDescarga(),$disco->getLinkCompra(),$disco->getDescripcion(),$disco->getTracklist(),$disco->getCaratula(),$disco->getImagenP());
			if($ps->execute()){
				$r = true;
			}
			$ps->free_result();
			$ps->close();
			$mysqli->close();
		}
		return $r;
	}
	
	#Agregar Libro
	public function addLibro($libro){
		$post = $this->addPost();
		$r = null;
		if($post != null){
			$r = false;
			$mysqli = $this->conectar->abrirConexion();
			$SQL = "INSERT INTO Libro(post,nombre,artista,descripcion,link,imagen,linkCompra,imagenP) VALUES(?,?,?,?,?,?,?,?)";
			$ps = $mysqli->prepare($SQL);
			$ps->bind_param("isssssss",$post,$libro->getNombre(),$libro->getArtista(),$libro->getDescripcion(),$libro->getLink(),$libro->getImagen(),$libro->getLinkCompra(),$libro->getImagenP());
			if($ps->execute()){
				$r = true;
			}
			$ps->free_result();
			$ps->close();
			$mysqli->close();
		}
		return $r;
	}
	
	#eliminar id post
	public function eliminarPost($id){
		$r = false;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "DELETE FROM Post WHERE id = ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("i",$id);
		$ps->execute();
		$ps->store_result();
		if($ps->affected_rows > 0){
			$r = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
	}
	
	#Eliminar Comentario
	public function eliminarComentario($comentario){
		$r = false;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "DELETE FROM Comentario WHERE id = ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("i",$comentario);
		$ps->execute();
		$ps->store_result();
		if($ps->affected_rows > 0){
			$r = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
	}
	
	#Agregar Artista
	public function addArtista($artista){
		$r = false;
		
			$mysqli = $this->conectar->abrirConexion();
			$SQL = "INSERT INTO Artista(nombre, resena, web, facebook, twitter, wiki, soundcloud) VALUES(?,?,?,?,?,?,?)";
			$ps = $mysqli->prepare($SQL);
			$ps->bind_param("sssssss",$artista->getNombre(),$artista->getResena(),$artista->getWeb(),$artista->getFacebook(), $artista->getTwitter(), $artista->getWiki(), $artista->getSoundcloud());
			if($ps->execute()){
				$r = true;
			}
			$ps->free_result();
			$ps->close();
			$mysqli->close();
		
		return $r;
	}
	
	#Agregar tipo de arte del artista
	public function addTipoArtista($artista,$tipo){
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "INSERT INTO TipoArtista(artista,tipo) VALUES(?,?)";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("ss",$artista,$tipo);
		$r = false;
		if($ps->execute()){
			$r = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
	}
	
	#Agregar imagen a Artista
	public function addImagenArtista($artista,$imagen){
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "INSERT INTO ImagenArtista(imagen,artista) VALUES(?,?)";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("ss",$imagen,$artista);
		$r = false;
		if($ps->execute()){
			$r = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
	}
	
	#Agregar Genero al Artista
	public function addGeneroArtista($artista,$genero){
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "INSERT INTO GeneroArtista(artista,genero) VALUES(?,?)";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("ss",$artista,$genero);
		$r = false;
		if($ps->execute()){
			$r = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
	}
	
	#Agregar un Genero
	public function addGenero($genero){
		$r = false;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "INSERT INTO Genero(nombre) VALUES(?)";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("s",$genero);
		if($ps->execute()){
			$r = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
	}
	
	#Agregar Evento
	public function addEvento($e){
		$r = false;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "INSERT INTO Evento(titulo,artistas,fecha,hora,lugar,precio,link,informacion,afiche) ";
		$SQL.= "VALUES (?,?,?,?,?,?,?,?,?)";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("sssssssss",$e->getTitulo(),$e->getArtistas(),$e->getFecha(),$e->getHora(),$e->getLugar(),$e->getPrecio(),$e->getLink(),$e->getInformacion(),$e->getAfiche());
		if($ps->execute()){
			$r = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
	}
	
	#eliminar Evento
	public function eliminarEvento($evento){
		$r = false;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "DELETE FROM Evento WHERE id = ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("i",$vento);
		$ps->execute();
		$ps->store_result();
		if($ps->affected_rows > 0){
			$r = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
	}
	
	#Ver Errores
	public function verErrores($tabla){
		$errores = null;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "";
		switch($tabla){
			case "concierto":
				$SQL = "SELECT c.post, c.nombre, c.artista, e.id, e.mensaje, e.usuario FROM post p ";
				$SQL.= "INNER JOIN concierto c ON c.post = p.id ";
				$SQL.= "INNER JOIN errores e ON c.post = e.post AND e.post = p.id ORDER BY e.id DESC" ;
			break;
			case "disco":
				$SQL = "SELECT c.post, c.nombre, c.artista, e.id, e.mensaje, e.usuario FROM post p ";
				$SQL.= "INNER JOIN disco c ON c.post = p.id ";
				$SQL.= "INNER JOIN errores e ON c.post = e.post AND e.post = p.id ORDER BY e.id DESC" ;
			break;
			case "libro":
				$SQL = "SELECT c.post, c.nombre, c.artista, e.id, e.mensaje, e.usuario FROM post p ";
				$SQL.= "INNER JOIN libro c ON c.post = p.id ";
				$SQL.= "INNER JOIN errores e ON c.post = e.post AND e.post = p.id ORDER BY e.id DESC" ;
			break;
		}
		$res = $mysqli->query($SQL);
		if($res->num_rows > 0){
			$errores = array();
			while($fila = $res->fetch_assoc()){
				$errores[] = $fila;
			}
		}
		$res->free_result();
		$mysqli->close();
		return $errores;
	}
	
	#Eliminar Error
	public function eliminarError($error){
		$r = false;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "DELETE FROM Errores WHERE id = ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("i",$error);
		$ps->execute();
		$ps->store_result();
		if($ps->affected_rows > 0){
			$r = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
	}
	
}

?>