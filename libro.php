<?php
require_once("controller/UserC.php");
require_once("controller/FacebookC.php"); 
$uc = new UserC();
$post = $_GET['post'];
settype($post,"int");
$l = $uc->verLibro($post);
if($l == null){
	header("Location: ../index.php");
	exit();
}
$fb = new FacebookC();
$comments = $uc->verComentariosdeunPost($fb,$l->getPost());
$user = $fb->getUsuarioFB();
if(!$user)
 $login = $fb->getUrlLoginFBPost();
$like = $uc->verSiMegustaelPost($user,$l->getPost());
$urlActual = $uc->urlActual();
if($user)
	$isAdmin = $uc->verTipoUser($user);
?>
<!doctype html>
<html>
<head>
<meta property="fb:app_id"          content="628003447236654" /> 
<meta property="og:url"             content="<?php echo $urlActual; ?>" /> 
<meta property="og:title"           content="<?php echo $l->getNombre().' - '.$l->getArtista(); ?> - #difundecultura" /> 
<meta property="og:image"           content="<?php echo $l->getImagenP(); ?>" /> 
<meta property="og:site_name" content="Difunde Cultura" />
<meta property="og:description" content="<?php echo 'Libro: '.$l->getNombre().' - '.$l->getArtista(); ?>"/>
<meta charset="utf-8">
<title><?php echo $l->getNombre().' - '.$l->getArtista(); ?> - #difundecultura</title>
<?php
include('cssjs.php');
?>
</head>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=628003447236654";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	<div id="bloqres">
    	<div id="msjbloq">Disculpa, hemos detectado una resolución menor a 900px.<br>
        Para una mejor navegación te recomendamos agrandar la ventana del Navegador.<br>
        Si estás desde un teléfono móvil o Tablet, ingresa a la versión móvil.</div>
    </div>
	<div id="web">
        <?php include('header.php'); ?>
        <?php 
		if($user){
			if($isAdmin)
				include('admin.php');
			include('profileuser.php');
		}
		?>
        <section id="container">
            	<section id="wrapperviewer">
                <div id="clikes"><div><?php echo $uc->contarMGdePost($l->getPost()); ?></div></div>
                	<h2><?php echo $l->getNombre().' - '.$l->getArtista(); ?></h2>
                    <div id="vma">
                    <?php echo '<a href="../artista/'.$uc->generarURLArtista($l).'"><span>Ver más libros de '.$l->getArtista().'</span></a>' ?>
                	
                </div>
                    <div id="wrapperlibro">
                    	<div id="libroimg">
                        	<img src="<?php echo $l->getImagen(); ?>" alt="">
                        </div>
                        <div id="infolibro">
                        	<div class="titleinfo">Descripción:</div>
                        	<?php echo $l->getDescripcion(); ?>
                        </div>
                    </div>
                    
                    <div id="infolectura">
                    	<div class="botonlibro btnDownload" title="Ver/Descargar Libro">Ver/Descargar</div>
                    	<?php 
						if($like){
							echo '<div class="botonlibro btnLike ilike" data-uid="'.$user.'" data-post="'.$l->getPost().'" title="Desmarcar Me Gusta">Me Gusta</div>';
						}else{
							echo '<div class="botonlibro btnLike" data-uid="'.$user.'" data-post="'.$l->getPost().'" title="Marcar Me Gusta">Me Gusta</div>';
						}
						?>
                        <div class="botonlibro btnCompra" title="Apoya al Artista, compra el libro">Cómpralo</div>
                        <div class="botonlibro btnError" title="Reportar error en este post" data-opcion="error">Reportar Error</div>
                        <?php
						if($isAdmin)
							echo '<div class="botonlibro btnRemove" data-post="'.$post.'" title="Eliminar Post">Eliminar</div>';
						?>
                    </div>
                    
                    <div id="shareit">
                    	<h3>¿Te gustó? Difunde Cultura!</h3>
                    		<div class="buttonshare"><div class="fb-share-button" data-href="<?php echo $urlActual; ?>" data-type="button_count"></div></div>
                        	<div class="buttonshare"><a href="https://twitter.com/share" class="twitter-share-button" data-via="dculturacom" data-lang="es">Twittear</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></div>
                    </div>
                    
                    <div id="comentarios">
                    	<h3>Comentarios del Libro</h3>
                        <?php
						if(!empty($comments)){
							$i=1;
							foreach($comments as $c){						
								echo '<div class="wrappercomentario">';
								if($isAdmin)
									echo'<div class="removeComment"  data-idcomentario="'.$c['id'].'"></div>';
                        	echo '<div class="imgcomentario">
                            	<img src="'.$c['imagen'].'" alt="">
                            </div>
                            <div class="comentario">
                            	<h5>#'.$i.' - Publicado por <a style="color:#222;" href="'.$c['link'].'" target="_blank"><strong>'.$c['nombre'].'</strong></a> | '.$c['fecha'].'</h5>
                                <p>'.$c['comentario'].'</p>
                            </div>
                        </div>';
								$i++;
							}
						}else{
							echo'<div class="nopost">No hay comentarios todavía para este libro, sé el primero!</div>';
						}
						?>     
                    </div>
                    
                    <?php if($user){ 
                        echo '<div id="wrapperMakeComment">
                        	<h3>Hacer un comentario</h3>
                        	<textarea id="makeComment"></textarea>
                            <div id="btnComentar" data-fecha="'.date('d-m-Y').'" data-post="'.$post.'" data-user="'.$user.'" data-nombre="'.$fb->verUserFB($user).'">Comentar!</div>
                        </div>';
					}else{
							echo '<div id="notlogged">Para escribir un comentario debes iniciar sesión.
							<a href="'.$login.'"><div id="ingfbnotlogged" class="fbcolor">Ingresar con Facebook</div></a></div>';
						}
						 ?>
                        
                
                    
                    
                </section>
           
            
            
            <?php include('footer.php'); ?>
        </section>
    </div> 
<?php if($user){ ?>
<div id="reportarError" class="dialog" title="Reportar Error">
	<form id="formReportarError">
        <input type="hidden" name="user" readonly value="<?php echo $user; ?>">
        <input type="hidden" name="post" value="<?php echo $l->getPost(); ?>">
    	<label>Título:</label>
        <input type="text" name="titulo" required placeholder="Ej: Problema con el video">
        <label>Mensaje:</label>
        <textarea name="mensaje" required placeholder="Ej: El video no se visualiza o no existe"></textarea>
        <input type="submit" value="Enviar Error">
    </form>
</div>
<?php } ?>
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