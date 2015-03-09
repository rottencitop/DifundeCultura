<?php
require_once("controller/UserC.php");
require_once("controller/FacebookC.php");
$uc = new UserC();
$view = $_POST['view'];
settype($view,"int");
if($view == 1){
	sleep(1);
	$tabla = $_POST['tabla'];
	$artista = $_POST['artista'];
	settype($tabla,"int");
	$posts;
	$tipo;
	$r = array();
	switch($tabla){
		case 1:
			$posts = $uc->VerUltimosConciertosDeUnArtista($artista);
			$tipo = "concierto/";
		break;
		case 2:
			$posts = $uc->verUltimosDiscosdeunArtista($artista);
			$tipo = "disco/";
		break;
		case 3:
			$posts = $uc->verUltimosLibrosdeunArtista($artista);
			$tipo = "libro/";
		break;
	}
	
	if(!is_null($posts)){
		foreach($posts as $post){
			$r[] = array('post' => $post, 'url' => '../'.$tipo.$uc->generarURLPost($post));
		}
	}else{
		$r['null'] = true;
	}
	
	echo json_encode($r);
}elseif($view == 2){
	sleep(1);
	$tabla = $_POST['tabla'];
	$post = $_POST['post'];
	
	settype($tabla,"int");
	settype($post,"int");
	$posts;
	$tipo;
	$r = array();
	switch($tabla){
		case 1:
			$posts = $uc->verMasUltimosConciertos($post);
			$tipo = "concierto/";
		break;
		case 2:
			$posts = $uc->verMasUltimosDiscos($post);
			$tipo = "disco/";
		break;
		case 3:
			$posts = $uc->verMasUltimosLibros($post);
			$tipo = "libro/";
		break;
	}
	if(!is_null($posts)){
		foreach($posts as $post){
			$r[] = array('post' => $post, 'url' => $tipo.$uc->generarURLPost($post), 'likes' => $uc->contarMGdePost($post->getPost()), 'comments' => $uc->contarComentarios($post->getPost()));
		}
	}else{
		$r['null'] = true;
	}
	
	echo json_encode($r);
}elseif($view == 3){
	$post = $_POST['post'];
	$tabla = $_POST['tabla'];
	if(isset($_POST['artista']))
	$artista = $_POST['artista'];
	else $artista = NULL;
	settype($post,"int");
	settype($tabla,"int");
	$r = $uc->verSiHayMasPosts($tabla,$artista,$post);
	$res = array('success' => $r);
	echo json_encode($res);
}elseif($view == 4){
	sleep(1);
	$post = $_POST['post'];
	$tabla = $_POST['tabla'];
	if(isset($_POST['artista']))
	$artista = $_POST['artista'];
	else $artista = NULL;
	settype($post,"int");
	settype($tabla,"int");
	switch($tabla){
		case 1:
			$tipo = "concierto/";
		break;
		case 2:
			$tipo = "disco/";
		break;
		case 3:
			$tipo = "libro/";
		break;
	}
	$r = array();
	$posts = $uc->verMasPostdeArtista($tabla,$artista,$post);
	if(!is_null($posts)){
		foreach($posts as $post){
			$r[] = array('post' => $post, 'url' => '../'.$tipo.$uc->generarURLPost($post));
		}
	}else{
		$r['null'] = true;
	}
	
	echo json_encode($r);
}elseif($view == 5){
	$uid = $_POST['uid'];
	$post = $_POST['post'];
	settype($post,"int");
	$r = $uc->setMeGusta($uid,$post);
	$res = array("success" => $r);
	echo json_encode($res);
}elseif($view == 6){
	$uid = $_POST['uid'];
	$post = $_POST['post'];
	settype($post,"int");
	$r = $uc->setNoMeGusta($uid,$post);
	$res = array("success" => $r);
	echo json_encode($res);
}elseif($view == 7){
	$titulo = $_POST['titulo'];
	$mensaje = $_POST['mensaje'];
	$post = $_POST['post'];
	settype($post,"int");
	$fullmsg = '<strong>'.$titulo.'</strong><br>'.htmlspecialchars($mensaje);
	$usuario = $_POST['user'];
	$r = $uc->agregarError($usuario,$fullmsg,$post);
	$res = array("success" => $r);
	echo json_encode($res);
}
elseif($view == 8){
	$user = $_POST['user'];
	$artista = $_POST['artista'];
	$r = $uc->seguiraArtista($user,$artista);
	$res = array('success' => $r);
	echo json_encode($res);
}
elseif($view == 9){
	$user = $_POST['user'];
	$artista = $_POST['artista'];
	$r = $uc->noSeguiraArtista($user,$artista);
	$res = array('success' => $r);
	echo json_encode($res);
}
elseif($view == 10){
	sleep(1);
	$user = $_POST['user'];
	$tabla = $_POST['tabla'];
	$post = $_POST['post'];
	settype($tabla,"int");
	settype($post,"int");
	$posts = $uc->masPostdeArtistasqueSigo($tabla,$user,$post);
	$url;
	switch($tabla){
			case 1:
				$url = "concierto/";
				break;
			case 2:
				$url = "disco/";
				break;
			case 3:
				$url = "libro/";
				break;
		}
	$res = array();
	foreach($posts as $p){
		$res[] = array('post' => $p, "url" => $url.$uc->generarURLPost($p));
	}
	echo json_encode($res);
}elseif($view == 11){
	$user = $_POST['user'];
	$tabla = $_POST['tabla'];
	$post = $_POST['post'];
	settype($tabla,"int");
	settype($post,"int");
	$r = $uc->verSiHayMasPostDeArtistaqueSigo($tabla,$user,$post);
	$res = array("success" => $r);
	echo json_encode($res);
}
elseif($view == 12){
	$user = $_POST['user'];
	$evento = $_POST['evento'];
	settype($evento,"int");
	$r = $uc->asistirEvento($user,$evento);
	$res = array("success" => $r);
	echo json_encode($res);
}
elseif($view == 13){
	$user = $_POST['user'];
	$evento = $_POST['evento'];
	settype($evento,"int");
	$r = $uc->cancelarAsistenciaEvento($user,$evento);
	$res = array("success" => $r);
	echo json_encode($res);
}elseif($view == 14){
	sleep(1);
	$table = $_POST['table'];
	$genero = $_POST['genero'];
	settype($table,"int");
	$tabla;
	switch($table){
		case 1:$tabla = "concierto";		
		break;
		case 2: $tabla = "disco";
		break;
		case 3:$tabla = "libro";
	}
	$posts = $uc->buscarPostsporGenero($tabla,$genero);
	$res = array();
	foreach($posts as $p){
		$res[] = array('post' => $p, "url" => $tabla.'/'.$uc->generarURLPost($p), 'mg' => $uc->contarMGdePost($p->getPost()));
	}
	echo json_encode($res);
}elseif($view == 15){
	sleep(1);
	$table = $_POST['table'];
	$letra = $_POST['letra'];
	settype($table,"int");
	$tabla;
	switch($table){
		case 1:$tabla = "concierto";		
		break;
		case 2: $tabla = "disco";
		break;
		case 3:$tabla = "libro";
	}
	$posts = $uc->buscarPostsPorLetra($tabla,$letra);
	$res = array();
	foreach($posts as $p){
		$res[] = array('post' => $p, "url" => $tabla.'/'.$uc->generarURLPost($p), 'mg' => $uc->contarMGdePost($p->getPost()));
	}
	echo json_encode($res);
}elseif($view == 16){
	sleep(0.8);
	$user = $_POST['user'];
	$post = $_POST['post'];
	$comentario = nl2br($_POST['comentario']);
	settype($post,"int");
	$comentario = strip_tags($comentario);
	$fecha = date('Y-m-d');
	$r = $uc->agregarComentario($user,$post,$fecha,$comentario);
	$res = array("success" => $r);
	echo json_encode($res);
}
elseif($view == 17){
	sleep(1);
	$evento = $_POST['evento'];
	settype($evento,"int");
	$fb = new FacebookC();
	$users = $uc->verAsistentesdeEvento($evento);
	$profiles = $fb->verPerfilesdeUsuariosComentarios($users);
	$res = array();
	foreach($profiles as $p){
		$res[] = array("nombre" => $p['name'], "url" => $p['link'], "imagen" => $p['picture']['data']['url']);
	}
	echo json_encode($res);
}elseif($view == 18){
	sleep(1);
	$palabra = $_POST['palabra'];
	$p = filter_var($palabra,FILTER_SANITIZE_MAGIC_QUOTES);
	$p = filter_var($p,FILTER_SANITIZE_STRING);
	$res = $uc->buscarArtista($p);
	$x = array();
	foreach($res as $r){
		$x[] = array("nombre" => $r, "url" => 'artista/'.$uc->generarURLArtista2($r));
	}
	echo json_encode($x);
}elseif($view == 19){
	sleep(1);
	$tabla = $_POST['tabla'];
	$user = $_POST['user'];
	settype($tabla,"int");
	$tipo;
	switch($tabla){
		case 1: $tipo = "concierto/";
			break;
		case 2: $tipo = "disco/";
			break;
		case 3: $tipo = "libro/";
			break;
	}
	$posts = $uc->verPostQueMegustan($tabla,$user);
	$res = array();
	foreach($posts as $p){
		$res[] = array("post" => $p, "url" => $tipo.$uc->generarURLPost($p));
	}
	echo json_encode($res);
}elseif($view == 20){
	$user = $_POST['user'];
	$res = $uc->verEventosqueAsistire($user);
	$eventos = array();
	foreach($res as $r){
		$eventos[] = array("evento" => $r, "url" => 'evento/'.$uc->generarURLEvento($r));
	}
	echo json_encode($eventos);
}
else{
	header("Location: index.php");
	exit();
}
?>