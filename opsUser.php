<?php

$eqas = $uc->verEventosqueAsistire($user);
?>
<div id="wrapperlikes">
	<div id="conciertoslikes" class="dialoglikes" title="Conciertos que me gustan">
    	<div class="innerdialoglike">
        	
        </div>
    </div>
    <div id="discoslikes" class="dialoglikes" title="Discos que me gustan">
    	<div class="innerdialoglike">
        
        </div>
    </div>
    <div id="libroslikes" class="dialoglikes" title="Libros que me gustan">
    	<div class="innerdialoglike">
       
        </div>
    </div>
    <div id="eventosasistencia" class="dialoglikes" title="Eventos que asistiré">
    	<div class="innerdialoglike">
        	<?php
			if(!is_null($eqas)){
				foreach($eqas as $e){
					echo '<div class="eventoqueasistire" title="<img src=\''.$e->getAfiche().'\' width=\'200\'>">
            	<a href="evento/'.$uc->generarURLEvento($e).'"><h4>'.$e->getTitulo().'</h4>
                <h5>Fecha: '.$e->getFecha().' | Hora: '.$e->getFecha().' hrs</h5></a>
            </div> ';
				}
			}else{
				echo '<div class="nopost">No asistiré a ningun evento.</div>';
			}
			?>
        </div>
    </div>
    
</div>