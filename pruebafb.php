<?php
require_once("controller/AdminC.php");
require_once("controller/UserC.php");
require_once("controller/FacebookC.php");
$ac = new AdminC();
$uc = new UserC();
$fb = new FacebookC();
$users = $ac->verTodoslosUsuarios();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
 <?php 
	/*foreach($users as $u){
		echo '<div class="fbuseradmin">
			<a href="'.$fb->verLinkUserFB($u->getUid()).'" target="_blank">
        	<div class="fbuseradminimg"><img src="'.$fb->prueba($u->getUid()).'" alt=""></div>
            <div class="fbuseradmininfo">
            	<h5>'.$fb->verUserFB($u->getUid()).'</h5>
            </div>
			</a>
        </div> ';
	}*/
	
	$profiles = $fb->verPerfilesdeUsuarios($users);
	foreach($profiles as $p){
		echo '<div class="fbuseradmin">
			<a href="'.$p['link'].'" target="_blank">
        	<div class="fbuseradminimg"><img src="'.$p['picture']['data']['url'].'" alt=""></div>
            <div class="fbuseradmininfo">
            	<h5>'.$p['name'].'</h5>
            </div>
			</a>
        </div> ';
	}
	?>   
</body>
</html>