<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login - #difundecultura</title>
<link href='http://fonts.googleapis.com/css?family=Raleway:200,300' rel='stylesheet' type='text/css'>
<style>
body{
	font-size: 14px;
	font-weight: 300;
	background:url(images/bg.jpg);
	padding:0;
	margin:0;
}
#wrapperlogin{
	width:100%;
	padding:5px;
	position:absolute;
	top:50%;
	left:50%;
	max-width:500px;
	height:250px;
	margin-top:-130px;
	margin-left:-255px;
	
}
#bannerlogin{
	width:100%;
	max-width:400px;
	margin:0 auto;
}
#bannerlogin img{
	vertical-align:top;
	width:100%;
}
#insidelogin{
	background:rgba(255,255,255,0.9);
	border-radius:3px;
	padding:10px 0;
	box-shadow:0 2px 2px rgba(0,0,0,0.2);
}
#loader{
	background:url(images/load.GIF) no-repeat;
	display:table;
	margin:10px auto;
	width:24px;
	height:24px;
}
#info{
	text-align:center;
	font-family:'Raleway';
	font-weight:300;
	font-size:16px;
	text-transform:uppercase;
	color:#777;
}
</style>
</head>

<body onLoad="redireccionar()">
<div id="wrapperlogin">
	<div id="bannerlogin"><img src="images/bannerlogin.png" alt=""></div>
    <div id="insidelogin">
    	<div id="loader"></div>
        <div id="info">
        <?php
		require_once("controller/FacebookC.php");
		require_once("controller/UserC.php");
		$uc = new UserC();
		$fb = new FacebookC();
		$me = $fb->getUsuarioFB();
		if($me){
			$user = $uc->isInBD($me);
			if($user == null){
				$r = $uc->insertUserFB($me);
				if($r==1){
					echo "El registro fue un éxito, bienvenido a difundecultura";
				}else{
					echo "Error en el registro";
				}
			}
			else{
				echo "Ya estás registrado, bienvenido a difundecultura.";
			}
		}
		else{
			header("Location: index.php");
			exit();
		}
		?>
        Estamos logueandote, espera un momento, serás redireccionado automáticamente.
        
        </div>
    </div>
</div>
<script type="text/javascript">
function redireccionar() {
<?php
if(isset($_GET['v'])){
	echo 'setTimeout("history.back(-1)", 3000);}';
}else{
	echo 'setTimeout("location.href=\'miperfil.html\'", 3000);}';
}
?>

</script>
</body>
</html>