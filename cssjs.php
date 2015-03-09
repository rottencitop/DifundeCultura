<?php
$ruta = 'http://'.$_SERVER['SERVER_NAME'].'/dc';
 ?>
<link rel="shortcut icon" href="<?php echo $ruta; ?>/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo $ruta; ?>/favicon.ico" type="image/x-icon">
<link href="<?php echo $ruta; ?>/styles/normalize.css" type="text/css" rel="stylesheet">
<link href="<?php echo $ruta; ?>/css/smoothness/jquery-ui-1.10.3.custom.css" type="text/css" rel="stylesheet">
<link href="<?php echo $ruta; ?>/styles/style.css" type="text/css" rel="stylesheet">
<link href="<?php echo $ruta; ?>/css/tipsy.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo $ruta; ?>/js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="<?php echo $ruta; ?>/js/jquery.tipsy.js"></script>
<script type="text/javascript" src="<?php echo $ruta; ?>/js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $ruta; ?>/js/user.js"></script>
<?php if($user){
	echo '<script type="text/javascript" src="<?php echo $ruta; ?>/js/loguser.js"></script>';
}
if($isAdmin){
	echo '<script type="text/javascript" src="<?php echo $ruta; ?>/js/jsadmin.js"></script>';
}
?>


<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900|Oswald:400,300,700|Alegreya+Sans+SC:400,300,700|Exo+2:400,500italic,200,300|Lato:100|Raleway:200,300' rel='stylesheet' type='text/css'>
<script src="http://malsup.github.com/jquery.cycle2.js"></script>


