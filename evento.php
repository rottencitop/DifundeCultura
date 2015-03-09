<?php
require_once("controller/UserC.php");
require_once("controller/FacebookC.php"); 
$uc = new UserC();
$post = $_GET['id'];
settype($post,"int");
$e = $uc->verEvento($post);
if($e==null){
	header("Location: ../index.php");
	exit();
}
$fb = new FacebookC();
$urlActual = $uc->urlActual();
$user = $fb->getUsuarioFB();
if(!$user)
 $login = $fb->getUrlLoginFBPost();
 if($user){
	$asistir = $uc->asistoalEvento($user,$e->getId());
	$isAdmin = $uc->verTipoUser($user);
 }
?>
<!doctype html>
<html>
<head>
<meta property="fb:app_id"          content="628003447236654" /> 
<meta property="og:url"             content="<?php echo $urlActual; ?>" /> 
<meta property="og:title"           content="<?php echo $e->getTitulo(); ?> - #difundecultura" /> 
<meta property="og:image"           content="<?php echo $e->getAfiche(); ?>" /> 
<meta property="og:site_name" content="Difunde Cultura" />
<meta property="og:description" content="<?php echo 'Evento: '.$e->getNombre(); ?>"/>
<meta charset="utf-8">
<title><?php echo $e->getTitulo(); ?> - #difundecultura</title>
<?php include('cssjs.php'); ?>
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
            	<h2><?php echo $e->getTitulo(); ?></h2>
                <div id="wrapperevento">
                	<div id="afiche">
                    	<img src="<?php echo $e->getAfiche(); ?>" alt="">
                    </div>
                    <div id="eventoinfo">
                		<div class="titleinfo">Bandas/Artistas</div>
                        <?php echo $e->getArtistas(); ?>
                        <div class="titleinfo tl">Fecha/Hora</div>
                        <?php $date = date("d-m-Y", strtotime($e->getFecha()));
						echo $date.' - '.$e->getHora(); ?>
                        <div class="titleinfo tl">Lugar/Dirección</div>
                        <?php echo $e->getLugar(); ?> 
                        <div class="titleinfo tl">Precio</div>
                        <?php echo $e->getPrecio(); ?>
                        <div class="titleinfo tl">Link Oficial del Evento</div>
                        <?php echo '<a href="'.$e->getLink().'" target="_blank">Ir a la Página del Evento</a>'; ?>
                        <div class="titleinfo tl">Otra Información</div>
                        <?php echo $e->getInformacion(); ?>   
                	</div>
                </div>
                
                <?php if($user){ ?>
                <div id="infoevento">
                <?php
					if($asistir){
						echo '<div class="botonevento btnAsistir asistire" data-evento="'.$e->getId().'" data-user="'.$user.'">Asistiré</div>';
					}else{
						echo '<div class="botonevento btnAsistir" data-evento="'.$e->getId().'" data-user="'.$user.'">Asistir</div>';
					}
				?>
                    	
                    	<div class="botonevento btnParticipantes" data-evento="<?php echo $e->getId(); ?>">Participantes</div>
                        <div class="botonevento btnError" data-opcion="error">Reportar Error</div>
                        <?php
						if($isAdmin)
							echo '<div class="botonevento btnRemove removeEvento" data-evento="'.$post.'" title="Eliminar Post">Eliminar</div>';
						?>
                        
               </div>
               <?php } ?>
               
               <div id="shareit">
                    	<h3>¿Te gustó? Difunde Cultura!</h3>
                    		<div class="buttonshare"><div class="fb-share-button" data-href="<?php echo $urlActual; ?>" data-type="button_count"></div></div>
                        	<div class="buttonshare"><a href="https://twitter.com/share" class="twitter-share-button" data-via="dculturacom" data-lang="es">Twittear</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></div>
                    </div>
               
               <div id="comentarios">
                    	<h3>Comentarios</h3>
                        
                        <div style="display:table;margin:0 auto;">
                        	<div class="fb-comments" data-href="http://example.com/comments" data-width="800" data-numposts="5" data-colorscheme="light"></div>
                        </div>
                        
               </div>
                
            </section>
            <?php include('footer.php'); ?>
        </section>
    </div> 
  <div id="wrapperopsadmin">
<?php 
if($user){
	include("opsUser.php");;
	if($isAdmin)
		include('opsAdmin.php');
}?>
</div> 
<div id="participantes" title="Asistentes al evento">
	<div id="innerparticipantes">
        
    </div>
</div> 
</body>
</html>