$(document).on("ready",function(){
	$("#admin ul li").tipsy({gravity: 'n', title: 'data-title'});
	$(".delete").tipsy({gravity:'n'});
	
	$("#comentarios").on("click",'.removeComment',function(){
			var parent = $(this).parent(".wrappercomentario");
			var id = parseInt($(this).attr("data-idcomentario"));
			var data = {'id':id, 'view' : 4};
			if(confirm("Quieres eliminar el Comentario?")){
				$.ajax({
				url: '../add.php',
				data:data,
				type:"post",
				dataType:"json",
				success: function(data){
					if(data.success){
						parent.slideUp("slow");
					}else{
						alert("Error al eliminar Comentario");
					}
				}
			});
			}
	});
	
	$(".opcionadmin").on("click",function(){
			
			var div = $(this).attr("data-div");
			var title = $(this).attr("data-title");
			var capa = "#optionadmin"+div;
			$(capa).dialog("option","title",title);
			$(capa).dialog("open");
			var form = $(capa).find("form").height();
			var div2 = $(capa).find(".wrapperdialog").height();
			if(form != null){
				if(form < 550){
					form+=70;
					$(capa).dialog("option","height",form);
				}
			}else{
				if(div2 < 550){
					div2+=70;
					$(capa).dialog("option","height",div2);
				}
			}
			
			
		});
		
		$(".dialogadmin").dialog({
			autoOpen: false,
			modal:true,
			width: 500,
			height:550,
			maxHeight:550,
			resizable:false,
			draggable:false,
			show: "fade",
			hide : "clip"
		});
		
		$(".btnRemove:not(.removeEvento)").on("click",function(){
			if(confirm("Estas seguro de eliminar esta publicación?")){
				var post = parseInt($(this).attr("data-post"));
				var data = {'post':post,'view':5};
				$.ajax({
					url: '../add.php',
					dataType:"json",
					type:"post",
					data:data,
					success: function(data){
						if(data.success){
							alert("Post eliminado exitosamente");
							location.href = "http://www.difundecultura.com";
						}else{
							alert("Error al eliminar el Post");
						}
					}
				});
			}
		});
		
		$(".removeEvento").on("click",function(){
			if(confirm("Estas seguro de eliminar este evento?")){
				var post = parseInt($(this).attr("data-post"));
				var data = {'post':post,'view':6};
				$.ajax({
					url: '../add.php',
					dataType:"json",
					type:"post",
					data:data,
					success: function(data){
						if(data.success){
							alert("Evento eliminado exitosamente");
							location.href = "http://www.difundecultura.com";
						}else{
							alert("Error al eliminar el Evento");
						}
					}
				});
			}
		});
		
		$("#formAddArtista").on("submit",function(e){
			e.preventDefault();
			var form = $(this);
			var formdata = false;
			if (window.FormData){
				formdata = new FormData(form[0]);
			}
			formdata.append('add',1);
			
			$.ajax({
				url         : 'add.php',
				data        : formdata,
				cache       : false,
				contentType : false,
				processData : false,
				beforeSend: function(){
					form.css("opacity",0.4);
					form.find('input:last').attr("disabled",true);
				},
				type        : 'POST',
				success     : function(data, textStatus, jqXHR){
					$("#res").html(data);
					form.css("opacity",1);
					var d = form.parent(".dialogadmin");
					d.dialog("close");
					form.find('input:last').attr("disabled",false);
				}
			});
		});
		
		$("#formAddConcierto").on("submit",function(e){
			e.preventDefault();
			var form = $(this);
			var formdata = false;
			if (window.FormData){
				formdata = new FormData(form[0]);
			}
			formdata.append('add',2);
			
			$.ajax({
				url         : 'add.php',
				data        : formdata,
				cache       : false,
				contentType : false,
				processData : false,
				beforeSend: function(){
					form.css("opacity",0.4);
					form.find('input:last').attr("disabled",true);
				},
				type        : 'POST',
				success     : function(data, textStatus, jqXHR){
					alert(data);
					form.css("opacity",1);
					var d = form.parent(".dialogadmin");
					d.dialog("close");
					form.find('input:last').attr("disabled",false);
				}
			});
		});
		
		$("#formAddDisco").on("submit",function(e){
			e.preventDefault();
			var form = $(this);
			var formdata = false;
			if (window.FormData){
				formdata = new FormData(form[0]);
			}
			formdata.append('add',3);
			
			$.ajax({
				url         : 'add.php',
				data        : formdata,
				cache       : false,
				contentType : false,
				processData : false,
				beforeSend: function(){
					form.css("opacity",0.4);
					form.find('input:last').attr("disabled",true);
				},
				type        : 'POST',
				success     : function(data, textStatus, jqXHR){
					alert(data);
					form.css("opacity",1);
					var d = form.parent(".dialogadmin");
					d.dialog("close");
					form.find('input:last').attr("disabled",false);
				}
			});
		});
		
		
		$("#formAddLibro").on("submit",function(e){
			e.preventDefault();
			var form = $(this);
			var formdata = false;
			if (window.FormData){
				formdata = new FormData(form[0]);
			}
			formdata.append('add',5);
			
			$.ajax({
				url         : 'add.php',
				data        : formdata,
				cache       : false,
				contentType : false,
				processData : false,
				beforeSend: function(){
					form.css("opacity",0.4);
					form.find('input:last').attr("disabled",true);
				},
				type        : 'POST',
				success     : function(data, textStatus, jqXHR){
					alert(data);
					form.css("opacity",1);
					var d = form.parent(".dialogadmin");
					d.dialog("close");
					form.find('input:last').attr("disabled",false);
				}
			});
		});
		
		$("#formAddEvento").on("submit",function(e){
			e.preventDefault();
			var form = $(this);
			var formdata = false;
			if (window.FormData){
				formdata = new FormData(form[0]);
			}
			formdata.append('add',6);
			
			$.ajax({
				url         : 'add.php',
				data        : formdata,
				cache       : false,
				contentType : false,
				processData : false,
				beforeSend: function(){
					form.css("opacity",0.4);
					form.find('input:last').attr("disabled",true);
				},
				type        : 'POST',
				success     : function(data, textStatus, jqXHR){
					$("#res").html(data);
					form.css("opacity",1);
					var d = form.parent(".dialogadmin");
					d.dialog("close");
					form.find('input:last').attr("disabled",false);
				}
			});
		});
		
		$("#addGenero").on("click",function(){
			var g = prompt("Ingrese nombre del Género");
			var data = {'genero': g, 'add' : 4};
			var id = $(this);
			$.ajax({
				url:"add.php",
				type:"post",
				data:data,
				success: function(data){
					alert(data);
					var data2 = {'view':1};
					$.ajax({
						url: "add.php",
						type:"post",
						data:data2,
						success: function(data2){
							$("#viewgeneros").html(data2);
						}
						
					});
				}
			});
		});
		
		$("#buttonAddArtista").on("click",function(){
			var id = $(this);
			id.parent("form").parent(".dialogadmin").dialog("close");
			$("#optionadmin1").dialog("open");
		});
		
		$("#close").on("click",function(){
			$("#outBusqueda").fadeOut("fast");
		});
		
		$(".delete").on("click",function(){
			var type = parseInt($(this).attr("data-type"));
			var id = parseInt($(this).attr("data-id"));
			var div = $(this).parent("div");
			var view;
			if(type == 1){
				view = 2;
			}else{
				view = 3;
			}
			var data = {"id" : id, "view":view};
			//.css("display","none");
			$.ajax({
				url: 'add.php',
				type:'post',
				data: data,
				success: function(data){
					div.css("display","none");
					alert(data);
				}
				
			});
		});
});
