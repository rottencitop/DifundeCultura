<?php
define(__ROOT__,dirname(dirname(__FILE__)));
require_once(__ROOT__.'/fb/facebook.php');
class FacebookC{
	private $fb;
	
	function __construct(){
		$config = array(
  		'appId'  => '628003447236654',
  		'secret' => '67463660170bb81fd711930d8a4c7be5',
		);
		$this->fb = new Facebook($config);
	}
	
	//---------------------------------------------------------------Usuarios Facebook
	
	#Ver Nombre de Usuario de Facebook
	public function verUserFB($id){
		$user = $this->fb->api("/$id?fields=name");
		return $user['name'];
	}
	
	#Ver URL Perfil
	public function verLinkUserFB($uid){
		$user = $this->fb->api("/$uid?fields=link");
		return $user['link'];
	}
	
	public function verImagenUser($uid){
		$v = $this->fb->api("/$uid?fields=picture.type(square)");
		return $v['picture']['data']['url'];
	}
	
	#Obtener usuario de Facebook
	public function getUsuarioFB(){
		return $this->fb->getUser();
	}
	
	#Obtener URL Login Facebook
	public function getUrlLoginFB(){
		return $this->fb->getLoginUrl(array(
                       'scope' => 'email',
					   'redirect_uri' => 'http://localhost/dc/login.php'					   
                       ));
	}
	
	public function getUrlLoginFBPost(){
		return $this->fb->getLoginUrl(array(
                       'scope' => 'email',
					   'redirect_uri' => 'http://localhost/dc/login.php?v=post'
                       ));
	}
	
	#Destruir Sesion Facebook
	public function getLogoutFB(){
		if($this->getUsuarioFB()){
			$this->fb->destroySession();
			return true;
		}
		return false;
	}
	
	public function verPerfilesdeUsuarios($users){
		$queries = array();
		foreach($users as $u){
			$queries[] = array('method' => "get", 'relative_url' => '/'.$u->getUid().'?fields=name,link,picture.type(square)');
		}
		$batch = $this->fb->api('?batch='.json_encode($queries), 'post');
		$res = array();
		foreach($batch as $b){
			$res[] = json_decode($b['body'],true);
		}
		return $res;
	}
	
	public function verPerfilesdeUsuariosComentarios($users){
		$queries = array();
		foreach($users as $u){
			$queries[] = array('method' => "get", 'relative_url' => '/'.$u.'?fields=name,link,picture.type(square)');
		}
		$batch = $this->fb->api('?batch='.json_encode($queries), 'post');
		$res = array();
		foreach($batch as $b){
			$res[] = json_decode($b['body'],true);
		}
		return $res;
	}
}
?>