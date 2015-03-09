<?php
require_once("controller/UserC.php");
require_once("controller/FacebookC.php");
$uc = new UserC();
$fb = new FacebookC();
$uds = $uc->verUltimosDiscos();
$uls = $uc->verUltimosLibros();
$user = $fb->getUsuarioFB();
if($user)
	$isAdmin = $uc->verTipoUser($user);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>#difundecultura</title>
<?php include('cssjs.php'); ?>


</head>

<body>
	<div id="bloqres">
    	<div id="msjbloq">Disculpa, hemos detectado una resolución menor a 900px.<br>
        Para una mejor navegación te recomendamos agrandar la ventana del Navegador.<br>
        Si estás desde un teléfono móvil o Tablet, ingresa a la versión móvil.</div>
    </div>
    
    
    
	<div id="web">
    	<div id="wrapperheader">
        <?php include('header.php'); ?>
        </div>
        <?php 
		if($user){
			if($isAdmin)
				include('admin.php');
			include('profileuser.php');
		}
		?>
        <section id="container">
        	
            <?php include('last.php'); ?>
            <section id="contenidos">
            
            	<div class="tituloSeccionWhite"><span>Últimos</span> Discos</div>
                <div id="ultimosdiscos">
                <?php
				 foreach($uds as $ud){
					 echo '<div class="post">
					 <a href="disco/'.$uc->generarURLPost($ud).'">
                        <div class="imgpost">
                            <img src="'.$ud->getImagenP().'" alt="">
                            <div class="infopost">
                                <div class="wrapperip">
                                    <div class="likespost">'.$uc->contarMGdePost($ud->getPost()).'</div><div class="comentariospost">'.$uc->contarComentarios($ud->getPost()).'</div>
                                </div>
                            </div>
                            </div>
                        <h3>'.$ud->getNombre().' - '.$ud->getArtista().'</h3>
						</a>
                    </div> ';
				 }
				?>
                </div>
                <?php                   
                $cont = count($uds);
				if($cont == 4  && $uc->verSiHayMasPosts(2,NULL,4)){
					echo '<div class="loader"></div>
                	<div class="vermaspost" data-div="#ultimosdiscos" data-post="4" data-table="2">Ver más</div> ';
				}
				?> 
                
                              
                <div class="tituloSeccionWhite">Últimos Libros</div>
                <div id="ultimoslibros">
                	<?php
					if(is_null($uls)){
					}else{
						foreach($uls as $ul){
							echo '<div class="post">
							<a href="libro/'.$uc->generarURLPost($ul).'">
                    <div class="imgpost">
                    	<img src="'.$ul->getImagenP().'" alt="">
                        <div class="infopost">
                        	<div class="wrapperip">
                                <div class="likespost">'.$uc->contarMGdePost($ul->getPost()).'</div><div class="comentariospost">'.$uc->contarComentarios($ul->getPost()).'</div>
                        	</div>
                        </div>
                    </div>
                    <h3>'.$ul->getNombre().' - '.$ul->getArtista().'</h3>
					</a>
               		</div> ';
						}
					}
					?>
                
                
                </div>   
                
                
                
                
                <?php
				$cont = count($uls);
				if($cont == 4 && $uc->verSiHayMasPosts(3,NULL,4)){
					echo '<div class="loader"></div>
                	<div class="vermaspost" data-div="#ultimoslibros" data-post="4" data-table="3">Ver más</div>';
				}
				?>   
                
            </section>
            <aside id="menus">
            	<?php include('menu.php'); ?>
                
            </aside>
            
            <?php include('footer.php'); ?>
        </section>
    </div> 

<div id="wrapperopsadmin">
<?php 
if($user){
	include("opsUser.php");
	if($isAdmin)
		include('opsAdmin.php');
}?>
</div>

</body>
</html>