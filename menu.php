<div class="menu">
                	
                    <?php 
					if(!$user){
						echo '<div class="tituloSeccion"><span>Iniciar </span> Sesión</div>
                    	<a href="'.$fb->getUrlLoginFB().'"><div class="bar fbcolor iniciarSesion" id="ingresaFB" title="<strong>No rellenes formularios, ingresa más fácil y rápido con tu cuenta de Facebook. Solo pedirá la información básica y correo electrónico.</strong>">Ingresar con Facebook</div></a>';
					}
					?>
                    
                    <!--<div class="bar twcolor iniciarSesion">Ingresar con Twitter</div>-->
                </div>
            	
                <div class="menu">
                	<div class="tituloSeccion"><span>Links</span> Amigos</div>
                	<img src="images/librossiniva.png" alt="">
                </div>
                
                <div class="menu">
                	<div class="tituloSeccion"><span>Facebook</span></div>
                	<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FDifundeCultura&amp;width=240&amp;height=395&amp;colorscheme=light&amp;show_faces=false&amp;header=false&amp;stream=true&amp;show_border=false&amp;appId=222095557817768" scrolling="no" frameborder="0" style="border:1px solid #dadada; overflow:hidden; width:100%; height:395px;" allowTransparency="true"></iframe>

                </div>
                
                <div class="menu">
                	<div class="tituloSeccion"><span>Twitter</span></div>
                    <a class="twitter-timeline" href="https://twitter.com/dculturacom" data-widget-id="417733220830965760">Tweets por @dculturacom</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

                </div>
                
                <div class="menu">
                	<div class="tituloSeccion"><span>Próximos</span> Eventos</div>
                    <?php
					$ues = $uc->verUltimosEventos();
					if(is_null($ues)){
					}else{
						foreach($ues as $ue){
							echo '<div class="evento"><span>'.$ue->getTitulo().'</span>
                        	<a href="evento/'.$uc->generarURLEvento($ue).'"><img src="'.$ue->getAfiche().'" alt=""></a>
                        </div>';
						}
					}
					?>
                    	
                  
                </div>
                
                