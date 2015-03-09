<?php
require_once("controller/AdminC.php");
$ac = new AdminC();
sleep(1);
if($_POST['add'] == 1){
	$nombre = $_POST['nombre'];
	$resena = nl2br($_POST['resena']);
	$web = $_POST['web'];
	$fb = $_POST['facebook'];
	$tw = $_POST['twitter'];
	$wiki = $_POST['wiki'];
	$sc = $_POST['soundcloud'];
	$generos = $_POST['generos'];
	$tipos = $_POST['tipo'];
	$imagenes = $_FILES['imagenes']['tmp_name'];
	$r = $ac->agregarArtista($nombre,$resena,$web,$fb,$tw,$wiki,$sc,$imagenes,$generos,$tipos);
	switch($r){
		case 1:
			echo "Agregado Éxitosamente";
		break;
		default:
			echo "Error código: ".$r;
		break;
	}
}
elseif($_POST['add'] == 2){
	$nombre = $_POST['nombre'];
	$artista = $_POST['artista'];
	$yt = $_POST['youtube'];
	$descripcion = nl2br($_POST['descripcion']);
	$imagen = $_FILES['imagen']['tmp_name'];
	$r = $ac->agregarConcierto($nombre,$artista,$yt,$descripcion,$imagen);
	switch($r){
		case 1:
			echo "Agregado Éxitosamente";
		break;
		default:
			echo "Error código: ".$r;
		break;
	}
}
elseif($_POST['add'] == 3){
	$nombre = $_POST['nombre'];
	$artista = $_POST['artista'];
	$urldescarga = $_POST['urldescarga'];
	$urlcompra = $_POST['urlcompra'];
	$descripcion = nl2br($_POST['descripcion']);
	$tracklist = nl2br($_POST['tracklist']);
	$caratula = $_FILES['caratula']['tmp_name'];
	$imagenp = $_FILES['imagen']['tmp_name'];
	$r = $ac->agregarDisco($nombre,$artista,$urldescarga,$urlcompra,$descripcion,$tracklist,$caratula,$imagenp);
	switch($r){
		case 1:
			echo "Agregado Éxitosamente";
		break;
		default:
			echo "Error código: ".$r;
		break;
	}
}
elseif($_POST['add'] == 4){
	$genero = $_POST['genero'];
	$r = $ac->addGenero($genero);
	if($r){
		echo "Género agregado éxitosamente.";
	}
	else{
		echo "Error al agregar género.";
	}
}
elseif($_POST['add'] == 5){
	$nombre = $_POST['nombre'];
	$artista = $_POST['artista'];
	$urldescarga = $_POST['urldescarga'];
	$urlcompra = $_POST['urlcompra'];
	$descripcion = $_POST['descripcion'];
	$imagen = $_FILES['portada']['tmp_name'];
	$imagenP= $_FILES['imagenp']['tmp_name'];
	$r = $ac->agregarLibro($nombre,$artista,$descripcion,$urldescarga,$urlcompra,$imagen,$imagenP);
	switch($r){
		case 1:
			echo "Agregado Éxitosamente";
		break;
		default:
			echo "Error código: ".$r;
		break;
	}
}
elseif($_POST['add'] == 6){
	$titulo = $_POST['titulo'];
	$artistas = nl2br($_POST['artistas']);
	$fecha = $_POST['fecha'];
	$hora = $_POST['hora'];
	$lugar = $_POST['lugar'];
	$precio = $_POST['precio'];
	$url = $_POST['url'];
	$info = $_POST['informacion'];
	$afiche = $_FILES['afiche']['tmp_name'];
	$r = $ac->agregarEvento($titulo,$artistas,$fecha,$hora,$lugar,$precio,$url,$info,$afiche);
	switch($r){
		case 1:
			echo "Agregado Éxitosamente";
		break;
		default:
			echo "Error código: ".$r;
		break;
	}
}elseif($_POST['view']==1){
	foreach($ac->verGeneros() as $genero){
		echo '<div class="cbform"><input type="checkbox" name="generos[]" value="'.$genero.'">'.$genero.'</div>';
	}
	
}elseif($_POST['view'] == 2){
	$id = $_POST['id'];
	settype($id,"int");
	$r = $ac->eliminarRecomendacion($id);
	if($r){
		echo "Recomendación eliminada.";
	}else{
		echo "Error al eliminar recomendación.";
	}
	
}elseif($_POST['view'] == 3){
	$id = $_POST['id'];
	settype($id,"int");
	$r = $ac->eliminarError($id);
	if($r){
		echo "Error eliminado.";
	}
	else{
		echo "Error al eliminar el error.";
	}
}elseif($_POST['view'] == 4){
	$id = $_POST['id'];
	settype($id,"int");
	$r = $ac->eliminarComentario($id);
	$res = array("success" => $r);
	echo json_encode($res);
}elseif($_POST['view'] == 5){
	$post = $_POST['post'];
	settype($post,"int");
	$r = $ac->eliminarPost($post);
	$res = array("success" => $r);
	echo json_encode($res);
}else{
	header("Location: index.php");
	exit();
}
?>