<?php
if(isset($_POST['enviar'])){
	$nombre = $_POST['nombre'];
	$email = $_POST['email'];
	$asunto = $_POST['asunto'];
	$mensaje = nl2br($_POST['mensaje']);
	$to ="contacto@difundecultura.com";
	$headers = "Content-Type: text/html; charset=iso-8859-1\n";
	$headers .= "From:".$nombre."\r\n";     
	$r= mail($to,$asunto,$mensaje,$headers);
	$res = array("success" => $r);
	echo json_encode($res);

}else{
	header("Location: index.php");
	exit();
}
?>