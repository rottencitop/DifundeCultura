<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>#difundecultura</title>
<link href="styles/normalize.css" type="text/css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900|Oswald:400,300,700|Alegreya+Sans+SC:400,300,700|Exo+2:400,500italic,200,300|Lato:100|Raleway:200,300' rel='stylesheet' type='text/css'>
<link href="styles/style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
<script src="http://malsup.github.com/jquery.cycle2.js"></script>
<script type="text/javascript">
	$(document).on("ready", function(){
		
		
		$("#lupa").on("click", function(){
			$("#contBuscador input").fadeIn(400).focus();
		});
		
		$("nav ul li").on("click",function(){
			$("#resNav").slideToggle("slow");
		});
		
		$(".evento").on("click",function(){
			var x = $(this).find("img").first();
			if(x.css("display") == "none"){
				x.css("display","block");
			}else{
				x.css("display","none");
			}
		});
		
		$("#wrapperprofile").on("click",function(){
			var x = $("#infoprofile");
			if(x.css("display") == "none"){
				$(this).css("background-image","url(images/profileup.png)");
			}else{
				$(this).css("background-image","url(images/profiledown.png)");
			}
			x.slideToggle("slow");
		});
		
		
		
	});
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
        
        <section id="container">
        
        	
            <?php include('last.php'); ?>
            <section id="contenidos">
            	
            </section>
            <aside id="menus">
            	<?php include('menu.php'); ?>     
            </aside>
            
            <?php include('footer.php'); ?>
        </section>
    </div> 
    
</body>
</html>