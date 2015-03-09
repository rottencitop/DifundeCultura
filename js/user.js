// JavaScript Document
$(document).on("ready",function(){
	
	$("#navartista ul li:not(#sep)").tipsy({gravity: 'n'});
	$("#ultimosPosts article").tipsy({gravity:'n', html:true});
	$("#ingresaFB").tipsy({gravity:'e',html:true});
	
	$(".evento").on("click",function(){
		var x = $(this).find("img").first();
		if(x.css("display") == "none"){
			x.css("display","block");
		}else{
			x.css("display","none");
		}
	});
	
	$("#lupa").on("click", function(){
		$("#contBuscador input").fadeIn(400).focus();
	});
	
	$("#buscarArtista").on("keyup",function(){
		var x = $(this).val();
		if(x!=""){
			var data = {'palabra':x, 'view':18};
			$.ajax({
				url: "viewmore.php",
				data:data,
				type:"post",
				dataType:"json",
				beforeSend: function(){
					$("#resultadoBusquedaInner").html('<div class="loader" style="display:table;"></div>');
					$("#resultadoBusquedaWrapper").slideDown("slow");
				},
				success:function(data){
					$(".loader").slideUp("fast");
					$("#resultadoBusquedaInner").html("");
					if(data.length){
						$.each(data,function(i){
							$("#resultadoBusquedaInner").append('<a href="'+data[i].url+'">'+data[i].nombre+'</a>');
						});
					}else{
						$("#resultadoBusquedaInner").html('<div class="nopost">No se encontraron resultados con: '+x+'</div>');
					}
				}
			});
		}else{
			$("#resultadoBusquedaWrapper").slideUp("slow");
		}
	});
	
	$("#buscarArtista").on("blur",function(){
		$("#resultadoBusquedaWrapper").slideUp("slow");
	});
		
	$("nav ul li:not(:first,:last)").on("click",function(){
		var e = $(this);
		var table = parseInt(e.attr("data-table"));
		var div = $(e.attr("data-div")); 
		if(div.is(":hidden")){
			$(".resNav").slideUp("fast");
			div.slideDown("slow");
		}
		
	});
	
	$(".dialog").dialog({
		modal:true,
		show:"fade",
		hide:"fade",
		resizable:false,
		draggable: false,
		autoOpen: false
	});
	
	$("nav ul li:last").on("click",function(){
		$("#contacto").dialog("open");
	});
	$("#formContacto").on("submit",function(e){
		e.preventDefault();
		var form = $(this);
		var codVal = $("#codVal").val();
		var codValReal = $("#codValReal").val();
		if(codVal == codValReal){
			var data = form.serialize();
			$.ajax({
				url: "contactar.php",
				data:data,
				type:"post",
				dataType:"json",
				beforeSend: function(){
					form.css("opacity",0.3);
				},
				success: function(data){
					if(data.success){
						alert("Correo de contacto enviado correctamente");
						$("#contacto").dialog("close");
					}else{
						alert("Error el enviar correo de contacto");
					}
				}
			});
		}else{
			alert("Error en el código de validación");
		}
	});
	
	$(".resNavGenero ul li").on("click",function(){
		$("#resultadosBusq").html("");
		var table = parseInt($(this).attr("data-table"));
		var genero = $(this).attr("data-genero");
		var view = 14;
		var tipo;
		switch(table){
			case 1: tipo = "Conciertos";
				break;
			case 2: tipo = "Discos";
				break;
		}
		var data = {'table':table, 'genero':genero,'view':view};
		$.ajax({
			url: 'viewmore.php',
			type:"post",
			data:data,
			dataType:"json",
			beforeSend: function(){
				$("#resultadosBusq").html("<div class='loader' style='display:table;'></div>");
				$("#outBusqueda h2").text("Buscar "+tipo+" por Género: "+genero);
				$("#outBusqueda").fadeIn("fast");
			},
			success: function(data){
				$("#resultadosBusq .loader").slideUp("slow");
				if(data.length){
					console.log(data);
					$.each(data,function(i){
						var img;
								if(typeof data[i].post.imagenP == "undefined")
								 	img = data[i].post.imagen;
								else
								     img = data[i].post.imagenP;
						$("#resultadosBusq").append('<a href="'+ data[i].url +'"><div class="resultado"><div class="resultadoimg"><img src="'+img+'" alt=""></div><div class="resultadoinfo"><h5>Título: '+data[i].post.nombre+'</h5><h5>Artista: '+data[i].post.artista+'</h5><h5>Likes: '+data[i].mg+'</h5></div></div></a> ');
					});
				}else{
					$("#resultadosBusq").html('<div class="nopost" style="width:95%;">No se han encontrado resultados.</div>');
				}
			}
		});
	});
	
	$(".resNavABC ul li").on("click",function(){
		
		var table = parseInt($(this).attr("data-table"));
		var letra = $(this).attr("data-letra");
		var view = 15;
		var data = {'table':table, 'letra':letra,'view':view};
		var tipo;
		switch(table){
			case 1: tipo = "Conciertos";
				break;
			case 2: tipo = "Discos";
				break;
			case 3: tipo = "Libros";
				break;
		}
		$.ajax({
			url: 'viewmore.php',
			type:"post",
			data:data,
			dataType:"json",
			beforeSend: function(){
				$("#resultadosBusq").html("<div class='loader' style='display:table;'></div>");
				$("#outBusqueda h2").text("Buscar "+tipo+" por Letra: "+letra);
				$("#outBusqueda").fadeIn("fast");
			},
			success: function(data){
				$("#resultadosBusq .loader").slideUp("slow");
				if(data.length){
					console.log(data);
					$.each(data,function(i){
						var img;
								if(typeof data[i].post.imagenP == "undefined")
								 	img = data[i].post.imagen;
								else
								     img = data[i].post.imagenP;
						$("#resultadosBusq").append('<a href="'+ data[i].url +'"><div class="resultado"><div class="resultadoimg"><img src="'+img+'" alt=""></div><div class="resultadoinfo"><h5>Título: '+data[i].post.nombre+'</h5><h5>Artista: '+data[i].post.artista+'</h5><h5>Likes: '+data[i].mg+'</h5></div></div></a> ');
					});
				}else{
					$("#resultadosBusq").html('<div class="nopost" style="width:95%;">No se han encontrado resultados.</div>');
				}
			}
		});
	});
	
	$(".ooart").on("click",function(){
			if(!$(this).hasClass("ooartactive")){
				$(".ooart").removeClass("ooartactive");
				$(this).addClass("ooartactive");
				var vermas = $(".vermaspostartista");	
				var artista = $(this).attr("data-art");
				var table = $(this).attr("data-table");
				var div;
				switch(parseInt(table)){
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
				var data = {'artista':artista,'tabla':parseInt(table),'view':1};
				$.ajax({
					url:'../viewmore.php',
					type:'POST',
					data:data,
					dataType:"json",
					beforeSend: function(){
						$("#publicaciones").css('opacity',0.3);
					},
					success: function(data){
						$("#publicaciones").css('opacity',1);
						
						if(data.length){
							var masPost = verSiHayMasPost(4,parseInt(table),artista,"call");
							if(data.length >= 4 && masPost){
								vermas.attr("data-post",4);
								vermas.slideDown("fast");
								console.log($(".vermaspostartista").attr("data-post"));
							}
							else{
								$(".vermaspostartista").slideUp("fast");
							}
							$("#publicaciones").html(div);
							$.each(data,function(i){
								var img;
								if(typeof data[i].post.imagenP == "undefined")
								 	img = data[i].post.imagen;
								else
								     img = data[i].post.imagenP;
								$("#publicaciones").append('<a href="'+data[i].url+'"><div class="postart"><div class="postartimg"><img src="'+ img +'" alt=""></div><div class="postarttitle"><strong>'+data[i].post.artista+' - '+data[i].post.nombre+'</strong></div></div></a> ');
							});
						}else{
							$("#publicaciones").html('<div class="nopost">No hay publicaciones todavía, pronto habrá contenido para esta página.<br> Vuelve pronto o elige otra opción en el menú superior.</div>');
						}
					}
				});
			}
	});
	
	$(".vermaspost").on("click",function(){
		var post = $(this).attr("data-post");
		var table = $(this).attr("data-table");
		var div = $(this).attr("data-div");
		var loader = $(this).prev('.loader');
		var capa = $(this);
		var data = {'post':parseInt(post), 'tabla':parseInt(table), 'view':2};
		$.ajax({
			url:'viewmore.php',
			data:data,
			type:'post',
			dataType:"json",
			beforeSend: function(){
				loader.slideDown("slow");
				$(div).css('opacity',0.3);
			},
			success: function(data){
				$(div).css('opacity',1);
				if(data.length){
					var inicio = parseInt(post) + data.length;
					var masPost = verSiHayMasPost(inicio,table);
					loader.slideUp("slow");
					if(data.length == 4 && masPost){
						capa.attr("data-post",parseInt(post)+4);
						}
						else{
							capa.slideUp("fast");
						}
					$.each(data,function(i){
						$(div).append('<div class="post"><a href="'+ data[i].url +'"><div class="imgpost"><img src="'+ data[i].post.imagenP +'" alt=""><div class="infopost"><div class="wrapperip"><div class="likespost">'+data[i].likes+'</div><div class="comentariospost">'+ data[i].comments +'</div></div></div></div><h3>'+ data[i].post.nombre +' - '+ data[i].post.artista +'</h3></a></div> ');
					});
					
				}	
			}
		});
	});
	
	$(".vermaspostartista").on("click",function(){
		var post = parseInt($(this).attr("data-post"));
		var table = parseInt($(this).attr("data-table"));
		var artista = $(this).attr("data-artista");
		var div = $("#publicaciones");
		var loader = $(this).prev('.loader');
		var capa = $(this);
		var data = {'post':post, 'tabla':table,'view':4,'artista':artista};
		$.ajax({
			url:'../viewmore.php',
			data:data,
			type:'post',
			dataType: 'json',
			beforeSend: function(){
				loader.slideDown("slow");
				$(div).css('opacity',0.3);
			},
			success: function(data){
				$(div).css('opacity',1);
				if(data.length){
					var inicio = parseInt(post) + data.length;
					var masPost = verSiHayMasPost(inicio,table,artista,"call");
					loader.slideUp("slow");
					if(data.length == 4 && masPost){
						capa.attr("data-post",parseInt(post)+4);
					}
					else{
						capa.slideUp("fast");
					}
					$.each(data,function(i){
						var img;
								if(typeof data[i].post.imagenP == "undefined")
								 	img = data[i].post.imagen;
								else
								     img = data[i].post.imagenP;
								$("#publicaciones").append('<a href="'+data[i].url+'"><div class="postart"><div class="postartimg"><img src="'+ img +'" alt=""></div><div class="postarttitle"><strong>'+data[i].post.artista+' - '+data[i].post.nombre+'</strong></div></div></a> ');
					});
				}
			}
		});
	});
	
	
	
});

function verSiHayMasPost(post,tabla,artista,call){
	var data= {'post':post,'tabla':tabla,'view':3,'artista':artista};
	if(typeof call == "undefined"){
		var url = "viewmore.php";
	}else{ 
	var url = "../viewmore.php";
	}
	console.log(data);
	var r = false;
	$.ajax({
		url: url,
		data:data,
		async:false,
		type: 'post',
		dataType:"json",
		success: function(data){
			console.log(data);
			r = data.success;
		}
	});
	return r;
}