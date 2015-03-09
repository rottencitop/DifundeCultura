<?php
define(__ROOT__,dirname(dirname(__FILE__)));
#Importamos las clases necesarias
require_once(__ROOT__.'/Entidades/Usuario.php');
require_once(__ROOT__.'/Entidades/Artista.php');
require_once(__ROOT__.'/Entidades/Recomendacion.php');
require_once(__ROOT__.'/Entidades/Disco.php');
require_once(__ROOT__.'/Entidades/Concierto.php');
require_once(__ROOT__.'/Entidades/Evento.php');
require_once(__ROOT__.'/Entidades/Libro.php');
require_once(__ROOT__.'/Entidades/Error.php');
require_once(__ROOT__.'/Entidades/Comentario.php');
require_once(__ROOT__.'/DAL/AdminDAL.php');
require_once(__ROOT__.'/DAL/ArtistaDAL.php');
require_once(__ROOT__.'/controller/FuncionesC.php');

class AdminC{
	
	private $ad;
	private $fc;
	private $ard;
	
	
	function __construct(){
		$this->ad = new AdminDAL();
		$this->fc = new FuncionesC();
		$this->ard = new ArtistaDAL();
	}
	
	#Ver todas las recomendaciones
	public function verRecomendacion(){
		return $this->ad->verRecomendaciones();
	}
	
	#Ver errores de Conciertos
	public function verErroresdeConciertos(){
		return $this->ad->verErrores("concierto");
	}
	
	#Ver errores de Discos
	public function verErroresdeDiscos(){
		return $this->ad->verErrores("disco");
	}
	
	#Ver errores de Libros
	public function verErroresdeLibros(){
		return $this->ad->verErrores("libro");
	}
	
	#Ver todos los usuarios
	public function verTodoslosUsuarios(){
		return $this->ad->verUsuarios();
	}
	
	public function verArtistasdeTipo($tipo){
		return $this->ard->verArtistadeTipo($tipo);
	}
	
	public function agregarArtista($nombre,$resena,$web,$facebook,$twitter,$wiki,$sc,$imagenes,$generos,$tipos){
		$r = false;
		$a = new Artista();
		$a->setNombre($nombre);
		$a->setResena($resena);
		$a->setWeb($web);
		$a->setFacebook($facebook);
		$a->setTwitter($twitter);
		$a->setWiki($wiki);
		$a->setSoundcloud($sc);
		if($this->ad->addArtista($a)){
			if($this->agregarImagenesArtista($nombre,$imagenes)){
				if($this->agregarGenerosArtista($nombre,$generos)){
					if($this->agregarTiposArtista($nombre,$tipos)){
						$r = 1;
					}else{
						$r = -4;
					}
				}else{
					$r = -3;
				}
			}else{
				$r = -2;
			}
		}else{
			$r = -1;
		}
		return $r;
	}
	
	private function agregarTiposArtista($artista,$tipos){
		foreach($tipos as $tipo){
			if(!$this->ad->addTipoArtista($artista,$tipo)){
				return false;
			}
		}
		return true;
	}
	
	private function agregarGenerosArtista($artista,$generos){
		foreach($generos as $genero){
			if(!$this->ad->addGeneroArtista($artista,$genero)){
				return false;
			}
		}
		return true;
	}
	
	private function agregarImagenesArtista($artista,$imagenes){
		foreach($imagenes as $imagen){
			if(!$this->ad->addImagenArtista($artista,$this->fc->subirIMG($imagen))){
				return false;
			}
		}
		return true;
	}
	
	#agregar genero
	public function addGenero($genero){
		return $this->ad->addGenero($genero);
	}
	
	public function verGeneros(){
		return $this->ad->verGeneros();
	}
	
	public function agregarConcierto($nombre,$artista,$youtube,$descripcion,$imagen){
		$r = null;
		$c = new Concierto();
		$c->setNombre($nombre);
		$c->setArtista($artista);
		$c->setYoutube($this->fc->limpiarYT($youtube));
		$c->setDescripcion($descripcion);
		$c->setImagen($this->fc->subirIMG($imagen));
		$res = $this->ad->addConcierto($c);
		if($res){
			$r = 1;
		}
		elseif(!$res){
			$r = -1;
		}
		return $r;
	}
	
	public function agregarDisco($nombre,$artista,$descarga,$linkCompra,$descripcion,$tracklist,$imagen,$imagenp){
		$r = null;
		$d = new Disco();
		$d->setNombre($nombre);
		$d->setArtista($artista);
		$d->setDescarga($descarga);
		$d->setLinkCompra($linkCompra);
		$d->setDescripcion($descripcion);
		$d->setTracklist($tracklist);
		$d->setCaratula($this->fc->subirIMG($imagen));
		$d->setImagenP($this->fc->subirIMG($imagenp));
		$res = $this->ad->addDisco($d);
		if($res){
			$r = 1;
		}
		elseif(!$res){
			$r = -1;
		}
		return $r;
	}
	
	
	public function agregarLibro($nombre,$artista,$descripcion,$link,$linkCompra,$imagen,$imagenp){
		$r = null;
		$l = new Libro();
		$l->setNombre($nombre);
		$l->setArtista($artista);
		$l->setDescripcion($descripcion);
		$l->setLink($link);
		$l->setLinkCompra($linkCompra);
		$l->setImagen($this->fc->subirIMG($imagen));
		$l->setImagenP($this->fc->subirIMG($imagenp));
		$res = $this->ad->addLibro($l);
		if($res){
			$r = 1;
		}
		elseif(!$res){
			$r = -1;
		}
		return $r;	
	}
	
	public function eliminarPost($post){
		return $this->ad->eliminarPost($post);
	}
	
	public function agregarEvento($titulo,$artistas,$fecha,$hora,$lugar,$precio,$link,$informacion,$afiche){
		$r = null;
		$e = new Evento();
		$e->setTitulo($titulo);
		$e->setArtistas($artistas);
		$e->setFecha($fecha);
		$e->setHora($hora);
		$e->setLugar($lugar);
		$e->setPrecio($precio);
		$e->setLink($link);
		$e->setInformacion($informacion);
		$e->setAfiche($this->fc->subirIMG($afiche));
		$res = $this->ad->addEvento($e);
		if($res){
			$r = 1;
		}
		elseif(!$res){
			$r = -1;
		}
		return $r;	
	}
	
	public function eliminarEvento($id){
		return $this->ad->eliminarEvento($id);
	}
	
	public function verUsuarios(){
		return $this->ad->verUsuarios();
	}
	
	public function verRecomendaciones(){
		return $this->ad->verRecomendaciones();
	}
	
	public function eliminarRecomendacion($id){
		return $this->ad->eliminarRecomendacion($id);
	}
	
	public function eliminarError($id){
		return $this->ad->eliminarError($id);
	}
	
	#Eliminar comentario
	public function eliminarComentario($id){
		return $this->ad->eliminarComentario($id);
	}
	
}
?>