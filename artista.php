<?php
require_once("controller/UserC.php");
require_once("controller/FacebookC.php");
$uc = new UserC();
$artista = $_GET['artista'];
$a = $uc->verArtista($artista);
if($a==null){
	header("Location:index.php");
	exit();
}
$ias = $uc->verImagenesArtista($a->getNombre());
$gas = $uc->verGenerosArtista($a->getNombre());
$tas = $uc->verTipoArtista($a->getNombre());
$web = $a->getWeb();
$wiki = $a->getWiki();
$fbp = $a->getFacebook();
$tw = $a->getTwitter();
$sc = $a->getSoundcloud();
$fb = new FacebookC();
$user = $fb->getUsuarioFB();
$isAdmin = $uc->verTipoUser($user);
$updas = $uc->VerUltimosConciertosDeUnArtista($a->getNombre());
$uldas = $uc->verUltimosLibrosdeunArtista($a->getNombre());
$uddas = $uc->verUltimosDiscosdeunArtista($a->getNombre());
$sigo = $uc->sigoAlArtista($a->getNombre(),$user);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $a->getNombre(); ?> - #difundecultura</title>
<?php include('cssjs.php'); ?>
<script type="text/javascript">
	$(document).on("ready", function(){
		
		getPosts();
			
	});
	
	function getPosts(){
		var e = $(".ooartactive");
		var tabla = parseInt(e.attr("data-table"));
		var artista = e.attr("data-art");
		var vermas = $(".vermaspostartista");
		var datos = {'tabla':tabla, 'artista':artista, 'view':1};
		var divParent = $("#publicaciones");
		var div;
		switch(tabla){
					case 1: 
					vermas.attr("data-table",1);
					div = '<div class="tituloSeccionWhite">Últimos Conciertos</div>';break;
					case 2: 
					vermas.attr("data-table",2);
					div = '<div class="tituloSeccionWhite">Últimos Discos</div>';break;
					case 3: 
					vermas.attr("data-table",3);
					div = '<div class="tituloSeccionWhite">Últimos Libros</div>';break;
		}
		$.ajax({
			url: '../viewmore.php',
			type: 'post',
			data: datos,
			dataType:"json",
			success: function(data){
				if(data.length){
					var masPosts = hayMasPosts(4,tabla,artista,"get");
					if(data.length >= 4 && masPosts){
						vermas.attr("data-table",tabla);
						vermas.attr("data-post",4);
						vermas.slideDown("fast");
					}
					$(divParent).html(div);
					$.each(data,function(i){
						var img;
						if(typeof data[i].post.imagenP == "undefined")
						 	img = data[i].post.imagen;
						else
							img = data[i].post.imagenP;
						$(divParent).append('<a href="'+data[i].url+'"><div class="postart"><div class="postartimg"><img src="'+ img +'" alt=""></div><div class="postarttitle"><strong>'+data[i].post.artista+' - '+data[i].post.nombre+'</strong></div></div></a> ');
					});
				}
				else{
					$(divParent).html('<div class="nopost">No hay publicaciones todavía, pronto habrá contenido para esta página.<br> Vuelve pronto o elige otra opción en el menú superior.</div>');
				}
			}
		});
	}
	
	
	
	function hayMasPosts(post,tabla,artista,call){
	var data= {'post':post,'tabla':tabla,'view':3,'artista':artista};
	if(typeof call == "undefined"){
		var url = "viewmore.php";
	}else{ 
	var url = "../viewmore.php";
	}
	var r = false;
	$.ajax({
		url: url,
		data:data,
		async:false,
		type: 'post',
		dataType:"json",
		success: function(data){
			r = data.success;
		}
	});
	return r;
	}
	
	
</script>
</head>

<body>
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
            
                 <h2><?php echo $a->getNombre(); ?></h2>    
                
                <div id="generos">
                	<?php 
					if(!in_array('Lectura',$tas) && in_array('Musica',$tas)){
						echo 'Géneros:<ul>';
						foreach($gas as $ga){
								echo "<li>$ga</li>";
							}
						echo '</ul>';
					}
					?>
                    
                </div>
                             
                <div id="wrapperinfoartista">
                	<div class="infoartistaimg">
                    	<div class="cycle-slideshow" data-cycle-slides="> div" data-cycle-pause-on-hover="true">
                        	<?php 
								foreach($ias as $ia){
									echo '<div class="iaimg"><img src="'.$ia.'" alt=""></div>';
								}
							?>
                            
						</div>
                    </div>
                    
                    <div class="infoartista">
                    	<div class="titleinfo">Reseña:</div>
						<?php echo $a->getResena(); ?>
                    </div>
                    
                </div>
                
                <div id="navartista">
                   		<ul>
                        	<?php
							if($user){
								if($sigo){
								echo '<li class="opnavartista siguiendoart" id="follow" data-artista="'.$a->getNombre().'" data-user="'.$user.'" title="Estás siguiendo a este artista"><span>Siguiendo a este artista</span></li>';
							}else{
								echo '<li class="opnavartista seguirart" id="follow" data-artista="'.$a->getNombre().'" data-user="'.$user.'" title="Seguir a este artista"><span>Seguir a este Artista</span></li>';
							}
							}
							?>
                            <?php
								if(!empty($web)){
									echo '<a href="'.$web.'" target="_blank"><li class="opnavartista webart" title="Ver Página Web"></li></a>';
								}
								if(!empty($wiki)){
									echo '<a href="'.$wiki.'" target="_blank"><li class="opnavartista wikiart" title="Ver Wikipedia"></li></a>';
								}
								if(!empty($fbp)){
									echo '<a href="'.$fbp.'" target="_blank"><li class="opnavartista fbart" title="Ver Facebook"></li></a>';
								}
								if(!empty($tw)){
									echo '<a href="'.$tw.'" target="_blank"><li class="opnavartista twart" title="Ver Twitter"></li></a>';
								}
								if(!empty($sc)){
									echo '<a href="'.$sc.'" target="_blank"><li class="opnavartista scart" title="Ver Soundcloud"></li></a>';
								}
							?>
                        	
                            
                            
                            
                            
                            <li id="sep"><img src="../images/sep.png" alt=""></li> 
                            <?php
								if(in_array('Musica',$tas)){
									echo '<li class="opnavartista ooart ooartactive" data-art="'.$a->getNombre().'" data-table="1" title="Ver todos los Conciertos">Conciertos</li>';
								}
								if(in_array('Musica',$tas)){
									echo '<li class="opnavartista ooart" data-table="2" data-art="'.$a->getNombre().'" title="Ver todos los Discos">Discos</li>';
								}
								if(in_array('Lectura',$tas)){
									if(!in_array('Musica',$tas)){
										$class = "ooartactive";
									}else $class= "";
									echo '<li class="opnavartista ooart '.$class.'" data-art="'.$a->getNombre().'" data-table="3" title="Ver todas los Libros">Libros</li>';
								}
							?>
                        	
                        </ul>
                 </div>
                 
                 
                 <div id="publicaciones">
       
                 </div>
                 
                 <div class="loader"></div>
                	<div class="vermaspostartista" style="display:none;" data-artista="<?php echo $a->getNombre(); ?>" data-table="" data-post="">Ver más</div>
                               
            </section>
                     
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