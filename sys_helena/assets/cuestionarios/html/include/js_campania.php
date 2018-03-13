<script>
	function verCampanias(){
		$("#cam_tbody").html("");
	
		var jqxhr = $.ajax(  {
			type: "POST",
			dataType: "json",
			url: "galy/html/include/vw_campanias.php",
			data: { tipo: 1, subtipo: 1 }
		}).done(function( data, textStatus, jqXHR ) {
			
			$.each(data.cam, function( key, value ) {
				var e = "'"+value.nombre+"', '"+value.id+"'";
				var tr = document.createElement("tr");
				$(tr).append( Galy.getElemTxt("td", value.id.substring(0, 7)) );
				$(tr).append( Galy.getElemTxO("td", Galy.getElemA(value.nombre, "#bx_sub", "verSubCampania("+e+")")) );
				$(tr).append( Galy.getElemTxO("td", Galy.getElemLb(value.lb_clas, value.estatus)) );
				$(tr).append( Galy.getElemTxt("td", value.total) );
				var acc = Galy.getElem("td");
				$(acc).append( Galy.getElemB("primary", "edit", "ediCampania("+e+")", "Editar") );
				$(acc).append( Galy.getElemB("danger", "trash", "delCampania("+e+")", "Borrar") );
				$(tr).append( acc );
				$("#cam_tbody").append( tr );
			});
		}).fail(function(jqXHR, textStatus, errorThrown) {
			swal("", "Error al ver las campañas ("+errorThrown+").", "warning");
		});
	}
	
	function ediCampania(nombre, val, subtp, exVal){
		addCampania("Editar Campaña", ["Actualizar", "actualizo", "actualizada"], 3, nombre, val, subtp, exVal);
	}
	
	function addCampania(txt, txts, tp, nombre, val, subtp, exVal){
		if( typeof( txt ) == "undefined" || txt == null )
			txt = "Nueva campaña";
		if( typeof( txts ) == "undefined" || txts == null )
			txts = ["Agregar", "agrego", "agregada"];
		if( typeof( tp ) == "undefined" || tp == null )
			tp = 0;
		if( typeof( subtp ) == "undefined" || subtp == null )
			subtp = 1;
		if( typeof( val ) == "undefined" || val == null )
			val = "";
		if( typeof( exVal ) == "undefined" || exVal == null )
			exVal = "";
		if( typeof( nombre ) == "undefined" || nombre == null )
			nombre = "";
		
		
		swal({
		  title: txt,
		  input: 'text',
		  showCancelButton: true,
		  confirmButtonText: txts[0],
		  cancelButtonText: 'Cancelar',
		  showLoaderOnConfirm: true,
		  inputValue: nombre,
		  inputValidator: function (value) {
			return new Promise(function (resolve, reject) {
			  if (value) {
				resolve()
			  } else {
				reject('Necesitas escribir el nombre')
			  }
			})
		  },
		  preConfirm: function (nombre) {
			return new Promise(function (resolve, reject) {
				var jqxhr = $.ajax(  {
					type: "POST",
					dataType: "json",
					url: "galy/html/include/vw_campanias.php",
					data: { tipo: subtp, subtipo: tp, nombre: nombre, exNombre: val, exVal: exVal }
				}).done(function( data, textStatus, jqXHR ) {
					if( data.estatus == 3 ){
					  resolve();
					  if( subtp == 2 ){
						  verSubCampania(null, exVal);
					  }
					  
					  verCampanias();
					}else{
				  		reject("Error al "+txts[0]+" la campaña ("+data.text+").");
					}
				}).fail(function(jqXHR, textStatus, errorThrown) {
				  reject("Error al "+txts[0]+" la campaña ("+errorThrown+").");
				});
				// -----
				
			})
		  },
		  allowOutsideClick: false
		}).then(function (nombre) {
		  swal({
			type: 'success',
			title: '¡Se '+txts[1]+' con éxito!',
			html: 'Campaña '+txts[2]+': <strong>' + nombre + '</strong>'
		  })
		}).catch(swal.noop);
		
	}
	
	function delCampania(nombre, val, tp, exVal){
		if( typeof( tp ) == "undefined" || tp == null )
			tp = 1;
		switch(tp){
			case 1:
				nombre = "campaña";
				break;
			case 2:
				nombre = "cuestionario";
				break;
		}
			
		swal({
		  title: 'Eliminar ' + nombre,
		  html: '¿Realmente desea eliminar "<strong>' + nombre + '</strong>" ?',
		  showCancelButton: true,
		  confirmButtonText: 'Eliminar',
		  cancelButtonText: 'Cancelar',
		  showLoaderOnConfirm: true,
		  confirmButtonColor: '#d33',
		  preConfirm: function () {
			return new Promise(function (resolve, reject) {
				var jqxhr = $.ajax(  {
					type: "POST",
					dataType: "json",
					url: "galy/html/include/vw_campanias.php",
					data: { tipo: tp, subtipo: 2, nombre: val }
				}).done(function( data, textStatus, jqXHR ) {
					if( data.estatus == 3 ){
					  resolve();
					  if( tp == 2 ){
						  verSubCampania(null, exVal);
					  }
					  verCampanias();
					}else{
				  		reject("Error al eliminar la "+nombre+" ("+data.text+").");
					}
				}).fail(function(jqXHR, textStatus, errorThrown) {
				  reject("Error al eliminar la "+nombre+" ("+errorThrown+").");
				});
				// -----
			})
		  },
		  allowOutsideClick: false
		}).then(function () {
		  swal({
			type: 'success',
			title: '¡Se elimino con éxito!',
			html: 'Campaña eliminada: <strong>' + nombre + '</strong>'
		  })
		}).catch(swal.noop);
	}
	
	function verSubCampania(nombre, val){
		// Animacion
		$("#bx_cam").attr("class", "col-md-6 col-sm-6 col-xs-12");
		$("#bx_sub").css("display", "");
		
		// JS
		if( !(typeof( nombre ) == "undefined" || nombre == null) ){
			$("#lb_sub").html(nombre);
			$(".lb_cam").html(nombre);
		}
		$("#btn_subcam").attr("onClick", "addCampania('Nuevo Cuestionario', null, null, '', null, 2, '"+val+"');");
		$("#subcam_tbody").html("");	  
	
		var jqxhr = $.ajax(  {
			type: "POST",
			dataType: "json",
			url: "galy/html/include/vw_campanias.php",
			data: { tipo: 2, subtipo: 1, exNombre: val }
		}).done(function( data, textStatus, jqXHR ) {
			
			$.each(data.cam, function( key, value ) {
				var e = "'"+value.nombre+"', '"+value.id+"', 2, '"+val+"'";
				var tr = document.createElement("tr");
				$(tr).append( Galy.getElemTxO("td", Galy.getElemA(value.nombre, "#subcam_tbody", "verCuestionario("+e+")")) );
				$(tr).append( Galy.getElemTxt("td", value.total) );
				$(tr).append( Galy.getElemTxO("td", Galy.getElemLb(value.lb_clas, value.estatus)) );
				var acc = Galy.getElem("td");
				$(acc).append( Galy.getElemB("primary", "edit", "ediCampania("+e+")", "Editar") );
				$(acc).append( Galy.getElemB("danger", "trash", "delCampania("+e+")", "Borrar") );
				$(tr).append( acc );
				$("#subcam_tbody").append( tr );
			});
		}).fail(function(jqXHR, textStatus, errorThrown) {
			swal("", "Error al ver las campañas ("+errorThrown+").", "warning");
		});
	
	}
	
	// Basicos
	function setNumerico(id){
		var num = $("#" + id).find(".num");
		for( i = 0; i < num.length; i++ ){
			$( num[i] ).html( (i+1) );
		}
	}
	
	function girarVal(id1, id2){
		var val = $("#"+id1).val();
		$("#"+id1).val( $("#"+id2).val() );
		$("#"+id2).val( val );
	}
	
	// Atributos - Valores
	var num_atri = 0;
	function addEventAtributo(fg, es_otro, e){
		if (e.keyCode == 13 || e.keyCode === 9 ) {
			addAtributo(fg, es_otro);
			return false;
		}
	}
	
	function addAtributo(fg, es_otro, id){
		var inDatos = getInDAtos( fg );
		if( typeof( id ) == "undefined" ){
			id = { id:"", val:"" };
		}
		
		$("#"+inDatos.fg).attr("class", "form-group");
		$("#"+inDatos.fg).find(".help-block").html("");
		var atributo = $("#"+inDatos.txt_in).val();
		if( atributo.trim() != "" ){
			num_atri++;
			var btns = [
				 { txt: "fa-edit"	, clic: "editAtributo("+num_atri+", "+fg+");" }
				,{ txt: "fa-files-o", clic: "dupAtributo("+num_atri+", '"+atributo+"', "+fg+");" }
				,{ txt: "fa-trash-o", clic: "delAtributo("+num_atri+", '"+atributo+"', "+fg+")" }
			];
			var li = Galy.getElemLList("nA_" + num_atri, atributo, es_otro, btns) ;
			$( li ).append( Galy.getElemCH("id-respuesta", id.id) );
			$( li ).append( Galy.getElemCH("val", id.val) );
			$("#"+inDatos.list_i).append( li );
			$("#"+inDatos.txt_in).val("");
			
		}else{
			$("#"+inDatos.fg).attr("class", "form-group has-error");
			$("#"+inDatos.fg).find(".help-block").html("Falta ingresar texto");
		}
	}
	
	function editAtributo(id, fg){
		canEditAtributo();
		$("#nA_"+id).find(".oculEditAtri").css("display", "none");
		$("#nA_"+id).find(".text").css("display", "none");
		
		var td_t = $("#nA_"+id).find(".text");
		var td_e = $("#nA_"+id).find(".edit");
		var txt = $(td_t).html();
		
		//$(td_e).html( Galy.getElemMiniEdit(id, txt, "editEventAtributo", "canEditAtributo", "savEditAtributo", fg) );
		$(td_e).html( Galy.getElemMiniEdit("bx_edit_atri", id, txt, "editEventAtributo", "canEditAtributo", "savEditAtributo", fg) );
		
	}
	
	function editEventAtributo(id, fg, e){
		var keyCode = e.keyCode || e.which; 
		if( keyCode == 27 ){
			canEditAtributo(fg);
			return false;
		}
		if (keyCode == 13) {
			savEditAtributo(id, fg);
			return false;
		}
	}
	
	function canEditAtributo(fg){
		var inDatos = getInDAtos( fg );
		$("#bx_edit_atri").remove();
		$("#"+inDatos.list_i).find("li").find(".text").css("display", "");
		$(".oculEditAtri").css("display", "");
	}
	
	function savEditAtributo(id, fg){
		var txt = $("#nA_"+id).find(".edit").find("input").val();
		$("#nA_"+id).find(".text").html( txt );
		canEditAtributo(fg);
	}
	
	function dupAtributo(id, nombre, fg){
		var es_otro = ( $("#nA_"+id).find(".es_otro").length > 0 );
		var inDatos = getInDAtos( fg );
		var td_t = $("#nA_"+id).find(".text").html();
		$("#"+inDatos.txt_in).val( nombre );
		addAtributo(fg, es_otro);
		$("#"+inDatos.txt_in).val( "" );
		var act = $("#nA_"+id);
		act.after( $("#nA_"+num_atri) );
	}
	
	function delAtributo(id, nombre, fg, txt1){
		if( typeof(txt1) == "undefined" )
			txt1 = "atributo";
		if( typeof(fg) != "undefined" )
			if( fg != null )
				var inDatos = getInDAtos( fg );
		swal({
			title: 'Eliminar ' + txt1,
			html: '¿Realmente desea eliminar "<strong>' + nombre + '</strong>" ?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Eliminar',
			cancelButtonText: 'Cancelar',
			confirmButtonColor: '#d33',
		}).then(function () {
			$("#nA_"+id).remove();
		}).catch(swal.noop);
		
	}
	
	function getInDAtos(fg){
		if( fg ){
			inDatos = {
				fg: "fg_atributos"
				, txt_in: "txt_atributo"
				, list_i: "lis_atributos"
			};
		}else{
			inDatos = {
				fg: "fg_respuestas"
				, txt_in: "txt_respuesta"
				, list_i: "lis_respuestas"
			};
		}
		
		return inDatos;
	}
	
	function setOrden(obj, val){
		$("#menu_orden").find("li").attr("class", "");
		$(obj).parent().attr("class", "active")
		$("#btn_orden").val( val );
		$("#btn_orden").find("strong").html( $(obj).html() );
	}
	
	function getColapsed(id, es_auto){
		var box = $("#"+id).parents(".box").first();
		var bf = box.find(".box-body, .box-footer");
		if (!box.hasClass("collapsed-box")) {
			bf.slideUp();
			setTimeout(function(){
				box.addClass("collapsed-box");
			}, 200);
			$("#fa_cam").find("i").attr("class", "fa fa-plus");
		} else if( es_auto ) {
			bf.slideDown();
			setTimeout(function(){
				box.removeClass("collapsed-box");
			}, 200);
			$("#fa_cam").find("i").attr("class", "fa fa-minus");
		}
	}
	
	// FF
	function verTab(tp){
		$("#txt_visualizar_contenido").html("");
		switch(tp){
			case 1:
				if( cfg_pre.tp_tab_actual == 2 )
					CKEDITOR.instances.txt_visualizar.setData( CKEDITOR.instances.txt_pregunta.getData() );
				if( cfg_pre.tp_tab_actual == 3 )
					CKEDITOR.instances.txt_pregunta.setData( CKEDITOR.instances.txt_visualizar.getData() );
				break;
				
			case 2:
				CKEDITOR.instances.txt_pregunta.setData( CKEDITOR.instances.txt_visualizar.getData() );
				break;
			
			case 3:
				CKEDITOR.instances.txt_visualizar.setData( CKEDITOR.instances.txt_pregunta.getData() );
				generarVista( "txt_visualizar_contenido" );
				break;
		}
		cfg_pre.tp_tab_actual = tp;
	}
	
	function addTpPregunta(tp){
		$("#tab-editar-1").css("display", "");
		$("#tab-visualizar-1").css("display", "");
		$("#tab-logica-1").css("display", "");
		
		$("#tab-editar-1").find("a").click();
		
		if( cfg_pre.mod_edit_pre == 0 ){
			$("#lb_new_pregunta").html("Nueva Pregunta: <strong>"+$("#lb_tab_"+tp).html()+"</strong>");
			$("#btn_pregunta").html("Agregar");
		}else{
			$("#lb_new_pregunta").html("Editar Pregunta: <strong>"+$("#lb_tab_"+tp).html()+"</strong>");
			$("#btn_pregunta").html("Guardar");
		}
		
		$("#tab-desc").html( $("#txt_tab_"+tp).html() );
		cfg_pre.tp_pre_actual = tp;
		
		// ---
		$("#bx_tipo_pre").css("display", "none");
		$("#bx_resp_pre").css("display", "none");
		$("#gp_botones").find("button").css("display", "none");
		$("#tab_atri_resp").find(".nav-tabs").find("li").attr("class", "tab-pane");
		$("#tab_atri_resp").find(".nav-tabs").find("li").css("display", "none");
		$("#tab_atri_resp").find(".tab-content").find(".tab-pane").attr("class", "tab-pane");
		
		var gp_botones = $("#gp_botones").find("button");
		var gp_tab_uli = $("#tab_atri_resp").find(".nav-tabs").find("li");
		var gp_tab_div = $("#tab_atri_resp").find(".tab-content").find(".tab-pane");
		
		$("#gp_botones").find("button").attr("class", "btn btn-default");
		$($("#gp_botones").find("button")[0]).addClass("active");
		
		$("#btn-del-res").css("display", "");
		
		switch(tp){
			case 2:
				$("#lb_atributos").html("Palancas");
				$("#bx_tipo_pre").css("display", "");
				$("#bx_resp_pre").css("display", "");
				$( gp_botones[0] ).css("display", "");
				$( gp_botones[1] ).css("display", "");
				gp_botones[0].click();
				break;
				
			case 3:
				$("#lb_atributos").html("Respuestas");
				$("#bx_tipo_pre").css("display", "");
				$("#bx_resp_pre").css("display", "");
				gp_botones[2].click();
				$( gp_botones[2] ).css("display", "");
				$( gp_botones[3] ).css("display", "");
				$( gp_tab_div[2] ).attr("class", "tab-pane active");
				break;
				
			case 4:
				$("#lb_atributos").html("Respuestas");
				$("#bx_tipo_pre").css("display", "");
				$("#bx_resp_pre").css("display", "");
				$( gp_botones[0] ).css("display", "");
				$( gp_botones[1] ).css("display", "");
				$( gp_tab_uli[0] ).css("display", "");
				$( gp_tab_uli[2] ).css("display", "");
				$( gp_tab_uli[0] ).find("a").click();
				$("#btn-del-res").css("display", "none");
				break;
		}
		
		// -
	}
	
	function setTpSubPregunta(obj, val){
		$("#gp_botones").find("button").attr("class", "btn btn-default");
		$(obj).addClass("active");
		$("#sub_pregunta").val( val );
		
		// --
		var gp_botones = $("#gp_botones").find("button");
		var gp_tab_uli = $("#tab_atri_resp").find("ul").find("li");
		var gp_tab_div = $("#tab_atri_resp").find(".tab-content").find(".tab-pane");
		
		switch( cfg_pre.tp_pre_actual ){
			case 2:
				$("#tab_atri_resp").find(".tab-content").find(".tab-pane").attr("class", "tab-pane");
				if( val == 1 ){
					$("#lb_atributos").html("Palancas");
					$( gp_tab_div[0] ).attr("class", "tab-pane active");
					
					$($("#tab_1").find(".row")[0]).prepend( $("#pal_palanca02").parent() );
					$($("#tab_1").find(".row")[0]).prepend( $("#pal_gir") );
					$($("#tab_1").find(".row")[0]).prepend( $("#pal_palanca01").parent() );
				}else{
					$("#lb_atributos").html("Atributo");
					$( gp_tab_div[1] ).attr("class", "tab-pane active");
					
					$($("#tab_2").find(".row")[0]).prepend( $("#pal_palanca02").parent() );
					$($("#tab_2").find(".row")[0]).prepend( $("#pal_gir") );
					$($("#tab_2").find(".row")[0]).prepend( $("#pal_palanca01").parent() );
				}
				break;
				
			case 4:
				if( val == 1 ){
					$( gp_tab_uli[0] ).css("display", "");
					$( gp_tab_uli[1] ).css("display", "none");
					$( gp_tab_uli[0] ).find("a").click();
					
					$($("#tab_1").find(".row")[0]).prepend( $("#pal_palanca02").parent() );
					$($("#tab_1").find(".row")[0]).prepend( $("#pal_gir") );
					$($("#tab_1").find(".row")[0]).prepend( $("#pal_palanca01").parent() );
				}else{
					$( gp_tab_uli[0] ).css("display", "none");
					$( gp_tab_uli[1] ).css("display", "");
					$( gp_tab_uli[1] ).find("a").click();
					
					$($("#tab_2").find(".row")[0]).prepend( $("#pal_palanca02").parent() );
					$($("#tab_2").find(".row")[0]).prepend( $("#pal_gir") );
					$($("#tab_2").find(".row")[0]).prepend( $("#pal_palanca01").parent() );
				}
				break;
		}
	}
	
	// Preguntas
	function verPregunta(obj, nombre, id, tp, val){
		$('#modal-preguntas-visualizar').find(".col-1").css("display", "");
		$('#modal-preguntas-visualizar').find(".col-2").css("display", "");
		$('#modal-preguntas-visualizar').find(".col-3").css("display", "none");
		$('#modal-preguntas-visualizar').find(".progress").find(".progress-bar").css("width", "40%");
		
		closeBoxAddPreguntas();
		var info = $(obj).parent().parent().parent().find(".timeline-body").html();
		$("#txt_visualizar_vista").html(info);
		$("#lb_pr_vista").html(nombre);
		$("#txt_visualizar_vista_contenido").html( "" );
		$('#modal-preguntas-visualizar').find(".modal-dialog").css("width", "");
		$('#modal-preguntas-visualizar').modal('show');
		cfg_pre.tp_pre_actual = tp;
		getPregunta(id, "txt_visualizar_vista_contenido");
	}
	
	function editPregunta(obj, nombre, id, tp, val){
		newPregunta( 3 );
		
		var info = $(obj).parent().parent().parent().find(".timeline-body").html();
		CKEDITOR.instances.txt_visualizar.setData( info );
		CKEDITOR.instances.txt_pregunta.setData( info );
		$("#codigo_pregunta").val(nombre);
		cfg_pre.id_pre = id;
		
		addTpPregunta(tp);
		getPregunta(id, "txt_visualizar_contenido");
	}
	

	pestana = 0;
	function getPregunta(id, idBox, tp){
		if(typeof(tp) == "undefined")
			tp = 1;
		
		$("#"+idBox).html("");
		// -----
		var jqxhr = $.ajax(  {
			type: "POST",
			dataType: "json",
			url: "galy/html/include/vw_preguntas.php",
			data: { tipo: 1, subtipo: 6, val: id, exVal:tp }
		}).done(function( data, textStatus, jqXHR ) {
			if( data.estatus == 3 ){
				// --- 
				inIdBox = idBox;
				inIdPes = idBox;
				var idN = 0;
				var pestanas = 0;
				var pes_act = 0;
				
				// data.pregunta.length
				for(xj = 0; xj < data.pregunta.length; xj++){
					var inDatos = data.pregunta[xj];
					if( pes_act != inDatos.pestana && tp == 2 ){
						pestanas++;
						pes_act = inDatos.pestana;
						inIdPes = "pes_" + pestanas;
						var pest = Galy.getElemC("div", "col-lg-12 pestana");
						pest.id = inIdPes;
						var inPest1 = Galy.getElemC("div", "row inPest");
						$(pest).append(inPest1);
						if( pestanas > 1 ){
							$(pest).css("display", "none");
							pest.setAttribute("activo", "0");
						}else{
							pest.setAttribute("activo", "1");
						}
						$("#"+idBox).append(pest);
					}
					
					if(tp == 2){
						cfg_pre.tp_pre_actual = parseInt(inDatos.tp_preg);
						idN++;
						inIdBox = "prs_" + idN;
						var div = Galy.getElemC("div", "col-lg-12");
						var inD1 = Galy.getElemC("div", "");
						inD1.innerHTML = inDatos.pregunta;
						$(div).append(inD1);
						
						var inD2 = Galy.getElemC("div", "");
						inD2.id = inIdBox;
						$(div).append(inD2);
						$(div).append(Galy.getElem("hr"));
						
						$("#"+inIdPes).find(".inPest").append(div);
						
					}

					$("#pal_palanca01").val( inDatos.RS1_preg );
					$("#pal_palanca02").val( inDatos.RS2_preg );

					$("#pal_ini01").val( inDatos.RS3_preg );
					$("#pal_fin01").val( inDatos.RS4_preg );

					$("#codigo_pregunta").val( inDatos.nombre_ct );

					var btn = $("#gp_botones").find(".btn");
					$( btn[inDatos.sub_pre - 1] ).click();

					var btn = $("#menu_orden").find("li");
					$( btn[inDatos.opcion - 1] ).click();
					$("#lis_atributos").html( "" );
					for(xi = 0; xi < inDatos.atributos.length; xi++ ){
						$("#txt_atributo").val( inDatos.atributos[xi].txt );
						addAtributo(true, false, { id:inDatos.atributos[xi].id, val:inDatos.atributos[xi].val });
					}
					$("#txt_atributo").val( "" );

					$("#lis_respuestas").html( "" );
					for(xi = 0; xi < inDatos.valores.length; xi++ ){
						$("#txt_respuesta").val( inDatos.valores[xi].txt );
						if( inDatos.valores[xi].es_otro == "0" ){
							addAtributo(false, false, { id:inDatos.valores[xi].id, val:inDatos.valores[xi].val });
						}else{
							addAtributo(false, true, { id:inDatos.valores[xi].id, val:inDatos.valores[xi].val });
						}
					}
					$("#txt_respuesta").val( "" );
					generarVista( inIdBox );
				}
				
			}else{
				swal("", "Error al "+txts[0]+" la respuesta ("+data.text+").", "warning");
			}
		}).fail(function(jqXHR, textStatus, errorThrown) {
			swal("", "Error al "+txts[0]+" la respuesta ("+errorThrown+").", "warning");
		});
		
	}
	
	function movPregunta(subT, obj, nombre, id, tp, val, i){
		var elem = $("#time_preguntas").find(".li_pregs");
		var movElem = {
			ele01: "", eleId01: $(elem[i]).find(".val_ele").val(),
			ele02: "", eleId02: ""
		};
		if(subT){
			movElem.ele01 = i ;
			movElem.ele02 = i + 1;
			movElem.eleId02 = $(elem[i - 1]).find(".val_ele").val();
		}else{
			movElem.ele01 = i + 2;
			movElem.ele02 = i + 1;
			movElem.eleId02 = $(elem[i + 1]).find(".val_ele").val();
		}
		
		txts = cfg_pre.txt_mov;
		
		var jqxhr = $.ajax(  {
			type: "POST",
			dataType: "json",
			url: "galy/html/include/vw_preguntas.php",
			data: { tipo: 1, subtipo: 4, val: movElem.eleId01, exVal:movElem.eleId02, tp_preg: movElem.ele01, sub_pre:movElem.ele02 }
		}).done(function( data, textStatus, jqXHR ) {
			if( data.estatus == 3 ){
				listarPreguntas();
			}else{
				swal("", "Error al "+txts[0]+" la pregunta ("+data.text+").", "warning");
			}
		}).fail(function(jqXHR, textStatus, errorThrown) {
			swal("", "Error al "+txts[0]+" la pregunta ("+errorThrown+").", "warning");
		});
	}
	
	function delPregunta(obj, nombre, id, tp, val){
		dbPregunta(obj, nombre, id, tp, val, false);
	}
	
	function dupPregunta(obj, nombre, id, tp, val){
		dbPregunta(obj, nombre, id, tp, val, true);
	}
	
	function dbPregunta(obj, nombre, id, tp, val, es_dup){
		if(!es_dup){
			txts = ["Eliminar", "elimino", "eliminada"];
			subtipo = 2;
		}else{
			txts = ["Duplicar", "duplico", "duplicada"];
			subtipo = 5;
		}
		
		swal({
		  title: txts[0] + ' Pregunta',
		  html: '¿Realmente desea '+txts[0]+' "<strong>' + nombre + '</strong>" ?',
		  showCancelButton: true,
		  confirmButtonText: txts[0],
		  cancelButtonText: 'Cancelar',
		  showLoaderOnConfirm: true,
		  confirmButtonColor: '#d33',
		  preConfirm: function () {
			return new Promise(function (resolve, reject) {
				var jqxhr = $.ajax(  {
					type: "POST",
					dataType: "json",
					url: "galy/html/include/vw_preguntas.php",
					data: { tipo: 1, subtipo: subtipo, val: id }
				}).done(function( data, textStatus, jqXHR ) {
					if( data.estatus == 3 ){
						resolve();
						listarPreguntas();
					}else{
				  		reject("Error al "+txts[0]+" la "+nombre+" ("+data.text+").");
					}
				}).fail(function(jqXHR, textStatus, errorThrown) {
				  reject("Error al "+txts[0]+" la "+nombre+" ("+errorThrown+").");
				});
				// -----
			})
		  },
		  allowOutsideClick: false
		}).then(function () {
		  swal({
			type: 'success',
			title: '¡Se '+txts[1]+' con éxito!',
			html: 'Pregunta '+txts[0]+': <strong>' + nombre + '</strong>'
		  })
		}).catch(swal.noop);
	}
		
	function addPregunta(){
		// - btn_pregunta
		if( cfg_pre.tp_pre_actual == -1 ){
			swal("", "Por favor seleccione un tipo de pregunta.", "warning");
			return false;
		}

		if( cfg_pre.tp_tab_actual == 2 )
			CKEDITOR.instances.txt_visualizar.setData( CKEDITOR.instances.txt_pregunta.getData() );
		if( cfg_pre.tp_tab_actual == 3 )
			CKEDITOR.instances.txt_pregunta.setData( CKEDITOR.instances.txt_visualizar.getData() );
		if( CKEDITOR.instances.txt_pregunta.getData().trim() == "" || CKEDITOR.instances.txt_pregunta.getData().length == 0 ){
			swal("", "Falta agregar el texto de la pregunta o información.", "warning");
			return false;
		}
			
		// add
		subtp = 1;
		
		var inAdicional = getInDatosP();
		tp_sub_pre_actual = inAdicional.tp_sub_pre_actual;
		tp_op_actual = inAdicional.tp_op_actual;
		
		RS1_preg = inAdicional.RS1_preg;
		RS2_preg = inAdicional.RS2_preg;
		RS3_preg = inAdicional.RS3_preg;
		RS4_preg = inAdicional.RS4_preg;
		
		atributos = inAdicional.atributos;
		valores = inAdicional.valores;
		
		
		switch( cfg_pre.tp_pre_actual ){
			case 2:
				if( inAdicional.RS1_preg.trim() != "" || inAdicional.RS2_preg.trim() != "" ){
					if( inAdicional.RS1_preg.trim() == "" ){
						swal("", "Falta agregar la palanza izquierda.", "warning");
						return false;
					}
					if( inAdicional.RS2_preg.trim() == "" ){
						swal("", "Falta agregar la palanza derecha.", "warning");
						return false;
					}
				}
				
				if( inAdicional.tp_sub_pre_actual == "1" ){
					if( inAdicional.RS3_preg.trim() == "" ){
						swal("", "Falta agregar el inicio de la escala.", "warning");
						return false;
					}
					if( inAdicional.RS4_preg.trim() == "" ){
						swal("", "Falta agregar el fin de la escala.", "warning");
						return false;
					}
				}else if( inAdicional.tp_sub_pre_actual == "2" ){
					if( inAdicional.atributos.length == 0 ){
						swal("", "Falta agregar la lista de atributos.", "warning");
						return false;
					}
				}
				break;
				
			case 3:
				if( inAdicional.valores.length == 0 ){
					swal("", "Falta agregar la lista de respuestas.", "warning");
					return false;
				}
				
				break;
				
			case 4:
				if( inAdicional.tp_sub_pre_actual == "1" ){
					if( inAdicional.RS1_preg.trim() != "" || inAdicional.RS2_preg.trim() != "" ){
						if( inAdicional.RS1_preg.trim() == "" ){
							swal("", "Falta agregar la palanza izquierda.", "warning");
							return false;
						}
						if( inAdicional.RS2_preg.trim() == "" ){
							swal("", "Falta agregar la palanza derecha.", "warning");
							return false;
						}
					}
					
					if( inAdicional.RS3_preg.trim() == "" ){
						swal("", "Falta agregar el inicio de la escala.", "warning");
						return false;
					}
					if( inAdicional.RS4_preg.trim() == "" ){
						swal("", "Falta agregar el fin de la escala.", "warning");
						return false;
					}
				}else if( inAdicional.tp_sub_pre_actual == "2" ){
					if( inAdicional.atributos.length == 0 ){
						swal("", "Falta agregar la lista de atributos.", "warning");
						return false;
					}
				}
				
				if( inAdicional.valores.length == 0 ){
					swal("", "Falta agregar la lista de respuestas.", "warning");
					return false;
				}
				break;
			
			case 0:
				if(false){
					swal("", "Falta algo aqui.", "warning");
					return false;
				}
				break;
		}
		
		if( typeof( pestana ) == "undefined" || pestana == null )
			pestana = 1;
		if( typeof( n_orden ) == "undefined" || n_orden == null )
			n_orden = $("#time_preguntas").find(".li_pregs").length + 1;
	
		if(cfg_pre.mod_edit_pre == 0){
			txts = cfg_pre.txt_new;
		}else{
			txts = cfg_pre.txt_edi;
		}
		
		var jqxhr = $.ajax(  {
			type: "POST",
			dataType: "json",
			url: "galy/html/include/vw_preguntas.php",
			data: { tipo: subtp, subtipo: cfg_pre.mod_edit_pre, exVal:cfg_pre.tp_val_pre, tp_preg:cfg_pre.tp_pre_actual, sub_pre:tp_sub_pre_actual
				, val:cfg_pre.id_pre, opcion: tp_op_actual, pestana:pestana, n_orden:n_orden, codigo:$("#codigo_pregunta").val()
				, pregunta:CKEDITOR.instances.txt_pregunta.getData().trim()
				, RS1_preg:RS1_preg, RS2_preg:RS2_preg, RS3_preg:RS3_preg, RS4_preg:RS4_preg
				, atributos:atributos, valores:valores
			}
		}).done(function( data, textStatus, jqXHR ) {
			if( data.estatus == 3 ){
				swal({
					type: 'success',
					title: '¡Se '+txts[1]+' con éxito!',
					html: 'Pregunta '+txts[3]+' <strong>' + $("#codigo_pregunta").val() + '</strong>'
				});
				
				listarPreguntas();
				closeBoxAddPreguntas();
			}else{
				swal("", "Error al "+txts[0]+" la pregunta ("+data.text+").", "warning");
			}
		}).fail(function(jqXHR, textStatus, errorThrown) {
			swal("", "Error al "+txts[0]+" la pregunta ("+errorThrown+").", "warning");
		});
	}
	
	function listarPreguntas(){
		$("#time_preguntas").html("");
		var jqxhr = $.ajax(  {
			type: "POST",
			dataType: "json",
			url: "galy/html/include/vw_preguntas.php",
			data: { tipo: 1, subtipo: 1, val: cfg_pre.tp_val_pre }
		}).done(function( data, textStatus, jqXHR ) {
			var pag_act = "";
			var es_pestana_old = false;
			$.each(data.cam, function( key, value ) {
				var es_pestana = (pag_act != value.pre_pag);
				var es_primero = (key > 0);
				var es_ultimo  = (key + 1 < data.cam.length);
				pestana = value.pre_pag;
				
				var es_estana_new = false;
				if( es_pestana ){
					pag_act = value.pre_pag;
					$("#time_preguntas").append( Galy.getElemCO("li", "time-label"
						, Galy.getElemCT("span", "bg-red", "Pestaña - "+pag_act)
					) );
				}
				if( es_ultimo){
					es_estana_new = (pag_act != data.cam[key + 1].pre_pag);;
				}
				
				var e = "this, '"+value.label+"', '"+value.id+"', "+value.tp_pre+", '"+cfg_pre.tp_val_pre+"', " + key;
				var li = Galy.getElemC("li", "li_pregs");
				$(li).append( Galy.getElemLi(value.tp_lbc, value.tp_ico) );
				var t_itme;
				if(value.activa == "1")
					t_itme = Galy.getElemC("div", "timeline-item");
				else
					t_itme = Galy.getElemC("div", "timeline-item inactive");

				$(t_itme).append( Galy.getElemIClock(value.pre_fec) );
				var txt = value.label;
				if(value.activa != "1")
					txt = "Pregunta Inhabilitada <small>(" + txt + ")</small>";
				$(t_itme).append( Galy.getElemCT("h3", "timeline-header", "<strong>"+txt+"</strong> <small>" + value.tp_txt + "</small>") );
				$(t_itme).append( Galy.getElemCT("div", "timeline-body", value.pre_txt) );
				var gp_btn = Galy.getElemC("div", "btn-group");
				$(gp_btn).append( Galy.getElemCH("val_ele", value.id) );
				$(gp_btn).append( Galy.getElemB("default", "arrows-alt", "verPregunta("+e+")", " Visualizar ") );
				$(gp_btn).append( Galy.getElemB("default", "edit", "editPregunta("+e+")", " Editar ") );
				$(gp_btn).append( Galy.getElemB("default", "files-o", "dupPregunta("+e+")", " Duplicar ") );
				if( es_primero)
					$(gp_btn).append( Galy.getElemB("default", "angle-up", "movPregunta(true, "+e+")", " Subir ") );
				if( es_ultimo)
					$(gp_btn).append( Galy.getElemB("default", "angle-down", "movPregunta(false, "+e+")", " Bajar ") );
				// Pestañas
				var lista = Array();
				if( es_primero && !es_pestana_old )
					lista.push({txt: "Nueva Pestaña Antes", onC: "setPestañas('"+value.id+"', 1, -1)"});
				if( !es_pestana )	
					lista.push({txt: "Nueva Pestaña", onC: "setPestañas('"+value.id+"', 1, 0)"});
				if( es_ultimo && !es_estana_new )
					lista.push({txt: "Nueva Pestaña Después", onC: "setPestañas('"+value.id+"', 1, 1)"});
				
				if( es_pestana && ( (es_primero && !es_pestana_old) || (es_ultimo && !es_estana_new) ) )
					lista.push({txt: "-"});
				if( es_primero && es_pestana && !es_pestana_old)
					lista.push({txt: "Mover Pestaña Antes", onC: "setPestañas('"+value.id+"', 2, -1)"});
				if( es_ultimo && es_pestana && !es_estana_new)
					lista.push({txt: "Mover Pestaña Después", onC: "setPestañas('"+value.id+"', 2, 1)"});
				
				if( es_pestana && es_primero ){
					if( (es_primero && !es_pestana_old) || ( es_ultimo && !es_estana_new) )
					lista.push({txt: "-"});
					lista.push({txt: "Eliminar Pestaña", onC: "setPestañas('"+value.id+"', 3, 0)"});
				}
				if(lista.length > 0)
					$(gp_btn).append( Galy.getElemSplitButtons("", "tags", "Pestaña", lista, "info") );
				
				// Activar Pregunta
				var lista = Array();
				if(value.activa == "1")
					lista.push({txt: "Inhabilitar Pregunta", onC: "setActivo('"+value.id+"', 0)"});
				else
					lista.push({txt: "Habilitar Pregunta", onC: "setActivo('"+value.id+"', 1)"});
				$(gp_btn).append( Galy.getElemSplitButtons("", "gears", "Herramientas", lista, "primary") );
				
				$(gp_btn).append( Galy.getElemB("danger", "trash", "delPregunta("+e+")", "Borrar") );
				$(t_itme).append( Galy.getElemCO("div", "timeline-footer", gp_btn) );
				$(li).append( t_itme );
				$("#time_preguntas").append( li );
				es_pestana_old = es_pestana;
			});
		}).fail(function(jqXHR, textStatus, errorThrown) {
			swal("", "Error al ver las campañas ("+errorThrown+").", "warning");
		}); 
	}
	
	function getInDatosP(){
		var inAdicional = {
			tp_sub_pre_actual: ""+$("#sub_pregunta").val()
			, tp_op_actual: ""+$("#btn_orden").val()
			, RS1_preg: ""+$("#pal_palanca01").val()
			, RS2_preg: ""+$("#pal_palanca02").val()
			, RS3_preg: ""+$("#pal_ini01").val()
			, RS4_preg: ""+$("#pal_fin01").val()
			
			, atributos: Array()
			, valores: Array()
		};
		
		var lista_atributos = $("#lis_atributos").find("li");
		for( i=0; i < lista_atributos.length; i++ ){
			inAdicional.atributos.push({
				txt: $(lista_atributos[i]).find(".text").html()
				, id: $(lista_atributos[i]).find(".id-respuesta").val()
				, val: $(lista_atributos[i]).find(".val").val()
				, orden: (i + 1)
			});
		}
		
		var lista_respuestas = $("#lis_respuestas").find("li");
		for( i=0; i < lista_respuestas.length; i++ ){
			inAdicional.valores.push( {
				txt: $(lista_respuestas[i]).find(".text").html()
				, es_otro:  ( $(lista_respuestas[i]).find(".es_otro").length > 0 )
				, id: $(lista_respuestas[i]).find(".id-respuesta").val()
				, val: $(lista_respuestas[i]).find(".val").val()
				, orden: (i + 1)
			} );
		}
		
		return inAdicional;
	}
	
	function setPestañas(id, tp, val){
		var jqxhr = $.ajax(  {
			type: "POST",
			dataType: "json",
			url: "galy/html/include/vw_preguntas.php",
			data: { tipo: 2, subtipo: tp, val: val, exVal:id }
		}).done(function( data, textStatus, jqXHR ) {
			if( data.estatus == 3 ){
				/*swal({
					type: 'success',
					title: '¡Se '+data.txt_tp+' con éxito!',
					html: ''
				})*/
				listarPreguntas();
			}else{
				swal("", "Error en la pestaña ("+errorThrown+").", "warning");
			}
		}).fail(function(jqXHR, textStatus, errorThrown) {
		  swal("", "Error en la pestaña ("+errorThrown+").", "warning");
		});
	}
	
	function setActivo(id, val){
		var jqxhr = $.ajax(  {
			type: "POST",
			dataType: "json",
			url: "galy/html/include/vw_preguntas.php",
			data: { tipo: 1, subtipo: 7, val: val, exVal:id }
		}).done(function( data, textStatus, jqXHR ) {
			if( data.estatus == 3 ){
				listarPreguntas();
			}else{
				swal("", "Error en la activación ("+errorThrown+").", "warning");
			}
		}).fail(function(jqXHR, textStatus, errorThrown) {
		  swal("", "Error en la activación ("+errorThrown+").", "warning");
		});
	}
	
	function verPreguntas(){
		$('#modal-preguntas-visualizar').find(".modal-dialog").css("width", "95%");
		$('#modal-preguntas-visualizar').modal('show');
		
		$('#modal-preguntas-visualizar').find(".col-1").css("display", "none");
		$('#modal-preguntas-visualizar').find(".col-2").css("display", "none");
		$('#modal-preguntas-visualizar').find(".col-3").css("display", "");
		$('#modal-preguntas-visualizar').find(".progress").find(".progress-bar").css("width", "0%");
		
		closeBoxAddPreguntas();
		$("#txt_visualizar_vista_todo").html( "" );
		$('#modal-preguntas-visualizar').find(".modal-dialog").css("width", "");
		$('#modal-preguntas-visualizar').modal('show');
		
		getPregunta(cfg_pre.tp_val_pre, "txt_visualizar_vista_todo", 2);
	}
	
	function sigVis(){
		var pest = $("#txt_visualizar_vista_todo").find(".pestana");
		if( pest.length > 1 ){
			var fin = false;
			for(i = 0; i < pest.length - 1; i++){
				if(i == pest.length - 2){
					$("#txt_visualizar_vista_btnSigVis").css("display", "none");
				}
				
				if( $(pest[i]).attr("activo") == "1" ){
					$(pest[i]).css("display", "none");
					$(pest[i]).attr("activo", "0");
					$(pest[i + 1]).css("display", "");
					$(pest[i + 1]).attr("activo", "1");
					break;
				}

			}
			$("#modal-preguntas-visualizar").scrollTop(0);
		}
	}
	
	function reiVis(){
		var pest = $("#txt_visualizar_vista_todo").find(".pestana");
		if( pest.length > 1 ){
			$("#txt_visualizar_vista_todo").find(".pestana").attr("activo", "0");
			$("#txt_visualizar_vista_todo").find(".pestana").css("display", "none");
			$(pest[0]).attr("activo", "1");
			$(pest[0]).css("display", "");
			$("#txt_visualizar_vista_btnSigVis").css("display", "");
		}
	}
</script>