<?php
require_once("controller/FuncionesC.php");
$fc = new FuncionesC();
?>
<div id="outBusqueda">
        <div id="wrapperBusqueda">
        	<div id="innerBusqueda">
            	<div id="close"></div>
            	<h2>Buscar Concierto por: A</h2>
                <div id="resultadosBusq">
                	
                </div>
            </div>
        </div>
	</div>
<header>
        	<section id="miniRedesSociales">
            	<div id="contMiniRedesSociales">
                	<a href="https://www.facebook.com/DifundeCultura" target="_blank"><div class="miniRedSocial fb">/DifundeCultura</div></a>
                	<a href="https://twitter.com/dculturacom" target="_blank"><div class="miniRedSocial tw">@DifundeCultura</div></a>
                </div>
            </section>
        	<div id="logo">
            </div>
            <nav>
            	<ul>
                	<a href="../index.php"><li>Inicio</li></a><li data-table="1" data-div=".opm1">Conciertos</li><li data-table="2" data-div=".opm2">Discos</li><li data-table="3" data-div=".opm3">Libros</li><li>Contacto</li>
                </ul>
                <div id="lupa">
                	<div id="contBuscador"><input id="buscarArtista" type="text" placeholder="Buscar Artista..." autofocus>
                        <div id="resultadoBusquedaWrapper">
                            <div id="resultadoBusquedaInner">
                            </div>
                        </div>
                    </div>
                </div>
            </nav>  
            
            <div class="resNav opm1">
            	<div class="resNavGenero">
                	<div class="tituloSeccionMenu"><span>Por</span> Géneros</div>
                    <ul>
                    	<?php
						foreach($uc->verGeneros() as $genero){
							echo "<li data-genero='$genero' data-table='1'>$genero</li> ";
						}
                        ?>
                    	
                    </ul>
                </div>
                <div class="resNavABC">
                	<div class="tituloSeccionMenu"><span>Por Orden</span> Alfabético</div>
                    <ul>
                    	<?php
						foreach($fc->ABC() as $abc){
							echo "<li data-letra='$abc' data-table='1'>$abc</li> ";
						}
                        ?>
                    </ul>
                </div>
            </div>
            <div class="resNav opm2">
            	<div class="resNavGenero">
                	<div class="tituloSeccionMenu"><span>Por</span> Géneros</div>
                    <ul>
                    	<?php
						foreach($uc->verGeneros() as $genero){
							echo "<li data-genero='$genero' data-table='2'>$genero</li> ";
						}
                        ?>
                    	
                    </ul>
                </div>
                <div class="resNavABC">
                	<div class="tituloSeccionMenu"><span>Por Orden</span> Alfabético</div>
                    <ul>
                    	<?php
						foreach($fc->ABC() as $abc){
							echo "<li data-letra='$abc' data-table='2'>$abc</li> ";
						}
                        ?>
                    </ul>
                </div>
            </div>  
            
           <div class="resNav opm3">
                <div class="resNavABC">
                	<div class="tituloSeccionMenu"><span>Por Orden</span> Alfabético</div>
                    <ul>
                    	<?php
						foreach($fc->ABC() as $abc){
							echo "<li data-letra='$abc' data-table='3'>$abc</li> ";
						}
                        ?>
                    </ul>
                </div>
            </div>         
        </header>
        <div id="contacto" class="dialog" title="Formulario de Contacto">
	<?php 
	$str = date('h:m');
	$cod = substr(sha1(microtime()),0,5);
	?>
	<form id="formContacto">
    	<label>Nombre:</label>
        <input type="text" name="nombre" required>
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Asunto:</label>
        <input type="text" name="asunto" required>
        <label>Mensaje:</label>
        <textarea name="mensaje" required></textarea>
        <label>Código de Validación de Formulario: <strong><?php echo $cod; ?></strong></label>
        <input id="codVal" type="text" name="codigoval" required>
        <input id="codValReal" type="hidden" value="<?php echo $cod; ?>">
        <input type="submit" name="enviar" value="Enviar">
    </form>
</div>