<?php
require_once("controller/UserC.php");
require_once("controller/FacebookC.php");
$uc = new UserC();
$fb = new FacebookC();
$user = $fb->getUsuarioFB();
if($user){
}else{
	header("Location: index.php");
	exit();
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mi Perfil - #difundecultura</title>
<?php include('cssjs.php'); ?>
</head>

<body>
	<div id="bloqres">
    	<div id="msjbloq">Disculpa, hemos detectado una resolución menor a 900px.<br>
        Para una mejor navegación te recomendamos agrandar la ventana del Navegador.<br>
        Si estás desde un teléfono móvil o Tablet, ingresa a la versión móvil.</div>
    </div>
	<div id="web">
        <?php include('header.php'); ?>
        <section id="container">
        	<section id="wrapperviewer">
            	<div id="userinfo">
                	<div id="userimg">
                    	<img src="https://graph.facebook.com/<?php echo $user; ?>/picture?type=large" alt="">
                    </div>
                    <div id="username">
                    	<div class="titleinfo">Mi Perfil</div>
                        <h2><?php
                        $nombre = $fb->verUserFB($user);
						echo $nombre;
						?></h2>
                        <div id="useroptions">
                            <ul>
                                <li class="optionsuserperfil lc" data-op="1" data-user="<?php echo $user; ?>" data-div="#conciertoslikes" title="Ver Conciertos que me gustan">Conciertos</li>
                                <li class="optionsuserperfil ld" data-op="2" data-user="<?php echo $user; ?>" data-div="#discoslikes" title="Ver Discos que me gustan">Discos</li>
                                <li class="optionsuserperfil ll" data-op="3" data-user="<?php echo $user; ?>" data-div="#libroslikes" title="Ver Libros que me gustan">Libros</li>
                                <li class="optionsuserperfil le" data-op="4" data-user="<?php echo $user; ?>" data-div="#eventosasistencia" title="Ver Eventos que asistiré">Eventos que asistiré</li>
                                <li class="optionsuserperfil cs"title="Cerrar mi sesión">Cerrar Sesión</li>
                            </ul>
               			</div>
                        
                    </div>
                </div>
                
                
                
                
                
                <div class="titleinfo">Publicaciones nuevas de Artistas que estoy siguiendo</div>
                
                <div id="publicaciones">
                <div class="tituloSeccionWhite">Conciertos</div>
                	<div id="conciertospost">
                 	<?php
                    $cdaqs = $uc->conciertosDeArtistasqueSigo($user);
					if(!is_null($cdaqs)){
						foreach($cdaqs as $v){
							echo '<a href="concierto/'.$uc->generarURLPost($v).'"><div class="postart">
                    	<div class="postartimg"><img src="'.$v->getImagen().'" alt=""></div>
                        <div class="postarttitle"><strong>'.$v->getArtista().' - '.$v->getNombre().'</strong></div>
                    </div></a> ';
						}
						
					}
					else{
						echo '<div class="nopost">No sigo a ningún artista</div>';
					}
					?>
                    </div>
                    <?php
						$more = $uc->verSiHayMasPostDeArtistaqueSigo(1,$user,count($cdaqs));
							if($more){
								echo '<div class="loader"></div>
								<div class="vermaspostartistaquesigo" data-table="1" data-div="#conciertospost" data-user="'.$user.'" data-post="4">Ver más</div>';
							}
					?>
                    <div class="tituloSeccionWhite">Discos</div>
                    <div id="discospost">
                    <?php
					$ddaqs = $uc->discosDeArtistasqueSigo($user);
					if(!is_null($ddaqs)){
						foreach($ddaqs as $v){
							echo '<a href="disco/'.$uc->generarURLPost($v).'"><div class="postart">
                    	<div class="postartimg"><img src="'.$v->getImagenP().'" alt=""></div>
                        <div class="postarttitle"><strong>'.$v->getArtista().' - '.$v->getNombre().'</strong></div>
                    </div></a> ';
						}
					}else{
						echo '<div class="nopost">No sigo a ningún artista</div>';
					}
					?>
                    </div>
                    <?php
						$more = $uc->verSiHayMasPostDeArtistaqueSigo(2,$user,count($ddaqs));
							if($more){
								echo '<div class="loader"></div>
								<div class="vermaspostartistaquesigo" data-table="2" data-div="#discospost" data-user="'.$user.'" data-post="4">Ver más</div>';
							}
					?>
                    <div class="tituloSeccionWhite">Libros</div>
                    <div id="librospost">
                    <?php
					$ldaqs = $uc->librosDeArtistasqueSigo($user);
					if(!is_null($ldaqs)){
						foreach($ldaqs as $v){
							echo '<a href="libro/'.$uc->generarURLPost($v).'"><div class="postart">
                    	<div class="postartimg"><img src="'.$v->getImagenP().'" alt=""></div>
                        <div class="postarttitle"><strong>'.$v->getArtista().' - '.$v->getNombre().'</strong></div>
                    </div></a> ';
						}
					}else{
						echo '<div class="nopost">No sigo a ningún artista</div>';
					}
					?>
                    </div>
                    <?php
						$more = $uc->verSiHayMasPostDeArtistaqueSigo(3,$user,count($ldaqs));
							if($more){
								echo '<div class="loader"></div>
								<div class="vermaspostartistaquesigo" data-table="3"  data-div="#librospost" data-user="'.$user.'" data-post="4">Ver más</div>';
							}
					?>
                 </div>
                
                
                

            </section>
            <?php include('footer.php'); ?>
        </section>
    </div>
<?php
if($user){
	include("opsUser.php");
}
?> 
</body>
</html>