<?php
define(__ROOT__,dirname(dirname(__FILE__)));
#Importamos las clases necesarias
require_once(__ROOT__.'/DAL/Conectar.php');
require_once(__ROOT__.'/Entidades/Disco.php');
require_once(__ROOT__.'/Entidades/Concierto.php');
require_once(__ROOT__.'/Entidades/Libro.php');
require_once(__ROOT__.'/Entidades/Evento.php');
require_once(__ROOT__.'/Entidades/Comentario.php');
class PostDAL{
	private $conectar;
	
	function __construct(){
		$this->conectar = new Conectar();
	}
	
	#Buscar Post por Genero
	public function verPostPorGeneros($tabla,$genero){
		$posts = null;
		$mysqli = $this->conectar->abrirConexion();
		switch($tabla){
			case "concierto":
				$SQL = "SELECT c.post, c.nombre, c.artista, c.imagen FROM Concierto c INNER JOIN Artista a ON a.nombre = c.artista INNER JOIN GeneroArtista ga ON ga.artista = a.nombre AND ga.genero = ? ORDER BY c.artista ASC , c.nombre ASC";
				$ps = $mysqli->prepare($SQL);
				$ps->bind_param("s",$genero);
				$ps->execute();
				$ps->store_result();
				if($ps->num_rows > 0){
					$ps->bind_result($post,$nombre,$artista,$imagen);
					$posts = array();
					while($ps->fetch()){
						$c = new Concierto();
						$c->setPost($post);
						$c->setNombre($nombre);
						$c->setArtista($artista);
						$c->setImagen($imagen);
						$posts[] = $c;
					}
				}
				break;
			case "disco":
				$SQL = "SELECT d.post, d.nombre, d.artista, d.imagenP FROM Disco d INNER JOIN Artista a ON a.nombre = d.artista INNER JOIN GeneroArtista ga ON ga.artista = a.nombre AND ga.genero = ? ORDER BY d.artista ASC , d.nombre ASC;";
				$ps = $mysqli->prepare($SQL);
				$ps->bind_param("s",$genero);
				$ps->execute();
				$ps->store_result();
				if($ps->num_rows > 0){
					$posts = array();
					$ps->bind_result($post,$nombre,$artista,$imagenp);
					while($ps->fetch()){
						$d = new Disco();
						$d->setPost($post);
						$d->setNombre($nombre);
						$d->setArtista($artista);
						$d->setImagenP($imagenp);
						$posts[] = $d;
					}
				}
				break;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $posts;	
	}
	
	#Buscar POST por ABC
	public function verPostporABC($tabla,$letra){
		$posts = null;
		$mysqli = $this->conectar->abrirConexion();
		switch($tabla){
			case "concierto":
				if($letra == "[0-9]"){
					$SQL = "SELECT v.post, v.nombre, v.artista, v.imagen FROM Concierto v WHERE v.nombre RLIKE '^[0-9].*'";
				}else{
					$SQL = "SELECT v.post, v.nombre, v.artista, v.imagen FROM Concierto v WHERE v.nombre LIKE CONCAT(?,'%') ORDER BY v.nombre ASC";
				}	
				$ps = $mysqli->prepare($SQL);
				$ps->bind_param("s",$letra);
				$ps->execute();
				$ps->store_result();
				if($ps->num_rows > 0){
					$posts = array();
					$ps->bind_result($post,$nombre,$artista,$imagen);
					while($ps->fetch()){
						$c = new Concierto();
						$c->setPost($post);
						$c->setNombre($nombre);
						$c->setArtista($artista);
						$c->setImagen($imagen);
						$posts[] = $c;
					}
				}
				break;
			case "disco":
				if($letra == "[0-9]"){
					$SQL = "SELECT v.post, v.nombre, v.artista, v.imagenP FROM Disco v WHERE v.nombre RLIKE '^[0-9].*'";
				}else{
					$SQL = "SELECT v.post, v.nombre, v.artista, v.imagenP FROM Disco v WHERE v.nombre LIKE CONCAT(?,'%') ORDER BY v.nombre ASC";
				}
				$ps = $mysqli->prepare($SQL);
				$ps->bind_param("s",$letra);
				$ps->execute();
				$ps->store_result();
				if($ps->num_rows > 0){
					$posts = array();
					$ps->bind_result($post,$nombre,$artista,$imagenp);
					while($ps->fetch()){
						$d = new Disco();
						$d->setPost($post);
						$d->setNombre($nombre);
						$d->setArtista($artista);
						$d->setImagenP($imagenp);
						$posts[] = $d;
					}
				}
				break;
			case "libro":
				if($letra == "[0-9]"){
					$SQL = "SELECT v.post, v.nombre, v.artista, v.imagenP FROM Libro v WHERE v.nombre RLIKE '^[0-9].*'";
				}else{
					$SQL = "SELECT v.post, v.nombre, v.artista, v.imagenP FROM Libro v WHERE v.nombre LIKE CONCAT(?,'%') ORDER BY v.nombre ASC";
				}
				$ps = $mysqli->prepare($SQL);
				$ps->bind_param("s",$letra);
				$ps->execute();
				$ps->store_result();
				if($ps->num_rows > 0){
					$posts = array();
					$ps->bind_result($post,$nombre,$artista,$imagenp);
					while($ps->fetch()){
						$l = new Libro();
						$l->setPost($post);
						$l->setNombre($nombre);
						$l->setArtista($artista);
						$l->setImagenP($imagenP);
						$posts[] = $l;
					}
				}
				break;
				
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $posts;
	}
	
	#Ver los 10 conciertos mas populares
	public function verConciertosMasPopulares(){
		$r = null;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "SELECT count(mg.post), mg.post FROM MeGusta mg INNER JOIN Concierto c ON c.post = mg.post GROUP BY post ORDER BY 1 DESC LIMIT 10";
		$ps = $mysqli->prepare($SQL);
		$ps->execute();
		$ps->store_result();
		if($ps->num_rows > 0){
			$r = array();
			$ps->bind_result($cMG, $post);
			while($ps->fetch()){
				$r[] = array('megusta' => $cMG, 'post' => $post);
			}
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
	}
	
	#Ver si el post existe
	public function verPost($post){
		$mysqli = $this->conectar->abrirConexion();
		$r = false;
		$SQL = "SELECT * FROM Post WHERE id = ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("i",$post);
		$ps->execute();
		$ps->store_result();
		if($ps->num_rows > 0){
			$r = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
	}
	
	#Ver post que me gustan
	public function verPostqueMegustan($tabla,$usuario){
		$posts = null;
		$mysqli = $this->conectar->abrirConexion();
		switch($tabla){
			case "concierto":
				$SQL = "SELECT v.post, v.nombre, v.artista, v.youtube, v.descripcion, v.imagen FROM Concierto v INNER JOIN MeGusta mg ON v.post = mg.post AND mg.usuario = ? ORDER BY mg.fecha DESC";
				$ps = $mysqli->prepare($SQL);
				$ps->bind_param("s",$usuario);
				$ps->execute();
				$ps->store_result();
				$ps->bind_result($nPost,$nNombre,$nArtista,$nYoutube,$nDescripcion,$nImagen);
				if($ps->num_rows > 0){
					$posts = array();
					while($ps->fetch()){
						$c = new Concierto();
						$c->setPost($nPost);
						$c->setNombre($nNombre);
						$c->setArtista($nArtista);
						$c->setYoutube($nYoutube);
						$c->setDescripcion($nDescripcion);
						$c->setImagen($nImagen);
						$posts[] = $c;
					}
				}
				$ps->free_result();
				$ps->close();
				$mysqli->close();
				break;
			case "disco":
				$SQL = "SELECT v.post, v.nombre, v.artista, v.descarga, v.linkCompra, v.descripcion, v.tracklist, v.imagen, v.imagenP FROM Disco v INNER JOIN MeGusta mg ON v.post = mg.post AND mg.usuario = ? ORDER BY mg.fecha DESC";
				$ps = $mysqli->prepare($SQL);
				$ps->bind_param("s",$usuario);
				$ps->execute();
				$ps->store_result();
				$ps->bind_result($nPost,$nNombre,$nArtista,$nDescarga,$nLinkCompra,$nDescripcion,$nTrackList,$nCaratula,$nImagenP);
				if($ps->num_rows > 0){
					$posts = array();
					while($ps->fetch()){
						$d = new Disco();
						$d->setPost($nPost);
						$d->setNombre($nNombre);
						$d->setArtista($nArtista);
						$d->setDescarga($nDescarga);
						$d->setLinkCompra($nLinkCompra);
						$d->setDescripcion($nDescripcion);
						$d->setTracklist($nTrackList);
						$d->setCaratula($nCaratula);
						$d->setImagenP($nImagenP);
						$posts[] = $d;
					}
				}
				$ps->free_result();
				$ps->close();
				$mysqli->close();
				break;
			case "libro":
				$SQL = "SELECT v.post, v.nombre, v.artista, v.descripcion, v.link, v.linkCompra, v.imagen, v.imagenP FROM Libro v INNER JOIN MeGusta mg ON v.post = mg.post AND mg.usuario = ? ORDER BY mg.fecha DESC";
				$ps = $mysqli->prepare($SQL);
				$ps->bind_param("s",$usuario);
				$ps->execute();
				$ps->store_result();
				$ps->bind_result($nPost,$nNombre,$nArtista,$nDescripcion,$nLink,$nLinkCompra,$nImagen,$nImagenP);
				if($ps->num_rows > 0){
					$posts = array();
					while($ps->fetch()){
						$l = new Libro();
						$l->setPost($nPost);
						$l->setNombre($nNombre);
						$l->setArtista($nArtista);
						$l->setDescripcion($nDescripcion);
						$l->setLink($nLink);
						$l->setLinkCompra($nLinkCompra);
						$l->setImagen($nImagen);
						$l->setImagenP($nImagenP);
						$posts[] = $l;
					}
				}
				$ps->free_result();
				$ps->close();
				$mysqli->close();
				break;
		}
		return $posts;
	}
	
	#Ver mas post que me gustan
	public function verMasPostqueMegustan($tabla,$usuario,$inicio){
		$posts = null;
		$mysqli = $this->conectar->abrirConexion();
		switch($tabla){
			case "concierto":
				$SQL = "SELECT v.post, v.nombre, v.artista, v.youtube, v.descripcion, v.imagen FROM Concierto v INNER JOIN MeGusta mg ON v.post = mg.post AND mg.usuario = ? ORDER BY mg.post DESC LIMIT ?,4";
				$ps = $mysqli->prepare($SQL);
				$ps->bind_param("si",$usuario,$inicio);
				$ps->execute();
				$ps->store_result();
				$ps->bind_result($nPost,$nNombre,$nArtista,$nYoutube,$nDescripcion,$nImagen);
				if($ps->num_rows > 0){
					$posts = array();
					while($ps->fetch()){
						$c = new Concierto();
						$c->setPost($nPost);
						$c->setNombre($nNombre);
						$c->setArtista($nArtista);
						$c->setYoutube($nYoutube);
						$c->setDescripcion($nDescripcion);
						$c->setImagen($nImagen);
						$posts[] = $c;
					}
				}
				$ps->free_result();
				$ps->close();
				$mysqli->close();
				break;
			case "disco":
				$SQL = "SELECT v.post, v.nombre, v.artista, v.descarga, v.linkCompra, v.descripcion, v.tracklist, v.imagen, v.imagenP FROM Disco v INNER JOIN MeGusta mg ON v.post = mg.post AND mg.usuario = ? ORDER BY mg.post DESC LIMIT ?,4";
				$ps = $mysqli->prepare($SQL);
				$ps->bind_param("si",$usuario,$inicio);
				$ps->execute();
				$ps->store_result();
				$ps->bind_result($nPost,$nNombre,$nArtista,$nDescarga,$nLinkCompra,$nDescripcion,$nTrackList,$nCaratula,$nImagenP);
				if($ps->num_rows > 0){
					$posts = array();
					while($ps->fetch()){
						$d = new Disco();
						$d->setPost($nPost);
						$d->setNombre($nNombre);
						$d->setArtista($nArtista);
						$d->setDescarga($nDescarga);
						$d->setLinkCompra($nLinkCompra);
						$d->setDescripcion($nDescripcion);
						$d->setTracklist($nTrackList);
						$d->setCaratula($nCaratula);
						$d->setImagenP($nImagenP);
						$posts[] = $d;
					}
				}
				$ps->free_result();
				$ps->close();
				$mysqli->close();
				break;
			case "libro":
				$SQL = "SELECT v.post, v.nombre, v.artista, v.descripcion, v.link, v.linkCompra, v.imagen, v.imagenP FROM Libro v INNER JOIN MeGusta mg ON v.post = mg.post AND mg.usuario = ? ORDER BY mg.post DESC LIMIT ?,4";
				$ps = $mysqli->prepare($SQL);
				$ps->bind_param("si",$artista,$inicio);
				$ps->execute();
				$ps->store_result();
				$ps->bind_result($nPost,$nNombre,$nArtista,$nDescripcion,$nLink,$nLinkCompra,$nImagen,$nImagenP);
				if($ps->num_rows > 0){
					$posts = array();
					while($ps->fetch()){
						$l = new Libro();
						$l->setPost($nPost);
						$l->setNombre($nNombre);
						$l->setArtista($nArtista);
						$l->setDescripcion($nDescripcion);
						$l->setLink($nLink);
						$l->setLinkCompra($nLinkCompra);
						$l->setImagen($nImagen);
						$l->setImagenP($nImagenP);
						$posts[] = $l;
					}
				}
				$ps->free_result();
				$ps->close();
				$mysqli->close();
				break;
		}
		return $posts;
	}
	
	#ver ultimos post de artistas que sigo
	public function verPostdeArtistasqueSigo($tabla,$usuario){
		$posts = null;
		$mysqli = $this->conectar->abrirConexion();
		switch($tabla){
			case "concierto":
				$SQL = "SELECT v.post, v.nombre, v.artista, v.youtube, v.descripcion, v.imagen FROM Concierto v INNER JOIN ArtistaUsuario au ON au.artista = v.artista and au.usuario = ? ORDER BY v.post DESC LIMIT 4";
				$ps = $mysqli->prepare($SQL);
				$ps->bind_param("s",$usuario);
				$ps->execute();
				$ps->store_result();
				$ps->bind_result($nPost,$nNombre,$nArtista,$nYoutube,$nDescripcion,$nImagen);
				if($ps->num_rows > 0){
					$posts = array();
					while($ps->fetch()){
						$c = new Concierto();
						$c->setPost($nPost);
						$c->setNombre($nNombre);
						$c->setArtista($nArtista);
						$c->setYoutube($nYoutube);
						$c->setDescripcion($nDescripcion);
						$c->setImagen($nImagen);
						$posts[] = $c;
					}
				}
				$ps->free_result();
				$ps->close();
				$mysqli->close();
				break;
			case "disco":
				$SQL = "SELECT v.post, v.nombre, v.artista, v.descarga, v.linkCompra, v.descripcion, v.tracklist, v.imagen, v.imagenP FROM Disco v INNER JOIN ArtistaUsuario au ON au.artista = v.artista and au.usuario = ? ORDER BY v.post DESC LIMIT 4";
				$ps = $mysqli->prepare($SQL);
				$ps->bind_param("s",$usuario);
				$ps->execute();
				$ps->store_result();
				$ps->bind_result($nPost,$nNombre,$nArtista,$nDescarga,$nLinkCompra,$nDescripcion,$nTrackList,$nCaratula,$nImagenP);
				if($ps->num_rows > 0){
					$posts = array();
					while($ps->fetch()){
						$d = new Disco();
						$d->setPost($nPost);
						$d->setNombre($nNombre);
						$d->setArtista($nArtista);
						$d->setDescarga($nDescarga);
						$d->setLinkCompra($nLinkCompra);
						$d->setDescripcion($nDescripcion);
						$d->setTracklist($nTrackList);
						$d->setCaratula($nCaratula);
						$d->setImagenP($nImagenP);
						$posts[] = $d;
					}
				}
				$ps->free_result();
				$ps->close();
				$mysqli->close();
				break;
			case "libro":
				$SQL = "SELECT v.post, v.nombre, v.artista, v.descripcion, v.link, v.linkCompra, v.imagen, v.imagenP FROM Libro v INNER JOIN ArtistaUsuario au ON au.artista = v.artista and au.usuario = ? ORDER BY v.post DESC LIMIT 4";
				$ps = $mysqli->prepare($SQL);
				$ps->bind_param("s",$usuario);
				$ps->execute();
				$ps->store_result();
				$ps->bind_result($nPost,$nNombre,$nArtista,$nDescripcion,$nLink,$nLinkCompra,$nImagen,$nImagenP);
				if($ps->num_rows > 0){
					$posts = array();
					while($ps->fetch()){
						$l = new Libro();
						$l->setPost($nPost);
						$l->setNombre($nNombre);
						$l->setArtista($nArtista);
						$l->setDescripcion($nDescripcion);
						$l->setLink($nLink);
						$l->setLinkCompra($nLinkCompra);
						$l->setImagen($nImagen);
						$l->setImagenP($nImagenP);
						$posts[] = $l;
					}
				}
				$ps->free_result();
				$ps->close();
				$mysqli->close();
				break;
		}
		return $posts;
	}
	
	#ver mas post de artistas que sigo
	public function verMasPostdeArtistasqueSigo($tabla,$usuario,$inicio){
		$posts = null;
		$mysqli = $this->conectar->abrirConexion();
		switch($tabla){
			case "concierto":
				$SQL = "SELECT v.post, v.nombre, v.artista, v.youtube, v.descripcion, v.imagen FROM Concierto v INNER JOIN ArtistaUsuario au ON au.artista = v.artista and au.usuario = ? ORDER BY v.post DESC LIMIT ?,4";
				$ps = $mysqli->prepare($SQL);
				$ps->bind_param("si",$usuario,$inicio);
				$ps->execute();
				$ps->store_result();
				$ps->bind_result($nPost,$nNombre,$nArtista,$nYoutube,$nDescripcion,$nImagen);
				if($ps->num_rows > 0){
					$posts = array();
					while($ps->fetch()){
						$c = new Concierto();
						$c->setPost($nPost);
						$c->setNombre($nNombre);
						$c->setArtista($nArtista);
						$c->setYoutube($nYoutube);
						$c->setDescripcion($nDescripcion);
						$c->setImagen($nImagen);
						$posts[] = $c;
					}
				}
				$ps->free_result();
				$ps->close();
				$mysqli->close();
				break;
			case "disco":
				$SQL = "SELECT v.post, v.nombre, v.artista, v.descarga, v.linkCompra, v.descripcion, v.tracklist, v.imagen, v.imagenP FROM Disco v INNER JOIN ArtistaUsuario au ON au.artista = v.artista and au.usuario = ? ORDER BY v.post DESC LIMIT ?,4";
				$ps = $mysqli->prepare($SQL);
				$ps->bind_param("si",$usuario,$inicio);
				$ps->execute();
				$ps->store_result();
				$ps->bind_result($nPost,$nNombre,$nArtista,$nDescarga,$nLinkCompra,$nDescripcion,$nTrackList,$nCaratula,$nImagenP);
				if($ps->num_rows > 0){
					$posts = array();
					while($ps->fetch()){
						$d = new Disco();
						$d->setPost($nPost);
						$d->setNombre($nNombre);
						$d->setArtista($nArtista);
						$d->setDescarga($nDescarga);
						$d->setLinkCompra($nLinkCompra);
						$d->setDescripcion($nDescripcion);
						$d->setTracklist($nTrackList);
						$d->setCaratula($nCaratula);
						$d->setImagenP($nImagenP);
						$posts[] = $d;
					}
				}
				$ps->free_result();
				$ps->close();
				$mysqli->close();
				break;
			case "libro":
				$SQL = "SELECT v.post, v.nombre, v.artista, v.descripcion, v.link, v.linkCompra, v.imagen, v.imagenP FROM Libro v INNER JOIN ArtistaUsuario au ON au.artista = v.artista and au.usuario = ? ORDER BY v.post DESC LIMIT ?,4";
				$ps = $mysqli->prepare($SQL);
				$ps->bind_param("si",$usuario,$inicio);
				$ps->execute();
				$ps->store_result();
				$ps->bind_result($nPost,$nNombre,$nArtista,$nDescripcion,$nLink,$nLinkCompra,$nImagen,$nImagenP);
				if($ps->num_rows > 0){
					$posts = array();
					while($ps->fetch()){
						$l = new Libro();
						$l->setPost($nPost);
						$l->setNombre($nNombre);
						$l->setArtista($nArtista);
						$l->setDescripcion($nDescripcion);
						$l->setLink($nLink);
						$l->setLinkCompra($nLinkCompra);
						$l->setImagen($nImagen);
						$l->setImagenP($nImagenP);
						$posts[] = $l;
					}
				}
				$ps->free_result();
				$ps->close();
				$mysqli->close();
				break;
		}
		return $posts;
	}
	
	#ver cantidad de MG de un post
	public function countmg($post){
		$r = null;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "SELECT COUNT(*) FROM megusta WHERE post = ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("i",$post);
		$ps->execute();
		$ps->bind_result($cant);
		$ps->fetch();
		$r = $cant;
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
	}
	
	#Ver Cantidad de Comentarios de un post
	public function countcomentarios($post){
		$r = null;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "SELECT COUNT(*) FROM Comentario WHERE post = ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("i",$post);
		$ps->execute();
		$ps->bind_result($cant);
		$ps->fetch();
		$r = $cant;
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
	}
	
	
	#Ver Últimos Post de un artista
	public function verUltimosPost($tabla,$artista){
		$posts = null;
		$mysqli = $this->conectar->abrirConexion();
		switch($tabla){
			case "concierto":
				$SQL = "SELECT * FROM Concierto WHERE artista = ? ORDER BY post DESC LIMIT 4";
				if($artista == null){
					$SQL = "SELECT * FROM Concierto ORDER BY post DESC LIMIT 4";
				}
				$ps = $mysqli->prepare($SQL);
				if($artista != null){
					$ps->bind_param("s",$artista);
				}
				$ps->execute();
				$ps->store_result();
				$ps->bind_result($nPost,$nNombre,$nArtista,$nYoutube,$nDescripcion,$nImagen);
				if($ps->num_rows > 0){
					$posts = array();
					while($ps->fetch()){
						$c = new Concierto();
						$c->setPost($nPost);
						$c->setNombre($nNombre);
						$c->setArtista($nArtista);
						$c->setYoutube($nYoutube);
						$c->setDescripcion($nDescripcion);
						$c->setImagen($nImagen);
						$posts[] = $c;
					}
				}
				$ps->free_result();
				$ps->close();
				$mysqli->close();
				break;
			case "disco":
				$SQL = "SELECT * FROM Disco WHERE artista = ? ORDER BY post DESC LIMIT 4";
				if($artista == null){
					$SQL = "SELECT * FROM Disco ORDER BY post DESC LIMIT 4";
				}
				$ps = $mysqli->prepare($SQL);
				if($artista!=null){
					$ps->bind_param("s",$artista);
				}
				$ps->execute();
				$ps->store_result();
				$ps->bind_result($nPost,$nNombre,$nArtista,$nDescarga,$nLinkCompra,$nDescripcion,$nTrackList,$nCaratula,$nImagenP);
				if($ps->num_rows > 0){
					$posts = array();
					while($ps->fetch()){
						$d = new Disco();
						$d->setPost($nPost);
						$d->setNombre($nNombre);
						$d->setArtista($nArtista);
						$d->setDescarga($nDescarga);
						$d->setLinkCompra($nLinkCompra);
						$d->setDescripcion($nDescripcion);
						$d->setTracklist($nTrackList);
						$d->setCaratula($nCaratula);
						$d->setImagenP($nImagenP);
						$posts[] = $d;
					}
				}
				$ps->free_result();
				$ps->close();
				$mysqli->close();
				break;
			case "libro":
				$SQL = "SELECT * FROM Libro WHERE artista = ? ORDER BY post DESC LIMIT 4";
				if($artista == null){
					$SQL = "SELECT * FROM Libro ORDER BY post DESC LIMIT 4";
				}
				$ps = $mysqli->prepare($SQL);
				if($artista != null){
					$ps->bind_param("s",$artista);
				}
				$ps->execute();
				$ps->store_result();
				$ps->bind_result($nPost,$nNombre,$nArtista,$nDescripcion,$nLink,$nLinkCompra,$nImagen,$nImagenP);
				if($ps->num_rows > 0){
					$posts = array();
					while($ps->fetch()){
						$l = new Libro();
						$l->setPost($nPost);
						$l->setNombre($nNombre);
						$l->setArtista($nArtista);
						$l->setDescripcion($nDescripcion);
						$l->setLink($nLink);
						$l->setLinkCompra($nLinkCompra);
						$l->setImagen($nImagen);
						$l->setImagenP($nImagenP);
						$posts[] = $l;
					}
				}
				$ps->free_result();
				$ps->close();
				$mysqli->close();
				break;
		}
		return $posts;
	}
	
	#Ver más posts de un artista
	public function verMasPosts($tabla,$artista,$inicio){
		$posts = null;
		$mysqli = $this->conectar->abrirConexion();
		switch($tabla){
			case "concierto":
				$SQL = "SELECT * FROM Concierto WHERE artista = ? ORDER BY post DESC LIMIT ?,4";
				if($artista == null){
					$SQL = "SELECT * FROM Concierto ORDER BY post DESC LIMIT ?,4";
				}
				$ps = $mysqli->prepare($SQL);
				if($artista == null){
					$ps->bind_param("i",$inicio);
				}
				else{
					$ps->bind_param("si",$artista,$inicio);
				}
				$ps->execute();
				$ps->store_result();
				$ps->bind_result($nPost,$nNombre,$nArtista,$nYoutube,$nDescripcion,$nImagen);
				if($ps->num_rows > 0){
					$posts = array();
					while($ps->fetch()){
						$c = new Concierto();
						$c->setPost($nPost);
						$c->setNombre($nNombre);
						$c->setArtista($nArtista);
						$c->setYoutube($nYoutube);
						$c->setDescripcion($nDescripcion);
						$c->setImagen($nImagen);
						$posts[] = $c;
					}
				}
				$ps->free_result();
				$ps->close();
				$mysqli->close();
				break;
			case "disco":
				$SQL = "SELECT * FROM Disco WHERE artista = ? ORDER BY post DESC LIMIT ?,4";
				if($artista == null){
					$SQL = "SELECT * FROM Disco ORDER BY post DESC LIMIT ?,4";
				}
				$ps = $mysqli->prepare($SQL);
				if($artista == null){
					$ps->bind_param("i",$inicio);
				}
				else{
					$ps->bind_param("si",$artista,$inicio);
				}
				$ps->execute();
				$ps->store_result();
				$ps->bind_result($nPost,$nNombre,$nArtista,$nDescarga,$nLinkCompra,$nDescripcion,$nTrackList,$nCaratula,$nImagenP);
				if($ps->num_rows > 0){
					$posts = array();
					while($ps->fetch()){
						$d = new Disco();
						$d->setPost($nPost);
						$d->setNombre($nNombre);
						$d->setArtista($nArtista);
						$d->setDescarga($nDescarga);
						$d->setLinkCompra($nLinkCompra);
						$d->setDescripcion($nDescripcion);
						$d->setTracklist($nTrackList);
						$d->setCaratula($nCaratula);
						$d->setImagenP($nImagenP);
						$posts[] = $d;
					}
				}
				$ps->free_result();
				$ps->close();
				$mysqli->close();
				break;
			case "libro":
				$SQL = "SELECT * FROM Libro WHERE artista = ? ORDER BY post DESC LIMIT ?,4";
				if($artista == null){
					$SQL = "SELECT * From Libro ORDER BY post DESC LIMIT ?,4";
				}
				$ps = $mysqli->prepare($SQL);
				if($artista == null){
					$ps->bind_param("i",$inicio);
				}
				else{
					$ps->bind_param("si",$artista,$inicio);
				}
				$ps->execute();
				$ps->store_result();
				$ps->bind_result($nPost,$nNombre,$nArtista,$nDescripcion,$nLink,$nLinkCompra,$nImagen,$nImagenP);
				if($ps->num_rows > 0){
					$posts = array();
					while($ps->fetch()){
						$l = new Libro();
						$l->setPost($nPost);
						$l->setNombre($nNombre);
						$l->setArtista($nArtista);
						$l->setDescripcion($nDescripcion);
						$l->setLink($nLink);
						$l->setLinkCompra($nLinkCompra);
						$l->setImagen($nImagen);
						$l->setImagenP($nImagenP);
						$posts[] = $l;
					}
				}
				$ps->free_result();
				$ps->close();
				$mysqli->close();
				break;
		}
		return $posts;
	}
	
	#Ver Evento
	public function verEvento($evento){
		$e = null;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "SELECT * FROM Evento WHERE id = ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("i",$evento);
		$ps->execute();
		$ps->store_result();
		$ps->bind_result($nId,$nTitulo,$nArtistas,$nFecha,$nHora,$nLugar,$nPrecio,$nLink,$nInformacion,$nAfiche);
		if($ps->num_rows > 0){
			$ps->fetch();
			$e = new Evento();
			$e->setId($nId);
			$e->setTitulo($nTitulo);
			$e->setArtistas($nArtistas);
			$e->setFecha($nFecha);
			$e->setHora($nHora);
			$e->setLugar($nLugar);
			$e->setPrecio($nPrecio);
			$e->setLink($nLink);
			$e->setInformacion($nInformacion);
			$e->setAfiche($nAfiche);
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $e;
	}
	
	#Ver ultimos 4 eventos
	public function verUltimos4Eventos(){
		$eventos = null;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "SELECT * FROM Evento ORDER BY id DESC LIMIT 4";
		$ps = $mysqli->prepare($SQL);
		$ps->execute();
		$ps->store_result();
		$ps->bind_result($nId,$nTitulo,$nArtistas,$nFecha,$nHora,$nLugar,$nPrecio,$nLink,$nInformacion,$nAfiche);
		if($ps->num_rows > 0){
			$eventos = array();
			while($ps->fetch()){
				$e = new Evento();
				$e->setId($nId);
				$e->setTitulo($nTitulo);
				$e->setArtistas($nArtistas);
				$e->setFecha($nFecha);
				$e->setHora($nHora);
				$e->setLugar($nLugar);
				$e->setPrecio($nPrecio);
				$e->setLink($nLink);
				$e->setInformacion($nInformacion);
				$e->setAfiche($nAfiche);
				$eventos[] = $e;
			}
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $eventos;
	}
	
	#Ver todos los próximos eventos
	public function verUltimosProximosEventos(){
		$eventos = null;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "SELECT * FROM Evento ORDER BY id DESC";
		$ps = $mysqli->prepare($SQL);
		$ps->execute();
		$ps->store_result();
		$ps->bind_result($nId,$nTitulo,$nArtistas,$nFecha,$nHora,$nLugar,$nPrecio,$nLink,$nInformacion,$nAfiche);
		if($ps->num_rows > 0){
			$eventos = array();
			while($ps->fetch()){
				$e = new Evento();
				$e->setId($nId);
				$e->setTitulo($nTitulo);
				$e->setArtistas($nArtistas);
				$e->setFecha($nFecha);
				$e->setHora($nHora);
				$e->setLugar($nLugar);
				$e->setPrecio($nPrecio);
				$e->setLink($nLink);
				$e->setInformacion($nInformacion);
				$e->setAfiche($nAfiche);
				$eventos[] = $e;
			}
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $e;
	}
	
	#Ver eventos que asistiré
	public function verEventosqueAsistire($usuario){
		$eventos = null;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "SELECT e.id, e.titulo, e.fecha, e.hora, e.afiche FROM Evento e INNER JOIN AsistirEvento ae ON ae.evento = e.id AND ae.usuario = ? ORDER BY e.id DESC";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("s",$usuario);
		$ps->execute();
		$ps->store_result();
		if($ps->num_rows > 0){
			$eventos = array();
			$ps->bind_result($id,$titulo,$fecha,$hora,$afiche);
			while($ps->fetch()){
				$e = new Evento();
				$e->setId($id);
				$e->setTitulo($titulo);
				$e->setFecha($fecha);
				$e->setHora($hora);
				$e->setAfiche($afiche);
				$eventos[] = $e;
			}
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $eventos;
	}
	
	#Ver quienes asistiran a evento
	public function verAsistentesEvento($evento){
		$res = null;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "SELECT usuario FROM AsistirEvento WHERE evento = ? ";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("i",$evento);
		$ps->execute();
		$ps->store_result();
		if($ps->num_rows > 0){
			$res = array();
			$ps->bind_result($user);
			while($ps->fetch()){
				$res[] = $user;
			}
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $res;
		
	}
	
	#Asistir a Evento
	public function asistirEvento($usuario,$evento){
		$r = false;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "INSERT INTO AsistirEvento(usuario,evento) VALUES(?,?)";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("si",$usuario,$evento);
		if($ps->execute()){
			$r = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
	}
	
	#No asistir a Evento
	public function noAsistirEvento($usuario,$evento){
		$r = false;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "DELETE FROM AsistirEvento WHERE usuario = ? AND evento = ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("si",$usuario,$evento);
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
	
	#Ver si asisto al evento
	public function asistoAlEvento($usuario,$evento){
		$r = false;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "SELECT * FROM AsistirEvento WHERE usuario = ? AND evento = ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("si",$usuario,$evento);
		$ps->execute();
		$ps->store_result();
		if($ps->num_rows > 0){
			$r = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
	}
	
	#Ver un Concierto
	public function verConcierto($post){
		$r = false;
		if($this->verPost($post)){
			$r = null;
			$mysqli = $this->conectar->abrirConexion();
			$SQL = "SELECT * FROM Concierto WHERE post = ?";
			$ps = $mysqli->prepare($SQL);
			$ps->bind_param("i",$post);
			$ps->execute();
			$ps->store_result();
			$ps->bind_result($nPost,$nNombre,$nArtista,$nYoutube,$nDescripcion,$nImagen);
			if($ps->num_rows > 0){
				$ps->fetch();
				$r = new Concierto();
				$r->setPost($nPost);
				$r->setNombre($nNombre);
				$r->setArtista($nArtista);
				$r->setYoutube($nYoutube);
				$r->setDescripcion($nDescripcion);
				$r->setImagen($nImagen);
			}
			$ps->free_result();
			$ps->close();
			$mysqli->close();
			
		}
		return $r;
	}
	
	#Ver un Disco
	public function verDisco($post){
		$r = false;
		if($this->verPost($post)){
			$r = null;
			$mysqli = $this->conectar->abrirConexion();
			$SQL = "SELECT * FROM Disco WHERE post = ?";
			$ps = $mysqli->prepare($SQL);
			$ps->bind_param("i",$post);
			$ps->execute();
			$ps->store_result();
			$ps->bind_result($nPost,$nNombre,$nArtista,$nDescarga,$nLinkCompra,$nDescripcion,$nTracklist,$nCaratula,$nImagenP);
			if($ps->num_rows > 0){
				$ps->fetch();
				$r = new Disco();
				$r->setPost($nPost);
				$r->setNombre($nNombre);
				$r->setArtista($nArtista);
				$r->setDescarga($nDescarga);
				$r->setLinkCompra($nLinkCompra);
				$r->setDescripcion($nDescripcion);
				$r->setTracklist($nTracklist);
				$r->setCaratula($nCaratula);
				$r->setImagenP($nImagenP);
			}
			$ps->free_result();
			$ps->close();
			$mysqli->close();
		}
		return $r;
	}
	
	#Ver un Libro
	public function verLibro($post){
		$r = false;
		if($this->verPost($post)){
			$r = null;
			$mysqli = $this->conectar->abrirConexion();
			$SQL = "SELECT * FROM Libro WHERE post = ?";
			$ps = $mysqli->prepare($SQL);
			$ps->bind_param("i",$post);
			$ps->execute();
			$ps->store_result();
			$ps->bind_result($nPost,$nNombre,$nArtista,$nDescripcion,$nLink,$nLinkCompra,$nImagen,$nImagenP);
			if($ps->num_rows > 0){
				$ps->fetch();
				$r = new Libro();
				$r->setPost($nPost);
				$r->setNombre($nNombre);
				$r->setArtista($nArtista);
				$r->setDescripcion($nDescripcion);
				$r->setLink($nLink);
				$r->setLinkCompra($nLinkCompra);
				$r->setImagen($nImagen);
				$r->setImagenP($nImagenP);
			}
			$ps->free_result();
			$ps->close();
			$mysqli->close();
		}
		return $r;
	}
	
	#Ver si le gusta un post
	public function doILikeit($usuario,$post){
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "SELECT * FROM megusta WHERE usuario = ? AND post = ?";
		$ps = $mysqli->prepare($SQL);
		$ilike = false;
		$ps->bind_param("si",$usuario,$post);
		$ps->execute();
		$ps->store_result();
		if($ps->num_rows > 0){
			$ilike = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $ilike;
	}
	
	#Establecer que me gusta un post
	public function meGusta($usuario,$post){
		$mysqli = $this->conectar->abrirConexion();
		$res = false;
		$SQL = "INSERT INTO MeGusta(usuario,post) VALUES(?,?)";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("si",$usuario,$post);
		if($ps->execute()){
			$res = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $res;
		
	}
	
	#Hacer que un post no me guste
	public function noMeGusta($usuario,$post){
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "DELETE FROM MeGusta WHERE usuario = ? AND post = ?";
		$ps = $mysqli->prepare($SQL);
		$res = false;
		$ps->bind_param("si",$usuario,$post);
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
	
	
	#Agregar Comentario
	public function addComentario($c){
		$r = false;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "INSERT INTO Comentario(usuario,post,fecha,comentario) VALUES(?,?,?,?)";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("siss",$c->getUsuario(),$c->getPost(),$c->getFecha(),$c->getComentario());
		if($ps->execute()){
			$r = true;
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $r;
	}
	
	#Ver Comentarios de un Post
	public function verComentariosPost($post){
		$comentarios = null;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "SELECT * FROM Comentario WHERE post = ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("i",$post);
		$ps->execute();
		$ps->store_result();
		$ps->bind_result($nId,$nUsuario,$nPost,$nFecha,$nComentario);
		if($ps->num_rows > 0){
			$comentarios = array();
			while($ps->fetch()){
				$c = new Comentario();
				$c->setId($nId);
				$c->setUsuario($nUsuario);
				$c->setPost($nPost);
				$c->setFecha($nFecha);
				$c->setComentario($nComentario);
				$comentarios[] = $c;
			}
		}
		$ps->free_result();
		$ps->close();
		$mysqli->close();
		return $comentarios;
	}
	
	public function eliminarComentario($id){
		$res = false;
		$mysqli = $this->conectar->abrirConexion();
		$SQL = "DELETE FROM Comentario WHERE id = ?";
		$ps = $mysqli->prepare($SQL);
		$ps->bind_param("i",$id);
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
	
}
?>