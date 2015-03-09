$(document).on("ready",function(){
	
	$(".dialoglikes").dialog({
		width: 800,
		height: 500,
		modal: true,
		resizable: false,
		draggable:false,
		autoOpen:false,
		show:'fade',
		hide:'clip'
	});
	
	$(".btnParticipantes").on("click",function(){
		var e = parseInt($(this).attr("data-evento"));
		var view = 17;
		var data = {'evento':e,'view':view};
		$("#participantes").dialog("open");
		$.ajax({
			url: "../viewmore.php",
			data:data,
			type:"post",
			dataType:"json",
			beforeSend: function(){
				$("#innerparticipantes").html('<div class="loader" style="display:table;"></div>');
			},
			success: function(data){
				$("#innerparticipantes").html("");
				if(data.length){
					$.each(data,function(i){
						$("#innerparticipantes").append('<a href="'+data[i].url+'" target="_blank"><div class="asistenteevento"><div class="asistenteeventoimg"><img src="'+data[i].imagen+'"></div> <div class="asistenteeventoinfo">'+data[i].nombre+'</div></div></a> ');
					});
				}else{
					$("#innerparticipantes").html('<div class="nopost">Ningún usuario irá todavía.</div>');
				}
			}
		});
	});
	
	$("#participantes").dialog({
			autoOpen:false,
			modal:true,
			width: 450,
			height:300,
			maxHeight:300,
			resizable:false,
			draggable:false,
			show: "fade",
			hide : "clip"
		});
	
	
	$("#myoptions ul li").tipsy({gravity: 'n'});
	$(".eventoqueasistire").tipsy({gravity: 'n', html:true});
	$("#useroptions ul li").tipsy({gravity : 'n'});
	$(".optionsuserperfil:not(:last)").on("click",function(){
		$(".optionsuserperfil").removeClass("optact");
		$(this).addClass("optact");
		var div = $(this).attr("data-div");
		var wrapper = $(div).find(".innerdialoglike");
		var tabla = parseInt($(this).attr("data-op"));
		var user = $(this).attr("data-user");
		if(tabla == 1 || tabla == 2 || tabla == 3){
			var data = {'user':user,'tabla':tabla,'view':19};
			$.ajax({
				url: "viewmore.php",
				data:data,
				type:"post",
				dataType:"json",
				beforeSend: function(){
					wrapper.html("");
					wrapper.html('<div class="loader" style="display:table;"></div>');
					$(div).dialog("open");
				},
				success:function(data){
					$(".loader").slideUp("fast");
					if(data.length){
						
						
						$.each(data,function(i){
							var img;
						if(typeof data[i].post.imagenP == "undefined")
						 	img = data[i].post.imagen;
						else
						    img = data[i].post.imagenP;
							wrapper.append('<a href="'+data[i].url+'"><div class="postlike"><div class="postlikeimg"><img src="'+ img +'" alt=""></div><div class="wrapperpostlikenombre"><div class="postlikenombre">'+data[i].post.nombre+' - '+ data[i].post.artista +'</div></div></div></a> ');
						});	
					}else{
						wrapper.html('<div class="nopost">Ningún post me gusta.</div>');
					}
				}
			});
		}else{
			$(div).dialog("open");
		}
	});
	$(".botoncine, .botondisco, .botonvideo,.botonlibro").tipsy({gravity : 'n'});
	$("#myoptions ul li:not(:last)").on("click",function(){
		var div = $(this).attr("data-div");
		var wrapper = $(div).find(".innerdialoglike");
		var tabla = parseInt($(this).attr("data-op"));
		var user = $(this).attr("data-user");
		if(tabla == 1 || tabla == 2 || tabla == 3){
			var data = {'user':user,'tabla':tabla,'view':19};
			$.ajax({
				url: "viewmore.php",
				data:data,
				type:"post",
				dataType:"json",
				beforeSend: function(){
					wrapper.html("");
					wrapper.html('<div class="loader" style="display:table;"></div>');
					$(div).dialog("open");
				},
				success:function(data){
					$(".loader").slideUp("fast");
					if(data.length){
						
						
						$.each(data,function(i){
							var img;
						if(typeof data[i].post.imagenP == "undefined")
						 	img = data[i].post.imagen;
						else
						    img = data[i].post.imagenP;
							wrapper.append('<a href="'+data[i].url+'"><div class="postlike"><div class="postlikeimg"><img src="'+ img +'" alt=""></div><div class="wrapperpostlikenombre"><div class="postlikenombre">'+data[i].post.nombre+' - '+ data[i].post.artista +'</div></div></div></a> ');
						});	
					}else{
						wrapper.html('<div class="nopost">Ningún post me gusta.</div>');
					}
				}
			});
		}else{
			$(div).dialog("open");
		}
		
	});
	
	$("#navartista").on("mouseover",".siguiendoart",function(){
			if($(this).hasClass("siguiendoart"))
				$(this).text("Dejar de seguir");
		});
		
		$("#navartista").on("mouseleave",".siguiendoart",function(){
			if($(this).hasClass("siguiendoart"))
				$(this).text("Siguiendo a este Artista");
		});
		
		$("#navartista").on("click","#follow",function(){
			if($(this).hasClass("seguirart")){
				var btn = $(this);
				var user = btn.attr("data-user");
				var artista = btn.attr("data-artista");
				var view = 8;
				var data = {'user':user, 'artista':artista, 'view':view};
				$.ajax({
					url:"../viewmore.php",
					data:data,
					type: "post",
					dataType:"json",
					success: function(data){
						if(data.success){
							btn.removeClass("seguirart").addClass("siguiendoart");
							btn.text("Siguiendo a este artista");
						}
					}
				});
			}else{
				var btn = $(this);
				var user = btn.attr("data-user");
				var artista = btn.attr("data-artista");
				var view = 9;
				var data = {'user':user, 'artista':artista, 'view':view};
				$.ajax({
					url:"../viewmore.php",
					data:data,
					type: "post",
					dataType:"json",
					success: function(data){
						if(data.success){
							btn.removeClass("siguiendoart").addClass("seguirart");
							btn.text("Seguir a este artista");
						}
					}
				});
			}
		});
	
	
		
	$("#btnComentar").on("click",function(){
		var nC = $(".wrappercomentario").length;
		if(nC == 0){
			$(".nopost").remove();
			$("#comentarios h3").after("");
		}
		var user = $(this).attr("data-user");
		var post = parseInt($(this).attr("data-post"));
		var nombre = $(this).attr("data-nombre");
		var fecha = $(this).attr("data-fecha");
		var x = $("#makeComment").val();
		if(x != ""){
			var data = {'user':user,'post':post,'comentario':x, 'view':16};
			$.ajax({
				url: "../viewmore.php",
				data:data,
				dataType:"json",
				type:"post",
				beforeSend: function(){
					$("#comentarios").css("opacity",0.3);
				},
				success: function(data){
					$("#comentarios").css("opacity",1);
					if(data.success){
						var comment = '<div class="wrappercomentario"><div class="imgcomentario"><img src="https://graph.facebook.com/'+user+'/picture" alt=""></div> <div class="comentario"><h5>#'+(nC+1)+' - Publicado por <strong>'+nombre+'</strong> | '+fecha+'</h5><p>'+x+'</p></div></div>';
						$("#comentarios").append(comment);
						$("#wrapperMakeComment").css("display","none");
					}else{
						alert("Error al comentar");
					}
				}
			});
			
		}else{
			alert("Escribe un comentario");
		}
			
		});
		
	$("#infovideo,#infodisco,#infolectura").on("mouseover",'.ilike',function(){
		$(this).addClass("dontlike");
		$(this).html("Ya no me gusta");
	});
	
	$("#infovideo,#infodisco,#infolectura").on("mouseleave",'.ilike',function(){
		$(this).removeClass("dontlike");
		$(this).html("Me gusta");
	});
	
	$(".btnLike").on("mouseover",function(){
		if(!$(this).hasClass("ilike"))
			$(this).addClass("like")
	});
	
	$(".btnLike").on("mouseleave",function(){
		if(!$(this).hasClass("ilike"))
			$(this).removeClass("like")
	});
	
	$(".btnLike").on("click",function(){
		var likes = $("#clikes div");
		if(!$(this).hasClass("ilike")){	
			var uid = $(this).attr("data-uid");
			var post = $(this).attr("data-post");
			var data = {'uid':uid, 'post':post,'view':5};
			var div = $(this);
			$.ajax({
				url: "../viewmore.php",
				data:data,
				type:"post",
				dataType:"json",
				success: function(data){
					if(data.success){
						$(div).addClass("ilike");
						$(div).attr("title","Desmarcar Me Gusta");
						var x = likes.html();
						likes.html(parseInt(x)+1);
					}
				}
			});
		}else{
			var uid = $(this).attr("data-uid");
			var post = $(this).attr("data-post");
			var data = {'uid':uid, 'post':post,'view':6};
			var div = $(this);
			$.ajax({
				url: "../viewmore.php",
				data:data,
				type:"post",
				dataType:"json",
				success: function(data){
					if(data.success){
						$(div).attr("class","botonvideo btnLike");
						$(div).html("Me Gusta");
						$(div).attr("title","Marcar Me Gusta");
						var x = likes.html();
						likes.html(parseInt(x)-1);
					}
				}
			});
		}
	});
	
	$(".btnError").on("click",function(){
		$("#reportarError").dialog("open");
	});
	
	$("#formReportarError").on("submit",function(e){
		e.preventDefault();
		var data = $(this).serialize()+'&view=7';
		$.ajax({
			url: "../viewmore.php",
			data:data,
			type:"post",
			dataType:"json",
			success: function(data){
				if(data.success){
					alert("El error se envió correctamente");
					$("#reportarError").dialog("close");
				}
			}
		});
	});
	
	$(".vermaspostartistaquesigo").on("click",function(){
		var btn = $(this);
		var loader = btn.prev(".loader");
		var user = btn.attr("data-user");
		var post = parseInt(btn.attr("data-post"));
		var div = $(btn.attr("data-div"));
		var tabla = parseInt(btn.attr("data-table"));
		var view = 10;
		var data = {'user':user,'post':post,'tabla':tabla,'view':view};
		$.ajax({
			url: "viewmore.php",
			data:data,
			type:"post",
			dataType:"json",
			beforeSend: function(){
				div.css("opacity",0.3);
				loader.slideDown("slow");
			},
			success: function(data){
				if(data.length){
					div.css("opacity",1);
					var masPost = versiHaymasPosrArtistasqueSigo(tabla,post + 4,user);
					console.log(masPost);
					loader.slideUp("slow");
					if(data.length >= 4 && masPost){
						btn.attr("data-post",parseInt(post) + 4);
					}else{
						btn.slideUp("fast");
					}
					
					$.each(data,function(i){
						var img;
								if(typeof data[i].post.imagenP == "undefined")
								 	img = data[i].post.imagen;
								else
								     img = data[i].post.imagenP;
						
						$(div).append('<a href="'+data[i].url+'"><div class="postart"><div class="postartimg"><img src="'+img+'" alt=""></div><div class="postarttitle"><strong>'+data[i].post.artista+' - '+data[i].post.nombre+'</strong></div></div></a> ');
					});
				}
			}
		});
	});
	
	$("#infoevento").on("mouseover",".asistire",function(){
		if($(this).hasClass("asistire"))
			$(this).text("Cancelar asistencia");
	});
	
	$("#infoevento").on("mouseleave",".asistire",function(){
		if($(this).hasClass("asistire"))
			$(this).text("Asistiré");
	});
	
	$("#infoevento").on("click",".btnAsistir",function(){
		var e = $(this);
		var user = e.attr("data-user");
		var evento = e.attr("data-evento");
		if(!$(this).hasClass("asistire")){
			var view = 12;
			var data = {'user':user,'evento':evento,'view':view};
			$.ajax({
				url: '../viewmore.php',
				data:data,
				dataType:"json",
				type:"post",
				success: function(data){
					if(data.success){
						e.addClass("asistire");
						e.text("Asistiré");
					}
				}
			});
		}else{
			var view = 13;
			var data = {'user':user,'evento':evento,'view':view};
			$.ajax({
				url: '../viewmore.php',
				data:data,
				dataType:"json",
				type:"post",
				success: function(data){
					if(data.success){
						e.removeClass("asistire");
						e.text("Asistir");
					}
				}
			});
		}
	});
		
});

function versiHaymasPosrArtistasqueSigo(tabla,inicio,user){
	var res = false;
	var data = {'tabla':tabla, 'post':inicio, 'user':user, 'view':11};
	console.log(data);
	$.ajax({
		url: "viewmore.php",
		data:data,
		type:"post",
		dataType:"json",
		async:false,
		success: function(data){
			if(data.success){
				res = true;
			}
		}
	});
	
	return res;
}