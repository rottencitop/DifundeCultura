<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<?php
$nombre = $_POST['nombre'];
$resena = $_POST['resena'];
$web = $_POST['web'];
$fb = $_POST['facebook'];
$tw = $_POST['twitter'];
$wiki = $_POST['wiki'];
$sc = $_POST['soundcloud'];
$generos = $_POST['generos'];
$tipos = $_POST['tipo'];
$imagenes = $_FILES['imagenes']['tmp_name'];

var_dump($tipos);

echo '<br><br>';
var_dump($_POST);
var_dump($_FILES);

/*
$imgs = $_FILES['imagenes'];
$urlimgs = array();
foreach($imgs['tmp_name'] as $tipo){
	$urlimgs[] = subir($tipo);
}
print_r($urlimgs);

$tipos = $_POST['generos'];
foreach($tipos as $tipo){
	echo $tipo.'<br>';
}


function subir($img){
	$data = file_get_contents($img);
    $pvars = array('image' => base64_encode($data), 'key' => 'b0e52afb3ea0d34035cce1db10ddb40b');
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://api.imgur.com/2/upload.xml');
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
    $xml = curl_exec($curl);
    preg_match ("/<original>(.*)<\/original>/xsmUi", $xml, $matches);
    $cad = $matches[1];
    curl_close ($curl);
	return $cad; 
}
*/

?>


</body>
</html>