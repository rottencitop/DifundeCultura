<?php
$ucs = $uc->verUltimosConciertos();
?>
<section id="last">
            	<div id="ultimosConciertos">
                	<div class="tituloSeccion"><span>Últimos</span> Conciertos</div>
                    <div class="cycle-slideshow" data-cycle-slides="> div" data-cycle-pause-on-hover="true" data-cycle-prev=".arrowLeft" data-cycle-next=".arrowRight">
                    	<?php
                        foreach($ucs as $ulc){
							echo '<div class="ultimoConcierto">
                    	<a href="concierto/'.$uc->generarURLPost($ulc).'"><img src="'.$ulc->getImagen().'"  alt=""/>
                        <h1>'.$ulc->getArtista().' - '.$ulc->getNombre().'</h1></a>
                    	</div>';
						}
						?>                        
                    </div>
                    <div class="arrowLeft"></div>
                    <div class="arrowRight"></div>
                </div>
                <div id="ultimosPosts">
                	<div class="tituloSeccion"><span>Más</span> Populares</div>
                    <?php
					$cmps = $uc->verConciertosMasPopulares();
					if(!is_null($cmps)){
						foreach($cmps as $cmp){
							
							$c = $uc->verConcierto($cmp['post']);
							$n = $c->getArtista().' - '.$c->getNombre();
							if(strlen($n) > 40){
								$nombre = substr($n,0,40).'...';
							}
							else {$nombre = $n;}
							echo '<article title="<strong>'.$n.'</strong><br/>Click en el nombre para ir al Concierto"><div class="tituloUltimoPost"><a href="concierto/'.$uc->generarURLPost($c).'">'.$nombre.'</a></div><div class="likeUltimoPost">'.$cmp['megusta'].'</div></article>';
						}
					}
					else{
						echo '<div class="nopost">No han dado Me Gusta en ningún Concierto.</div>';
					}
					?>
                    
                </div>
            </section>