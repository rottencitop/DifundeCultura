<?php
$nombre = $fb->verUserFB($user);
?>
<section id="myprofileview">
        	<div id="wrapperprofileview">
            	<div id="myinfoview">
                	<div id="imgprofile"><img src="https://graph.facebook.com/<?php echo $user; ?>/picture" alt=""/></div>
                	<div id="nameprofile">
        				<h6>Bienvenido</h6>
            			<a href="miperfil.html"><h4><?php echo $nombre; ?></h4></a>
        			</div>
                </div>
                
                <div id="myoptions">
                	<ul>
                    	<li class="lc" data-op="1" data-div="#conciertoslikes" data-user="<?php echo $user; ?>" title="Conciertos que me gustan">Mis Conciertos</li>
                        <li class="ld" data-op="2" data-div="#discoslikes" data-user="<?php echo $user; ?>" title="Discos que me gustan">Mis Discos</li>
                        <li class="ll" data-op="3" data-div="#libroslikes" data-user="<?php echo $user; ?>" title="Libros que me gustan">Mis Libros</li>
                        <li class="le" data-op="4" data-div="#eventosasistencia" data-user="<?php echo $user; ?>" title="Eventos que asistiré">Mis Eventos</li>
                        <a href="logout.php"><li class="cs" title="Cerrar mi sesión">Cerrar Sesión</li></a>
                    </ul>
                </div>
            </div>
        </section>