<?php
class Preguntas{
	public function __construct() {
	}
	
	public function __destruct(){
		//$this->db->desconectar();
	}
	
	// Generado del SCRIPT - Madnar estos elementos a un archivo JS
	public function getJS(){
	?>
		<script>
			function regresarSubCampania(){
				getColapsed("fa_pre", false);
				getColapsed("fa_cam", false);
				getColapsed("fa_sub", false);
				cfg_pre.tp_val_pre = "";
				cfg_pre.id_pre = "";
				
				setTimeout(function(){
					$("#bx_pre").css("display", "none");
					
					getColapsed("fa_cam", true);
					getColapsed("fa_sub", true);
				}, 200);
			}
			
			function verCuestionario(nombre, val, tp, exVal){
				// Animacion
				getColapsed("fa_pre", false);
				setTimeout(function(){
					getColapsed("fa_pre", true);
				}, 200);
				$("#bx_pre").css("display", "");
				
				// JS
				$("#lb_pre").html(nombre);
				$(".lb_sub").html(nombre);
				getColapsed("fa_cam", false);
				getColapsed("fa_sub", false);
				cfg_pre.tp_val_pre = val;
				listarPreguntas();
			}
			
			function getCambiarTab(inTab, outTab){
				$("#tab-" + inTab).addClass("active");
				$("#"     + inTab).addClass("active");
				
				$("#tab-" + outTab).removeClass("active");
				$("#"     + outTab).removeClass("active");
			}
			
			function newPregunta(tp){
				if( typeof( tp ) == "undefined" || tp == null )
					tp = 0;
				cfg_pre.mod_edit_pre = tp;
					
				if(cfg_pre.mod_edit_pre == 0){
					txts = cfg_pre.txt_new;
				}else{
					txts = cfg_pre.txt_edi;
				}
					
				$('#modal-preguntas').modal({
				  keyboard: false
				});
				
				cfg_pre.es_cierre = false;
				$('#modal-preguntas').on('hide.bs.modal', function (e) {
					if( !cfg_pre.es_cierre ){
						if( cfg_pre.tp_tab_actual == 0 ){
							closeBoxAddPreguntas();
						}else{
							swal({
								title: '',
								text: 'Esta seguro de cancelar el '+txts[2]+' de la pregunta?',
								type: 'warning',
								showCancelButton: true,
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: 'Aceptar',
								cancelButtonText: 'Cancelar',
							}).then(function () {
								closeBoxAddPreguntas();
							}).catch(swal.noop);
						}
					}
					
					return cfg_pre.es_cierre;
				});
			}
			
			function closeBoxAddPreguntas(){
				cfg_pre.es_cierre = true;
				$('#modal-preguntas').modal('hide');
				// ADD NEW
				$("#lista-preguntas").find("li").removeClass("active");
				$("#lista-tab-preguntas").find(".tab-pane").removeClass("active");
				$("#tab-seleccionar-1").addClass("active");
				$("#seleccionar-1").addClass("active");
				CKEDITOR.instances.txt_visualizar.setData( "" );
				CKEDITOR.instances.txt_pregunta.setData( "" );
				$("#codigo_pregunta").val( "" );
				cfg_pre.tp_tab_actual = 0;
				cfg_pre.tp_pre_actual = -1;
				
				$("#tab-editar-1").css("display", "none");
				$("#tab-visualizar-1").css("display", "none");
				$("#tab-logica-1").css("display", "none");
				
				$("#lb_new_pregunta").html("Nueva Pregunta");
				
				// Respuestas / Atributos
				$($("#gp_botones").find("button")[0]).click();
				$($("#menu_orden").find("li")[0]).find("a").click();
				
				$("#pal_palanca01").val("");
				$("#pal_palanca02").val("");
				$("#pal_ini01").val("");
				$("#pal_fin01").val("");
				
				$("#lis_respuestas").html("");
				$("#lis_atributos").html("");
				
				$("#tab_atri_resp").find(".nav-tabs").find("li").attr("class", "");
				$("#tab_atri_resp").find(".tab-pane").find("li").attr("class", "tab-pane");
				
				$($("#tab_atri_resp").find(".nav-tabs").find("li")[0]).attr("class", "active");
				$("#tab_1").attr("class", "tab-pane active");
				
				// Reiniciar vista original
				$($("#tab_1").find(".row")[0]).prepend( $("#pal_palanca02").parent() );
				$($("#tab_1").find(".row")[0]).prepend( $("#pal_palanca01").parent() );
				
				///
				$($("#tab_1").find(".row")[0]).prepend( $("#pal_palanca02").parent() );
				$($("#tab_1").find(".row")[0]).prepend( $("#pal_gir") );
				$($("#tab_1").find(".row")[0]).prepend( $("#pal_palanca01").parent() );
				
				$("#txt_visualizar_vista_btnSigVis").css("display", "");
			}
			
			function getBoxpr1(val, txt, por, name){
				if( typeof( name ) == "undefined" )
					name = "pr";
				var txt = "<label class='btn btn-default' style='width:"+por+"%'>"
					+ "<input type='radio' name='"+name+"' id='pr_"+val+"' autocomplete='off'> " + txt
					+ "</label>";
				return txt;
			}
		</script>
	<?php
	}
	
	// Genrar vista para la seleccion del tipo de pregunta
	function getTabSeleccionar($obj){
	?>
		<p>Por favor selecciona el tipo de pregunta que deseas agregar.</p>
		<div class="row">
		<?php
			$query = "select * from tp_cat_preguntas order by nombre;";
			$resultado = $obj->getEjecutarQ($query);
			while ($tp_pregunta = $obj->getFetchQ($resultado) ) {
				?>
				<div class="col-lg-6 col-xs-6">
					<div class="small-box <?=$tp_pregunta["lb_class"]?>" style="height: 159px;">
						<div class="inner" style="height: 128px;">
							<h3>&nbsp;</h3>
							
							<p id="lb_tab_<?=$tp_pregunta["tipo"]?>" style="width: 100px;"><?=$tp_pregunta["nombre"]?></p>
							<p id="txt_tab_<?=$tp_pregunta["tipo"]?>" style="display:none;"><?=$tp_pregunta["txt_descripcion"]?></p>
						</div>
						<div class="icon" style="top: 20px; display: inline-block;">
							<i class="fa <?=$tp_pregunta["lb_icono"]?>"></i>
						</div>
						<a href="#" class="small-box-footer" onclick="addTpPregunta(<?=$tp_pregunta["tipo"]?>);">Agregar &nbsp; <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<?php
			}
			$obj->getLiberar($resultado);
		?>
		</div>
	<?php
	}
	
	public function getBoxPrevisualizar($idBox){
		?>
        <div class="box box-solid bg-teal-gradient ">
            <div style="padding: 20px 10px 40px;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title"><span class="lb_cam"></span><br /><small class="lb_sub"></small></h3>
                                <div class="box-tools pull-right">
                                    <div class="progress sm" style="width: 100px; margin-top: 9px;">
                                        <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                        </div>
                                    </div>
                                </div><!-- /.box-tools pull-right -->
                            </div><!-- /.box-header with-border -->
                            <div class="box-body border-radius-none">
                                <div class="row col-1">
                                	<div class="col-lg-12">
	                                    <div id="<?=$idBox?>" contenteditable="true" style="color:#000;"></div>
                                    </div>
                                </div>
                                <div class="row col-2">
                                    <div id="<?=$idBox?>_contenido" class="col-lg-12" style="color:#000;"></div>
                                </div>
                                <div class="row col-3" id="<?=$idBox?>_todo" style="color:#000;"></div>
                            </div><!-- /.box-body border-radius-none -->
                            <div class="box-footer clearfix">
                                <button id="<?=$idBox?>_btnSigVis" type="button" class="pull-right btn btn-default" onClick="sigVis();">
                                    Siguiente <i class="fa fa-arrow-circle-right"></i>
                                </button>
                                <button id="<?=$idBox?>_btnReiVis" type="button" class="pull-right btn btn-default" onClick="reiVis();">
                                    Reiniciar <i class="fa fa-fw fa-rotate-left"></i>
                                </button>
                            </div><!-- /.box-footer no-border -->
                            
                        </div><!-- /.ibox -->
                    </div><!-- /.col-lg-12 -->
                </div><!-- /.row -->
            </div>
        </div>
        <?php
	}
	
	//Generar Pregunta
	function getTabEditar(){
	?>
    	<div>
        	<div class="row">
            	<div id="bx_tipo_pre" class="col-xs-12">
                    <div class="form-group">
                        <h3>Tipo</h3>
                        <div id="gp_botones" class="btn-group">
                            <input type="hidden" id="sub_pregunta" value="1">
                            <button type="button" onclick="setTpSubPregunta(this, 1);" class="btn btn-default active ocultPreg">Escala Númerica</button>
                            <button type="button" onclick="setTpSubPregunta(this, 2);" class="btn btn-default ocultPreg">Escala por Atributos</button>
                            <button type="button" onclick="setTpSubPregunta(this, 3);" class="btn btn-default ocultPreg">Respuesta Única</button>
                            <button type="button" onclick="setTpSubPregunta(this, 4);" class="btn btn-default ocultPreg">Respuesta Multiple</button>
                        </div>
                    </div>
                </div>
            
            	<div id="bx_resp_pre" class="col-xs-12">
                    <h3 id="lb_atributos">Atributos / Respuestas</h3>
                	<div id="tab_atri_resp" class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Palancas</a></li>
                            <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Atributos</a></li>
                            <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true">Respuestas</a></li>
                        </ul>
                        <div class="tab-content" style="padding: 20px;">
                          <div class="tab-pane active" id="tab_1">
							<div class="row">
                                <div class="col-xs-5">
                                  <label for="pal_palanca01">Palancas Izquierda</label>
                                  <input type="text" class="form-control" id="pal_palanca01" placeholder="Palanca Izquierda">
                                </div>
                                <div id="pal_gir" class="col-xs-2">
                                    <label>&nbsp;</label>
                                    <div class="input-group" style="padding-top: 5px;">
	                                    <span class="btn input-group-addon" onclick="girarVal('pal_palanca01', 'pal_palanca02');"><i class="fa fa-exchange"></i></span>
                                    </div>
                                </div>
                                <div class="col-xs-5">
                                  <label for="pal_palanca02">Palancas Derecha</label>
                                  <input type="text" class="form-control" id="pal_palanca02" placeholder="Palanca Derecha">
                                </div>
                                
                                <div class="col-xs-5">
                                  <label for="pal_ini01">Inicio</label>
                                  <input type="number" min="0" class="form-control" id="pal_ini01" placeholder="Inicio númerico (0, 1, etc.)">
                                </div>
                                <div class="col-xs-2">
                                	<label>&nbsp;</label>
                                    <div class="input-group" style="padding-top: 5px;">
                                    	<span class="btn input-group-addon" onclick="girarVal('pal_ini01', 'pal_fin01');"><i class="fa fa-exchange"></i></span>
                                    </div>
                                </div>
                                <div class="col-xs-5">
                                  <label for="pal_fin01">Fin</label>
                                  <input type="number" min="0" class="form-control" id="pal_fin01" placeholder="Fin númerico (5, 10, etc.)">
                                </div>
                            </div>
                          </div>
                          <!-- /.tab-pane -->
                          <div class="tab-pane" id="tab_2">
                            <div class="row">
                                <div class="col-xs-12">
                                	<h3>Lista de Atributos</h3>
                                	<ul id="lis_atributos" class="todo-list ui-sortable"></ul>
                                    <div>
                        
                                        <div id="fg_atributos" class="form-group">
                                          <input type="text" class="form-control" id="txt_atributo" placeholder="Ingresa el texto del atributo" title="Presiona enter o tabulador para agregar" onkeydown="return addEventAtributo(true, false, event);" />
                                          <span class="help-block"></span>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-xs" onclick="addAtributo(true, false);"><i class="fa fa-fw fa-plus"></i>  Agregar </button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                          </div>
                          <!-- /.tab-pane -->
                          <div class="tab-pane" id="tab_3">
                          	<div class="row">
                                <div class="col-xs-12">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" value="1" id="btn_orden" data-toggle="dropdown">Ordenar por: <strong>Personalizado</strong></button>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul id="menu_orden" class="dropdown-menu" role="menu">
                                            <li class="active"><a href="#" onclick="setOrden(this, 1);">Personalizado</a></li>
                                            <li><a href="#" onclick="setOrden(this, 2);">Aleatorio</a></li>
                                            <li><a href="#" onclick="setOrden(this, 3);">Aleatorio <small>(con otros en la parte inferior)</small></a></li>
                                            <li><a href="#" onclick="setOrden(this, 4);">Ascendente</a></li>
                                            <li><a href="#" onclick="setOrden(this, 5);">Descendente</a></li>
                                        </ul>
                                    </div>
                                    
                                	<h3>Lista de Respuestas</h3>
                                	<ul id="lis_respuestas" class="todo-list ui-sortable"></ul>
                                    <div>
                        
                                        <div id="fg_respuestas" class="form-group">
                                          <input type="text" class="form-control" id="txt_respuesta" placeholder="Ingresa el texto de la respuesta" title="Presiona enter o tabulador para agregar" onkeydown="return addEventAtributo(false, false, event);" />
                                          <span class="help-block"></span>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" id="btn-add-res" class="btn btn-default btn-xs" onclick="addAtributo(false, false);"><i class="fa fa-fw fa-plus"></i>  Agregar </button>
                                            <button type="button" id="btn-del-res" class="btn btn-primary btn-xs" onclick="addAtributo(false, true);"><i class="fa fa-fw fa-file-text-o"></i>  Agregar para especificar </button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                          </div>
                          <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                      </div>
                </div>
                
                
                
                
                
              </div>
        </div>
    <?php
	}
}
?>