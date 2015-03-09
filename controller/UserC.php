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
require_once(__ROOT__.'/DAL/UsuarioDAL.php');
require_once(__ROOT__.'/DAL/ArtistaDAL.php');
require_once(__ROOT__.'/DAL/PostDAL.php');
require_once(__ROOT__.'/controller/FuncionesC.php');
require_once(__ROOT__.'/fb/facebook.php');

class UserC{
	private $ud;
	private $ad;
	private $fc;
	private $pd;
	private $fb;
	
	function __construct(){
		$this->ad = new ArtistaDAL();
		$this->ud = new UsuarioDAL();
		$this->fc = new FuncionesC();
		$this->pd = new PostDAL();
	}
	
	public function urlActual(){
		$url="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
		return $url;
	}
	public function buscarArtista($palabra){
		return $this->ad->buscarArtista($palabra);
	}
	//-----------------------------------------------------------------Concierto
	#Buscar posts por Genero
	public function buscarPostsporGenero($tabla,$genero){
		return $this->pd->verPostPorGeneros($tabla,$genero);
	}
	
	#Buscar Posts por letra
	public function buscarPostsPorLetra($tabla,$letra){
		return $this->pd->verPostporABC($tabla,$letra);
	}
	
	#Ver 10 conciertos mas populares
	public function verConciertosMasPopulares(){
		return $this->pd->verConciertosMasPopulares();
	}
	
	#Ver un concierto
	public function verConcierto($post){
		$c = null;
		if(is_int($post)){
			$c = $this->pd->verConcierto($post);
		}
		return $c;
	}
	
	#Ver ultimos Concierto de un Artista
	public function VerUltimosConciertosDeUnArtista($artista){
		return $this->pd->verUltimosPost("concierto",$artista);
	}
	
	#Ver ultimos conciertos(4)
	public function verUltimosConciertos(){
		return $this->pd->verUltimosPost("concierto",NULL);
	}
	
	#Ver mas conciertos
	public function verMasUltimosConciertos($inicio){
		return $this->pd->verMasPosts("concierto",NULL,$inicio);
	}
	
	#Ver comentarios de un Post
	public function verComentariosdeunPost($fb,$post){
		$comments = array();
		$res = array();
		$co =  $this->pd->verComentariosPost($post);
		$coid = array();
		foreach($co as $c){
			$coid[] = $c->getUsuario();
		}
		$perfiles = $fb->verPerfilesdeUsuariosComentarios($coid);
		$i = 0;
		foreach($coid as $c){
			$comments[] = array("comentario" => $co[$i], "perfil" => $perfiles[$i]);
			$i++;
		}
		$res = array();
		foreach($comments as $c){
			$res[] = array("id" => $c['comentario']->getId(), "fecha" => date('d-m-Y',strtotime($c['comentario']->getFecha())), 
							"comentario" => $c['comentario']->getComentario(),
							"nombre" => $c['perfil']['name'], "link" => $c['perfil']['link'],
							"imagen" => $c['perfil']['picture']['data']['url']);
		}
		
		return $res;
	}
	
	#Ver ultimos 4 eventos
	public function verUltimosEventos(){
		return $this->pd->verUltimos4Eventos();
	}
	
	#Ver un evento
	public function verEvento($post){
		$e=null;
		if(is_int($post)){
			$e = $this->pd->verEvento($post);
		}
		return $e;
	}
	
	#Ver un artista
	public function verArtista($artista){
		$artistas = $this->ad->verArtistas();
		foreach($artistas as $a){
			if($artista == $this->fc->urls_amigables($a->getNombre())){
				return $a;
			}
		}
		return null;
	}
	
	#Ver las imagenes de un artista
	public function verImagenesArtista($artista){
		return $this->ad->verImagenesArtista($artista);
	}
	
	#Ver generos de artista
	public function verGenerosArtista($artista){
		return $this->ad->verGenerosdeArtista($artista);
	}
	
	#Ver Generos de artista
	public function verTipoArtista($artista){
		return $this->ad->verTipoArtedeArtista($artista);
	}
	
	#Ver todos los generos
	public function verGeneros(){
		return $this->ud->verGeneros();
	}
	
	
	
	#Ver un Disco
	public function verDisco($post){
		$d = null;
		if(is_int($post)){
			$d = $this->pd->verDisco($post);
		}
		return $d;
	}
	
	
	#Ver un Libro
	public function verLibro($post){
		$l = null;
		if(is_int($post)){
			$l = $this->pd->verLibro($post);
		}
		return $l;
	}
	
	
	
	#Ver mas posts de un artista
	public function verMasPostdeArtista($tabla,$artista,$inicio){
		$r = null;
		switch($tabla){
			case 1:
				$r = $this->pd->verMasPosts("concierto",$artista,$inicio);
				break;
			case 2:
				$r = $this->pd->verMasPosts("disco",$artista,$inicio);
				break;
			case 3:
				$r = $this->pd->verMasPosts("libro",$artista,$inicio);
				break;		
		}
		return $r;
	}
	
	#Ver si el artista tiene mas posts
	public function verSiArtistaTieneMasPosts($tabla,$artista,$inicio){
		$r = null;
		switch($tabla){
			case 1:
				$r = $this->pd->verMasPosts("concierto",$artista,$inicio);
				break;
			case 2:
				$r = $this->pd->verMasPosts("disco",$artista,$inicio);
				break;
			case 3:
				$r = $this->pd->verMasPosts("libro",$artista,$inicio);
				break;		
		}
		$res = false;
		if(!is_null($r)){
			$res = true;
		}
		return $res;
	}
	
	#Ver si hay mas posts
	public function verSiHayMasPosts($tabla,$artista,$inicio){
		$r = null;
		switch($tabla){
			case 1:
				$r = $this->pd->verMasPosts("concierto",$artista,$inicio);
				break;
			case 2:
				$r = $this->pd->verMasPosts("disco",$artista,$inicio);
				break;
			case 3:
				$r = $this->pd->verMasPosts("libro",$artista,$inicio);
				break;		
		}
		$res = false;
		if(!is_null($r)){
			$res = true;
		}
		return $res;
	}
	
	
	
	#Ver ultimos discos(4)
	public function verUltimosDiscos(){
		return $this->pd->verUltimosPost("disco",NULL);
	}
	
	#Ver mas ultimos discos
	public function verMasUltimosDiscos($inicio){
		return $this->pd->verMasPosts("disco",NULL,$inicio);
	}
	
	
	#Ver mas ultimos libros
	public function verMasUltimosLibros($inicio){
		return $this->pd->verMasPosts("libro",NULL,$inicio);
	}
	
	#Ver ultimos discos de un artista(4)
	public function verUltimosDiscosdeunArtista($artista){
		return $this->pd->verUltimosPost("disco",$artista);
	}
	
	
	#Ver ultimos libros(4)
	public function verUltimosLibros(){
		return $this->pd->verUltimosPost("libro",NULL);
	}
	
	#Ver ultimos libros de un artista(4)
	public function verUltimosLibrosdeunArtista($artista){
		return $this->pd->verUltimosPost("libro",$artista);
	}
	
	#Mostrar cantidad de Me Gusta de un Post
	public function contarMGdePost($post){
		return $this->pd->countmg($post);
	}
	
	#Mostrar cantidad de comentarios de un post
	public function contarComentarios($post){
		return $this->pd->countcomentarios($post);
	}
	
	#Agregar comentario
	public function agregarComentario($usuario,$post,$fecha,$comentario){
		$c = new Comentario();
		$c->setUsuario($usuario);
		$c->setPost($post);
		$c->setFecha($fecha);
		$c->setComentario($comentario);
		return $this->pd->addComentario($c);
	}
	
	#Genera url amigable para un post
	public function generarURLPost($obj){
		$url = $obj->getPost().' '.$obj->getArtista().' '.$obj->getNombre();
		$nUrl = $this->fc->urls_amigables($url).'.html';
		return $nUrl;
	}
	
	#Genera Url amigable para un artista
	public function generarURLArtista($obj){
		$nUrl = $this->fc->urls_amigables($obj->getArtista()).'.html';
		return $nUrl;
	}
	
	#Genera Url amigable para un artista
	public function generarURLArtista2($palabra){
		$nUrl = $this->fc->urls_amigables($palabra).'.html';
		return $nUrl;
	}
	
	#Generar Url amigable para evento
	public function generarURLEvento($obj){
		$nUrl = $this->fc->urls_amigables($obj->getId().' '.$obj->getTitulo()).'.html';
		return $nUrl;
	}
	
	#Agregar error
	public function agregarError($usuario,$mensaje,$post){
		$e = new Error();
		$e->setPost($post);
		$e->setUsuario($usuario);
		$e->setMensaje($mensaje);
		return $this->ud->addError($e);
	}
	
	
	#Ver si está en la BD
	public function isInBD($uid){
		return $this->ud->verUsuario($uid);
	}
	
	#obtener usuario de la BD
	public function getUserBD($uid){
		return $this->ud->verUsuario($uid);
	}
	
	#Insertar Usuario en la BD
	public function insertUserFB($uid){
		$u = new User();
		$u->setUid($uid);
		$u->setTipo(2);
		return $this->ud->insertarUsuario($u);
	}
	
	#Ver si me gusta un post
	public function verSiMegustaelPost($uid,$post){
		return $this->pd->doILikeit($uid,$post);
	}
	
	#Marcar me gusta
	public function setMeGusta($uid,$post){
		settype($post,"int");
		return $this->pd->meGusta($uid,$post);
	}
	
	#Marcar no me gusta
	public function setNoMeGusta($uid,$post){
		settype($post,"int");
		return $this->pd->noMeGusta($uid,$post);
	}
	
	#Ver si sigo al artista
	public function sigoAlArtista($artista,$usuario){
		return $this->ad->sigoAlArtista($usuario,$artista);
	}
	
	#Seguir a un artista
	public function seguiraArtista($usuario,$artista){
		return $this->ad->seguirArtista($usuario,$artista);
	}
	
	#No seguir artista
	public function noSeguiraArtista($usuario,$artista){
		return $this->ad->noSeguirArtista($usuario,$artista);
	}
	
	#Ver conciertos de artistas que sigo
	public function conciertosDeArtistasqueSigo($usuario){
		return $this->pd->verPostdeArtistasqueSigo("concierto",$usuario);
	}
	
	#Ver discos de aristas que sigo
	public function discosDeArtistasqueSigo($usuario){
		return $this->pd->verPostdeArtistasqueSigo("disco",$usuario);
	}
	
	#Ver libros de artistas que sigo
	public function librosDeArtistasqueSigo($usuario){
		return $this->pd->verPostdeArtistasqueSigo("libro",$usuario);
	}
	
	#Ver si hay mas post de artistas que sigo
	public function verSiHayMasPostDeArtistaqueSigo($table,$usuario,$inicio){
		$tabla;
		switch($table){
			case 1:
				$tabla = "concierto";
				break;
			case 2:
				$tabla = "disco";
				break;
			case 3:
				$tabla = "libro";
				break;
		}
		$res = $this->pd->verMasPostdeArtistasqueSigo($tabla,$usuario,$inicio);
		if(is_null($res)){
			return false;
		}else{
			return true;
		}
	}
	
	#Mas Posts de artistas que sigo
	public function masPostdeArtistasqueSigo($table,$usuario,$inicio){
		$tabla;
		switch($table){
			case 1:
				$tabla = "concierto";
				break;
			case 2:
				$tabla = "disco";
				break;
			case 3:
				$tabla = "libro";
				break;
		}
		$res = $this->pd->verMasPostdeArtistasqueSigo($tabla,$usuario,$inicio);
		if(is_null($res)){
			return null;
		}else{
			return $res;
		}
	}
	
	#Ver post que me gustan
	public function verPostQueMegustan($table,$usuario){
		$tabla;
		switch($table){
			case 1:
				$tabla = "concierto";
				break;
			case 2:
				$tabla = "disco";
				break;
			case 3:
				$tabla = "libro";
				break;
		}
		$res = $this->pd->verPostqueMegustan($tabla,$usuario);
		return $res;
	}
	
	#Ver si asisto al evento
	public function asistoalEvento($usuario,$evento){
		return $this->pd->asistoAlEvento($usuario,$evento);
	}
	
	#Asistir al evento
	public function asistirEvento($usuario,$evento){
		return $this->pd->asistirEvento($usuario,$evento);
	}
	
	#Cancelar asistencia evento
	public function cancelarAsistenciaEvento($usuario,$evento){
		return $this->pd->noAsistirEvento($usuario,$evento);
	}
	
	#Ver eventos que asistire
	public function verEventosqueAsistire($user){
		return $this->pd->verEventosqueAsistire($user);
	}
	
	#Ver asistentes de un evento
	public function verAsistentesdeEvento($evento){
		return $this->pd->verAsistentesEvento($evento);
	}
	
	#Ver tipo usuario 
	public function verTipoUser($user){
		$res = false;
		$v = $this->getUserBD($user);
		if($v->getTipo() == 1){
			$res = true;
		}
		return $res;
	}
}
?>