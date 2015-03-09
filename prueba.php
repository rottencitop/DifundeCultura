<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<?php include('cssjs.php'); ?>
<script>
$(document).on("ready",function(){
	$("#vermas").on("click",function(){
		var inicio = $(this).attr("data-inicio");
		$(this).attr("data-inicio",parseInt(inicio)+4);
		alert(inicio);
		$.ajax({
			url : 'viewmore.php?inicio='+inicio,
			dataType:"json",
			success: function(data){
				console.log(data);
				$.each(data,function(i){
					$("#res").append('<h1>'+data[i].nombre+' - '+ data[i].artista +'</h1>');
					
				});
				
			}
		});
	});
});
</script>
</head>

<body>
<div  data-inicio="0" style="padding:0.2em; background-color:#CCC; color:#000;" id="vermas">Ver más</div>
<div id="res"></div>
<?php
#$ruta = dirname(__FILE__);
#require_once($ruta.'/DAL/AdminDAL.php');
#require_once($ruta.'/controller/UserC.php');

#$ud = new UserC();

#$id = $_GET['id'];
#$res = $ud->verArtista($id);

#var_dump($res);

/*echo limpiarYT("http://www.youtube.com/watch?v=rmnyFCazBos");

 function limpiarYT($url){
		$cad = parse_url($url);
		$query = $cad['query'];
		parse_str($query,$out);
		return $out['v'];
	}*/

/*
$titulo = "Hoña soy un título";
echo urls_amigables($titulo);

function urls_amigables($url) {
$url = strtolower($url);
$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
$repl = array('a', 'e', 'i', 'o', 'u', 'n');
$url = str_replace ($find, $repl, $url);
$find = array(' ', '&', '\r\n', '\n', '+');
$url = str_replace ($find, '-', $url);
$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
$repl = array('', '-', '');
$url = preg_replace ($find, $repl, $url);
return $url;
}
*/

?>
</body>
</html>