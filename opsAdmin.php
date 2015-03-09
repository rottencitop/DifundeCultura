<?php
require_once("controller/AdminC.php");
require_once("controller/UserC.php");
$ac = new AdminC();
$users = $ac->verTodoslosUsuarios();
$profiles = $fb->verPerfilesdeUsuarios($users);
$edcs = $ac->verErroresdeConciertos();
$edds = $ac->verErroresdeDiscos();
$edls = $ac->verErroresdeLibros();
$rs = $ac->verRecomendaciones();
?>
<div id="optionadmin1" class="dialogadmin" title="Agregar un Artista">
	<form id="formAddArtista" method="post" action="post.php" enctype="multipart/form-data">
    	<label>Tipo Artista:</label>
        <div class="cbform"><input type="checkbox" name="tipo[]" value="Musica">Música</div>
        <div class="cbform"><input type="checkbox" name="tipo[]" value="Lectura">Lectura</div>
    	<label>Nombre:</label>
    	<input type="text" name="nombre" placeholder="Ingrese nombre" required>
        <label>Reseña:</label>
        <textarea name="resena" placeholder="Ingrese una breve reseña del Artista"></textarea>
        <label>Página Web:</label>
        <input name="web" type="text" placeholder="Ingrese Página Web">
        <label>Facebook:</label>
        <input name="facebook" type="text" placeholder="Ingrese Facebook">
        <label>Twitter:</label>
        <input name="twitter" type="text" placeholder="Ingrese Twitter">
        <label>Wikipedia:</label>
        <input name="wiki" type="text" placeholder="Ingrese Wikipedia">
        <label>Soundcloud:</label>
        <input name="soundcloud" type="text" placeholder="Ingrese Soundcloud">
        <label>Imagenes:</label>
        <input name="imagenes[]" type="file" multiple required>
        <label>Género:</label>
        <div id="viewgeneros"><?php
			$generos = $ac->verGeneros();
			if(!is_null($generos)){
				foreach($generos as $genero){
				echo '<div class="cbform"><input type="checkbox" name="generos[]" value="'.$genero.'">'.$genero.'</div>';
			}
			}else{
				echo 'No hay generos, agrega uno.';
			}
		?></div>
        <div id="addGenero" style="padding:0.1em; background:#f3f3f3; border:1px solid #dadada; cursor:pointer; border-radius:2px;">No existe el Género? Agrégalo!</div>
        <input type="submit" name="artista" value="Agregar Artista">
    </form>
</div>
<div id="optionadmin2" class="dialogadmin" title="Agregar un Concierto">
	<form id="formAddConcierto">
    	<label>Nombre del Concierto:</label>
        <input name="nombre" type="text" placeholder="Ingrese nombre del concierto" required>
        <label>Artista:</label>
        <select name="artista">
        	<option value="null" selected>Elige un Artista</option>
            <?php 
				foreach($ac->verArtistasdeTipo("Musica") as $artista){
					echo '<option value="'.$artista.'">'.$artista.'</option>';
				}
			?>       
        </select>
        <div id="buttonAddArtista" style="margin-top:5px;padding:0.1em; background:#f3f3f3; border:1px solid #dadada; cursor:pointer; border-radius:2px;">No existe el Artista? Agrégalo!</div>

        <label>URL del Concierto:</label>
        <input name="youtube" type="text" placeholder="Ingrese URL del concierto" required>
        <label>Imagen:</label>
        <input name="imagen" type="file" required>
        <label>Descripción:</label>
        <textarea name="descripcion" placeholder="Ingrese una breve descripción del concierto"></textarea>
        <input type="submit" name="concierto" value="Agregar Concierto"> 
    </form>
</div>
<div id="optionadmin3" class="dialogadmin" title="Agregar un Disco">
	<form id="formAddDisco">
    	<label>Nombre del Disco:</label>
        <input name="nombre" type="text" placeholder="Ingrese nombre del Disco" required>
        <label>Artista:</label>
        <select name="artista">
        	<option value="NULL" selected>Elige un Artista</option>
            <?php
			foreach($ac->verArtistasdeTipo("Musica") as $artista){
					echo '<option value="'.$artista.'">'.$artista.'</option>';
				}
			?>
        </select>
        <label>URL de Descarga:</label>
        <input name="urldescarga" required type="text" placeholder="Ingrese URL de descarga del Disco">
        <label>URL de Compra:</label>
        <input name="urlcompra" type="text" placeholder="Ingrese URL de dompra del Disco">
        <label>Carátula:</label>
        <input name="caratula" type="file" required>
        <label>Imagen Portada:</label>
        <input name="imagen" type="file" required>
        <label>Descripción:</label>
        <textarea name="descripcion" placeholder="Ingrese una breve descripción del Disco"></textarea>
        <label>Tracklist:</label>
        <textarea name="tracklist" required placeholder="Ingrese una breve TrackList del Disco"></textarea>
        <input type="submit" value="Agregar Disco">
    </form>
</div>


<div id="optionadmin5" class="dialogadmin" title="Agregar Libro">
	<form id="formAddLibro">
    	<label>Nombre del Libro</label>
        <input name="nombre" type="text" placeholder="Ingrese nombre del Libro">
        <label>Autor:</label>
        <select name="artista">
        	<option selected>Elige un Autor</option>
            <?php
			foreach($ac->verArtistasdeTipo("Lectura") as $artista){
					echo '<option value="'.$artista.'">'.$artista.'</option>';
				}
			?>
        </select>
        <label>URL de Ver/Descargar:</label>
        <input name="urldescarga" required type="text" placeholder="Ingrese URL de descarga del Libro">
        <label>URL de Compra:</label>
        <input name="urlcompra" required type="text" placeholder="Ingrese URL de dompra del Libro">
        <label>Portada del Libro:</label>
        <input name="portada" required type="file">
        <label>Imagen Portada:</label>
        <input name="imagenp" type="file" required>
        <label>Descripción:</label>
        <textarea name="descripcion" placeholder="Ingrese una breve descripción del Libro"></textarea>
        <input type="submit" value="Agregar Libro">
    </form>
</div>

<div id="optionadmin6" class="dialogadmin">
	<form id="formAddEvento">
    	<label>Título del Evento:</label>
        <input name="titulo" required type="text" placeholder="Ingrese título del Evento">
        <label>Artístas del Evento:</label>
        <textarea name="artistas" required placeholder="Ingrese los artistas que estarán en el evento"></textarea>
        <label>Fecha:</label>
        <input name="fecha" required type="text" placeholder="Ingrese Fecha. Formato: AAAA-MM-DD">
        <label>Hora:</label>
        <input name="hora" required type="text" placeholder="Ingrese Hora. Formato: hh.mm">
        <label>Lugar:</label>
        <input name="lugar" required type="text" placeholder="Ingrese lugar del Evento">
        <label>Precio:</label>
        <input name="precio" required type="text" placeholder="Ingrese precio del Evento">
        <label>URL del Evento:</label>
        <input name="url" type="text" placeholder="Ingrese URL del Evento">
        <label>Afiche:</label>
        <input name="afiche" required type="file">
        <label>Información extra:</label>
        <textarea name="informacion" placeholder="Ingrese información extra sobre el evento"></textarea>
        <input type="submit" value="Agregar Evento">
    </form>
</div>

<div id="optionadmin7" class="dialogadmin">
	<div class="wrapperdialog">
    	<div class="tituloSeccionWhite">Errores de Conciertos</div>
        <?php
		if(!is_null($edcs)){
			foreach($edcs as $v){
				$id = $v['post'];
				settype($id,"int");
				$x = $uc->verConcierto($id);
				echo '<div class="error">
        	<div class="delete" data-type="2" data-id="'.$v['id'].'" title="Eliminar"></div>
			<a href="concierto/'.$uc->generarURLPost($x).'">
        	<div class="errorid">#'.$v['id'].' |</div>
            <div class="errorpost">Post: '.$v['post'].' | '.$v['artista'].' - '.$v['nombre'].'</div>
            <div class="errormensaje">'.$v['mensaje'].'</div>
			<div>Por: <strong>'.$fb->verUserFB($v['usuario']).'</strong></div>
        </a></div> ';
			}
		}else{
			echo '<div class="nopost">No hay errores para conciertos</div> ';
		}
		?>
        
        
        <div class="tituloSeccionWhite">Errores de Discos</div>
        <?php
		if(!is_null($edds)){
			foreach($edds as $v){
				$id = $v['post'];
				settype($id,"int");
				$x = $uc->verDisco($id);
				echo '<div class="error">
        	<div class="delete" data-type="2" data-id="'.$v['id'].'" title="Eliminar"></div>
			<a href="disco/'.$uc->generarURLPost($x).'">
        	<div class="errorid">#'.$v['id'].' |</div>
            <div class="errorpost">Post: '.$v['post'].' | '.$v['artista'].' - '.$v['nombre'].'</div>
            <div class="errormensaje">'.$v['mensaje'].'</div>
			<div>Por: <strong>'.$fb->verUserFB($v['usuario']).'</strong></div>
        </a></div> ';
			}
		}else{
			echo '<div class="nopost">No hay errores para discos</div>';
		}
		?>
        
        <div class="tituloSeccionWhite">Errores de Libros</div>
        <?php
		if(!is_null($edls)){
			
			foreach($edls as $v){
				$id = $v['post'];
				settype($id,"int");
				$x = $uc->verLibro($id);
				echo '<div class="error">
        	<div class="delete" data-type="2" data-id="'.$v['id'].'" title="Eliminar"></div>
			<a href="libro/'.$uc->generarURLPost($x).'">
        	<div class="errorid">#'.$v['id'].' |</div>
            <div class="errorpost">Post: '.$v['post'].' | '.$v['artista'].' - '.$v['nombre'].'</div>
            <div class="errormensaje">'.$v['mensaje'].'</div>
			<div>Por: <strong>'.$fb->verUserFB($v['usuario']).'</strong></div>
        </a></div> ';
			}
		}else{
			echo '<div class="nopost">No hay errores para libros</div>';
		}
		?>
        
    </div>
</div>
<div id="optionadmin8" class="dialogadmin">
	<div class="wrapperdialog">
    <?php 
	foreach($profiles as $p){
		echo '<div class="fbuseradmin">
			<a href="'.$p['link'].'" target="_blank">
        	<div class="fbuseradminimg"><img src="'.$p['picture']['data']['url'].'" alt=""></div>
            <div class="fbuseradmininfo">
            	<h5>'.$p['name'].'</h5>
            </div>
			</a>
        </div> ';
	}
	?>   
    </div>
</div>
<div id="optionadmin9" class="dialogadmin">
	<div class="wrapperdialog">
    	<?php 
		if(!is_null($rs)){
			$i = 1;
			foreach($rs as $r){
				echo '<div class="recomendacion">
				<div class="delete" data-type="1" data-id="'.$r->getId().'" title="Eliminar"></div>
				<div class="recomendacionid">#'.$i.' | </div>
				<div class="recomendacionuser">'.$fb->verUserFB($r->getUsuario()).' | </div>
				<div class="recomendaciontipo">'.$r->getTipo().'</div>
				<div class="recomendaciontitulo">'.$r->getTitulo().'</div>
				<div>'.$r->getMensaje().'</div>
				</div>';
				$i++;
			}
		}else{
			echo '<div class="nopost">No hay recomendaciones todavía</div>';
		}
		?>
    </div>
</div>
