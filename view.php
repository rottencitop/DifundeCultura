<?php
require_once("controller/UserC.php");
$uc = new UserC();
$inicio = $_GET['inicio'];
settype($inicio,"int");
$datos = $uc->verMasUltimosConciertos($inicio);
echo json_encode($datos);
?>