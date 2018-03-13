<?php
	include("include/js_preguntas.php");
	
	$inPreguntas = new Preguntas();
	
	echo '<link href="editor.css?t=H5SE" rel="stylesheet" type="text/css" />';
?>
<style>
	.tdAtributo{
		width: 160px;
		text-align: center;
	}
	
	#pr_body .has-error{
		height: 20px;
	}
	
	.inactive{
		opacity: 0.5;
	}
	
	.timeline-preguntas{
		background-color: #f4f4f4; 
		overflow: auto;
		max-height: 500px;
	}
	
	.timeline-preguntas .timeline{
		margin: 30px 0 30px 0;
	}
</style>

<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrador de Encuestas
      </h1>
      <ol class="breadcrumb">
        <li><a href="?"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Encuestas</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12" id="bx_cam">
  	  		  <!-- TABLE: LATEST ORDERS -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Lista de Campañas</h3>
            
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" id="fa_cam"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                      <tr>
                        <!--<th>Folio</th>-->
                        <th>Nombre</th>
                        <th width="70px">Estatus</th>
                        <th width="115px">Cuestionario(s)</th>
                        <th style="width:150px; text-align:center;"></th>
                      </tr>
                      </thead>
                      <tbody id="cam_tbody">
                      </tbody>
                    </table>
                  </div>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                  <button type="button" class="btn btn-sm btn-info btn-flat pull-left" onClick="addCampania();">Nueva campaña</button>
                  <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">Ver todas las campañas</a>
                </div>
                <!-- /.box-footer -->
              </div>
  	  		  <!-- /.box -->
          	</div>
            
            <!-- Sub campañas -->
            <div class="col-md-6 col-sm-6 col-xs-12">
  	  		  <!-- TABLE: Sub campaña -->
              <div class="box box-info" id="bx_sub" style="display:none;">
                <div class="box-header with-border">
                  <h3 class="box-title">Lista de Cuestionarios <br /><strong id="lb_sub"></strong></h3>
            
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" id="fa_sub"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                      <tr>
                        <th>Nombre</th>
                        <th width="70px">Nº Pregunta(s)</th>
                        <th width="70px">Estatus</th>
                        <th width="40px"></th>
                      </tr>
                      </thead>
                      <tbody id="subcam_tbody">
                      </tbody>
                    </table>
                  </div>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                  <button type="button" class="btn btn-sm btn-info btn-flat pull-left" id="btn_subcam" onClick="addCampania();">Nuevo cuestionario</button>
                </div>
                <!-- /.box-footer -->
              </div>
  	  		  <!-- /.box -->
          	</div>
            
            <!-- Preguntas -->
            <div class="col-md-12 col-sm-12 col-xs-12">
  	  		  <!-- TABLE: Sub campaña -->
              <div class="box box-warning" id="bx_pre" style="display:none;">
                <div class="box-header with-border">
                  <h3 class="box-title">Lista de Preguntas <br /><strong></strong></h3>
            
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" id="fa_pre"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="fc fc-unthemed fc-ltr">
                    	<div class="fc-toolbar fc-header-toolbar">
                           <div class="fc-center">
                          		<h2 id="lb_pre"></h2>
                           </div>
                        	<div class="fc-left">
                               	<button type="button" class="fc-agendaWeek-button fc-button fc-state-default" id="btn_subcam" onClick="regresarSubCampania();">
                                	<span class="fa fa-fw fa-chevron-left"></span>
                                    Regresar
                                </button>
                            	<div class="fc-button-group">
                                	<button type="button" class="fc-prev-button fc-button fc-state-default fc-corner-left" onclick="newPregunta();">
                                    	<span class="fa fa-fw fa-file-o"></span>
                                        Nueva Pregunta
                                    </button>
                                </div>
                            	<div class="fc-button-group">
                                    <button type="button" class="fc-next-button fc-button fc-state-default fc-corner-right" onclick="verPreguntas();">
                                    	<span class="fa fa-fw fa-list-alt"></span>
                                        Visualizar Todo
                                    </button>
                                    <button type="button" class="fc-next-button fc-button fc-state-default fc-corner-right" onClick="verLogica();">
                                    	<span class="fa fa-fw fa-chain-broken"></span>
                                        Generar Lógica
                                    </button>
                                </div>
                            	<div class="fc-button-group">
                                    <button type="button" class="fc-next-button fc-button fc-state-default fc-corner-right">
                                    	<span class="fa fa-fw fa-bar-chart"></span>
                                        Ver Avance
                                    </button>
                                </div>
                           </div>
                           <div class="fc-right">
                           </div>
                           <div class="fc-clear"></div>
                        </div>
                    </div>
                  
                  <div class="table-responsive timeline-preguntas">
                  	<ul class="timeline" id="time_preguntas"></ul>
                  </div>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                </div>
                <!-- /.box-footer -->
              </div>
  	  		  <!-- /.box -->
          	</div><!-- Fin Preguntas -->
          </div>
    </section><!-- /.content -->
</div>

<div class="modal fade" id="">
  <div class="modal-dialog modal-lg fadeInUp animated">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="display:none;">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Nueva Pregunta</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="modal-preguntas" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog modal-full">
        <div class="modal-content p-0">
            <div class="modal-header">
                <h4 class="modal-title" id="lb_new_pregunta">Visualizar Pregunta</h4>
            </div>
            <ul id="lista-preguntas" class="nav nav-tabs nav-justified">
            	<?php
					echo $this->htmlTab("seleccionar-1", "Seleccionar", "verTab(1);", "", true , true);
					echo $this->htmlTab("editar-1",		 "Editar"	  , "verTab(2);", "", false, false);
					echo $this->htmlTab("visualizar-1",	 "Visualizar" , "verTab(3);", "", false, false);
					echo $this->htmlTab("logica-1",		 "Lógica"	  , "verTab(4);", "", false, false);
				?>
            </ul> 
            <div id="lista-tab-preguntas" class="tab-content"> 
                <div class="tab-pane active" id="seleccionar-1"> 
                    <div><?php $inPreguntas->getTabSeleccionar($this); ?></div> 
                </div> 
                <div class="tab-pane" id="editar-1">
                	<p><strong>Descripción:</strong> <span id="tab-desc"></span></p>
                    <div class="form-group">
                        <label for="codigo_pregunta">Nombre corto / codigo</label>
                        <input type="text" class="form-control" id="codigo_pregunta" placeholder="Ingresa un codigo para identificar la pregunta">
                    </div>
                    <div class="form-group">
                        <label>Texto de la pregunta / informacion</label>
	                    <textarea id="txt_pregunta" name="editor1" rows="10" cols="80"></textarea>
                    </div>
                    <?php $inPreguntas->getTabEditar(); ?>
                </div> 
                
                <div class="tab-pane" id="visualizar-1">
                	<p>Para realizar ajuste de forma rapido solo de un clic sobre el texto de la pregunta para realizar ediciones rapidas</p>
                	<?php $inPreguntas->getBoxPrevisualizar("txt_visualizar"); ?>
                </div> 
                
                <div class="tab-pane" id="logica-1">
                    <p>Luckily friends do ashamed to do suppose. Tried meant mr smile so. Exquisite behaviour as to middleton perfectly. Chicken no wishing waiting am. Say concerns dwelling graceful six humoured. Whether mr up savings talking an. Active mutual nor father mother exeter change six did all. </p> 
                    <p>Carriage quitting securing be appetite it declared. High eyes kept so busy feel call in. Would day nor ask walls known. But preserved advantage are but and certainty earnestly enjoyment. Passage weather as up am exposed. And natural related man subject. Eagerness get situation his was delighted. </p> 
                </div> 
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" id="modal-cerrar" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn_pregunta" onclick="addPregunta();">Agregar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="modal-preguntas-visualizar" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog modal-full">
        <div class="modal-content p-0">
            <div class="modal-header">
                <h4 class="modal-title">Visualizar</h4>
            </div>
            <div class="tab-content"> 
                <div class="tab-pane active">
                	<?php $inPreguntas->getBoxPrevisualizar("txt_visualizar_vista"); ?>
                </div> 
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="closeBoxAddPreguntas(); reBox1();">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="modal-logica-visualizar" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog modal-full" style="width: auto;">
        <div class="modal-content p-0">
            <div class="modal-header">
                <h4 class="modal-title">Generar Lógica</h4>
            </div>
            <div class="modal-content timeline-preguntas galy-logic-modal"> 
				<div class="popover fade bottom in" role="tooltip" id="popover01" style="display: none; width: 400px; max-width: 500px;">
					<div class="arrow" style="left: 50%;"></div>
					<h3 class="popover-title">Opciones</h3>
					<div class="popover-content">
						<table class="table table-pop">
							<thead>
								<tr>
									<th>#</th>
									<th>Atributo</th>
									<th width="50%">Código</th>
									<th width="20%">Valor</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>Facilidad</td>
									<td>menor o igual que <small>(<=)</small></td>
									<td>6</td>
								</tr>
								<tr>
									<td>1</td>
									<td>Facilidad</td>
									<td>mayor o igual que <small>(>=)</small></td>
									<td>9</td>
								</tr>
								
								<tr>
									<td>2</td>
									<td>2</td>
									<td>igual que <small>(=)</small></td>
									<td>Sí</td>
								</tr>
							</tbody>
							<tfoot>
								<tr class="tabTr01">
									<th></th>
									<th>
										<select class="form-control tab1-atributo">
											<option value="1">Sincero</option>
											<option value="2">Facilidad</option>
										</select>
									</th>
									<th>
										<select class="form-control tab1-codigo">
											<!--<option value="<>">entre</option>
											<option value="!<>">no está entre</option>-->
											<option value="=">igual a</option>
											<option value="!=">no igual a</option>
											<option value=">">mayor que</option>
											<option value="<">menor que</option>
											<option value=">=">mayor o igual que</option>
											<option value="<=">menor o igual que</option>
										</select>
									</th>
									<th class="form-group">
										<input class="form-control input-sm tab1-valor" type="number" placeholder="Valor">
										<span class="help-block"></span>
									</th>
								</tr>
								<tr class="tabTr02">
									<th></th>
									<th>
										<select class="form-control tab2-atributo">
											<option value="1">Sincero</option>
											<option value="2">Facilidad</option>
										</select>
									</th>
									<th>
										<select class="form-control tab2-codigo">
											<option value="=">igual a</option>
											<option value="!=">no igual a</option>
										</select>
									</th>
									<th>
										<select class="form-control tab2-valor">
											<option value="1">Si</option>
											<option value="2">No</option>
										</select>
									</th>
								</tr>
								<tr class="tabTr03">
									<th></th>
									<th colspan="2">
										<button type="button" class="btn btn-block btn-success btn-xs">Agregar</button>
									</th>
									<th></th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				
                <div id="bxLogic" class="galy-logic"></div>
				<style>
					.galy-logic-modal{
						background-color: #C0C0C0;
						background-image: url(myCss/img/logic01.png);
					}
					
					.galy-logic{
						height: 500px;
						width: 100%;
					}
					
					.galy-logic .logic-obj{
						position: absolute;
						text-align: center;
						font-size: 12px;
						opacity: 0.8;
						z-index: 10;
						background: none;
						box-shadow: none;
						border: none;
						border-radius: 0;
						min-width: 0;
						min-height: 0;
					}
					
					.galy-logic .logic-obj .logic-icon{
						width: 100%;
						height: 100%;
					}
					
					.galy-logic .logic-obj .logic-element{
						width: 100%;
						background-color: #C0C0C0;
						border: solid 1px #413F40;
					}
					
					.galy-logic .logic-obj .logic-element thead th{
						height: 26px;
					}
					
					.galy-logic .logic-obj .logic-element thead th:nth-child(1){
						width: 20px;
						background-color: #336799;
					}
					
					.galy-logic .logic-obj .logic-element thead th:nth-child(2){
						background-color: #E6E6E6;
						text-align: center;
					}
					
					.galy-logic .logic-obj .logic-element thead th:nth-child(2):hover{
						cursor: move;
					}
					
					.galy-logic .logic-obj .logic-element thead th:nth-child(1):hover,
					.galy-logic .logic-obj .logic-element thead th:nth-child(3):hover,
					.galy-logic .logic-obj .logic-element tbody svg:hover{
						cursor: pointer;
					}
					
					.galy-logic .logic-obj .logic-element tfoot th:nth-child(2){
						background-color: #6b6b6b;
						color: #dedede;
						text-align: center;
					}
					
					.galy-logic .logic-obj .logic-element thead th:nth-child(3){
						width: 20px;
						background-color: #CB6666;
					}
					
					.galy-logic .logic-obj .logic-element tbody td{
						min-height: 26px;
					}
					
					.galy-logic .logic-obj .logic-element tfoot{
						border-top: solid 1px #413F40;
						background-color: #b0b0ae;
					}
					
					.galy-logic .logic-obj .logic-element tbody td:nth-child(1),
					.galy-logic .logic-obj .logic-element tbody td:nth-child(4),
					.galy-logic .logic-obj .logic-element tfoot td:nth-child(1),
					.galy-logic .logic-obj .logic-element tfoot td:nth-child(4){
						width: 20px;
						background-color: #ACACAA;
						padding-top: 5px;
					}
					
					.galy-logic .logic-obj .logic-element tfoot td:nth-child(1),
					.galy-logic .logic-obj .logic-element tfoot td:nth-child(4){
						background-color: #c0c0c0;
					}
					
					.galy-logic .logic-obj .logic-element tbody td:nth-child(2){
						text-align: left;
						padding-left: 3px;
					}
					
					.galy-logic .logic-obj .logic-element tbody td:nth-child(3){
						text-align: right;
						padding-right: 3px;
					}
					
					.galy-logic .LogicLine{
						position: absolute;
					}
					
					.table-pop td:nth-child(2),
					.table-pop td:nth-child(4),
					.table-pop th:nth-child(2),
					.table-pop th:nth-child(4){
						text-align: center;
					}
					
					.galy-logic-modal .table-pop .tools{
						display: none;
						color: #dd4b39;
						position: absolute;
						margin-left: 15px;
					}
					
					.galy-logic-modal .table-pop .tools .fa{
							margin-right: 5px;
							cursor: pointer;
					}
					
					.galy-logic-modal .table-pop tbody tr:hover .tools{
						display: inline-block;
					}
				</style>
				<script>
					function prueba(){
						var inDatos = [
							{
								"id":"1",
								"txt":"Instrucciones",
								"cx":"12",
								"cy":"148",
								"cw":"130",
								"lgcI":[ ],
								"lgcD":[ { txt: " ", id: 1 } ],
								"lgcIlig":[],
								"lgcDlig":[]
							}
							,{
								"id":"2",
								"txt":"Pregunta 1",
								"cx":"172",
								"cy":"126",
								"cw":"130",
								"lgcI":[ { txt: " ", id: 1 } ],
								"lgcD":[ { txt: "<7", id: 2 }, { txt: ">8", id: 3 }, { txt: " ", id: 4 } ],
								"lgcIlig":[],
								"lgcDlig":[]
							}
							,{
								"id":"3"
								,"txt":"Pregunta 1a"
								,"cx":"340"
								,"cy":"134"
								,"cw":"130"
								,"lgcI":[ { txt: " ", id: 1 }  ]
								,"lgcD":[ { txt: " ", id: 2 }  ]
								,"lgcIlig":[]
								,"lgcDlig":[]
							}
							,{
								"id":"4"
								,"txt":"Pregunta 1b"
								,"cx":"341"
								,"cy":"216"
								,"cw":"130"
								,"lgcI":[ { txt: " ", id: 1 }  ]
								,"lgcD":[ { txt: " ", id: 2 }  ]
								,"lgcIlig":[]
								,"lgcDlig":[]
							}
							,{
								"id":"5",
								"txt":"Pregunta 2",
								"cx":"500",
								"cy":"169",
								"cw":"130",
								"lgcI":[ { txt: " ", id: 1 }  ],
								"lgcD":[ { txt: " ", id: 2 }  ],
								"lgcIlig":[],
								"lgcDlig":[]
							}
							,{
								"id":"6",
								"txt":"Pregunta 3",
								"cx":"656",
								"cy":"167",
								"cw":"130",
								"lgcI":[ { txt: " ", id: 1 }  ],
								"lgcD":[ { txt: "SI", id: 2 }, { txt: "NO", id: 3 }  ],
								"lgcIlig":[],
								"lgcDlig":[]
							}
							,{
								"id":"7",
								"txt":"Pregunta 4",
								"cx":"823",
								"cy":"223",
								"cw":"130",
								"lgcI":[ { txt: " ", id: 1 }  ],
								"lgcD":[ { txt: " ", id: 2 }  ],
								"lgcIlig":[],
								"lgcDlig":[]
							}
							,{
								"id":"8",
								"txt":"Pregunta 5",
								"cx":"973",
								"cy":"162",
								"cw":"130",
								"lgcI":[],
								"lgcI":[ { txt: " ", id: 1 }  ],
								"lgcD":[ { txt: " ", id: 2 }  ],
								"lgcIlig":[],
								"lgcDlig":[]
							}
							,{
								"id":"9",
								"txt":"Salida",
								"cx":"1165",
								"cy":"165",
								"cw":"130",
								"lgcI":[ { txt: " ", id: 1 }  ],
								"lgcD":[],
								"lgcIlig":[],
								"lgcDlig":[]
							}
						];
						
						
						//inDatos = [{"id":"1","txt":"Instrucciones","cx":"12","cy":"148","cw":"130","lgcI":[],"lgcD":[{"txt":" ","id":"1"}],"lgcIlig":[],"lgcDlig":[]},{"id":"2","txt":"Pregunta 1","cx":"172","cy":"126","cw":"130","lgcI":[{"txt":" ","id":"1"}],"lgcD":[{"txt":"<7","id":"2"},{"txt":">8","id":"3"},{"txt":" ","id":"4"}],"lgcIlig":[],"lgcDlig":[]},{"id":"3","txt":"Pregunta 1a","cx":"340","cy":"134","cw":"130","lgcI":[{"txt":" ","id":"1"}],"lgcD":[{"txt":" ","id":"2"}],"lgcIlig":[],"lgcDlig":[]},{"id":"4","txt":"Pregunta 1b","cx":"341","cy":"216","cw":"130","lgcI":[{"txt":" ","id":"1"}],"lgcD":[{"txt":" ","id":"2"}],"lgcIlig":[{"txt":"L1","id":"3"}],"lgcDlig":[{"txt":"L1","id":"4"}]},{"id":"5","txt":"Pregunta 2","cx":"500","cy":"169","cw":"130","lgcI":[{"txt":" ","id":"1"}],"lgcD":[{"txt":" ","id":"2"}],"lgcIlig":[{"txt":"L1","id":"2"}],"lgcDlig":[]},{"id":"6","txt":"Pregunta 3","cx":"656","cy":"167","cw":"130","lgcI":[{"txt":" ","id":"1"}],"lgcD":[{"txt":"SI","id":"2"},{"txt":"NO","id":"3"}],"lgcIlig":[],"lgcDlig":[]},{"id":"7","txt":"Pregunta 4","cx":"823","cy":"223","cw":"130","lgcI":[{"txt":" ","id":"1"}],"lgcD":[{"txt":" ","id":"2"}],"lgcIlig":[],"lgcDlig":[]},{"id":"8","txt":"Pregunta 5","cx":"973","cy":"162","cw":"130","lgcI":[{"txt":" ","id":"1"}],"lgcD":[{"txt":" ","id":"2"}],"lgcIlig":[],"lgcDlig":[]},{"id":"9","txt":"Salida","cx":"1165","cy":"165","cw":"130","lgcI":[{"txt":" ","id":"1"}],"lgcD":[],"lgcIlig":[],"lgcDlig":[]}];
						
						var inDatosLogic = [
							{ idP: 1, idH: 1, idLogs: [
								{ idP: 2, idH: 1 }
							] }
							, { idP: 2, idH: 2, idLogs: [
								{ idP: 3, idH: 1 }
							] }
							, { idP: 2, idH: 3, idLogs: [
								{ idP: 3, idH: 1 }
							] }
							, { idP: 2, idH: 4, idLogs: [
								{ idP: 4, idH: 1 }
							] }
							, { idP: 3, idH: 2, idLogs: [
								{ idP: 5, idH: 1 }
							] }
							, { idP: 4, idH: 2, idLogs: [
								{ idP: 5, idH: 1 }
							] }
							, { idP: 5, idH: 2, idLogs: [
								{ idP: 6, idH: 1 }
							] }
							, { idP: 6, idH: 2, idLogs: [
								{ idP: 8, idH: 1 }
							] }
							, { idP: 6, idH: 3, idLogs: [
								{ idP: 7, idH: 1 }
							] }
							, { idP: 7, idH: 2, idLogs: [
								{ idP: 8, idH: 1 }
							] }
							, { idP: 8, idH: 2, idLogs: [
								{ idP: 9, idH: 1 }
							] }
						];
						
						GalyLogic.setIniDatos("bxLogic", inDatos, inDatosLogic);
						MoverElementos.setFinalFun = function(){ GalyLogic.getUpLineas() };
					}
					
					var GalyLogic = {
						// GalyLogic.getUpLineas()
						  inPreguntas: Array()
						, inPreguntasLog: Array()
						, pop: "popover01"
						, tabPop: "table-pop"
						, actAddInt: 0
						, actAddAut: 0
						, actAddObj: null
						, tab1_atributo: null
						, tab1_codigo: null
						, tab1_valor: null
						, tab2_atributo: null
						, tab2_codigo: null
						, tab2_valor: null
						, setIniDatos: function(obj, InDatos, InDatosLogic){
							$("#"+obj).html("");
							
							for(i = 0; i < InDatos.length; i++){
								var logicObj = GalyLogic.getDivElem( InDatos[i] );
								$("#"+obj).append(logicObj);
							}// Fin Box
							
							GalyLogic.inPreguntas = InDatos;
							GalyLogic.inPreguntasLog = InDatosLogic;
							InLogic = InDatosLogic;
							InObj = obj;
							GalyLogic.getUpLineas();
							
							var btn = $("."+GalyLogic.tabPop).find("tfoot").find(".tabTr03").find("button");
							btn[0].addEventListener("click", GalyLogic.addLogcF, false);
							$("."+GalyLogic.tabPop).find(".tab1-valor") .keyup(function (event) {
								var isL = GalyLogic.addValLogcF(true, $(this));
								return Galy.soloNumeros(event);
							});
							GalyLogic.tab1_atributo = $("."+GalyLogic.tabPop).find(".tab1-atributo");
							GalyLogic.tab1_codigo   = $("."+GalyLogic.tabPop).find(".tab1-codigo");
							GalyLogic.tab1_valor    = $("."+GalyLogic.tabPop).find(".tab1-valor");
							GalyLogic.tab2_atributo = $("."+GalyLogic.tabPop).find(".tab2-atributo");
							GalyLogic.tab2_codigo   = $("."+GalyLogic.tabPop).find(".tab2-codigo");
							GalyLogic.tab2_valor    = $("."+GalyLogic.tabPop).find(".tab2-valor");
						}// Final IniDatos
						, Draw: function(){
							$("#"+InObj).html("");
							
							for(i = 0; i < GalyLogic.inPreguntas.length; i++){
								var logicObj = GalyLogic.getDivElem( GalyLogic.inPreguntas[i] );
								$("#"+InObj).append(logicObj);
							}// Fin Box
							GalyLogic.getUpLineas();
							
						}
						, getDivElem: function(InDato){
							var logicObj = Galy.getElemC("div", "logic-obj");
							logicObj.id = "logObj" + InDato.id;
							logicObj.setAttribute("mId", InDato.id);
							logicObj.style.left  = InDato.cx + "px";
							logicObj.style.top   = InDato.cy + "px";
							logicObj.style.width = InDato.cw + "px";
							var lgTab = Galy.getElemC("table", "logic-element");
							var lgTabTr = Galy.getElem("tr");
							var lgTabTh = Galy.getElem("th");
							//lgTabTh.setAttribute("onclick", "GalyLogic.addLogic("+InDato.id+", 1)");
							$(lgTabTr).append( lgTabTh );
							var lgTabCab = Galy.getElemCA("th", "2", InDato.txt, "colspan", "");
							MoverElementos.getMovElemento(lgTabCab, logicObj.id);
							$(lgTabTr).append( lgTabCab );
							var lgTabTh = Galy.getElem("th");
							lgTabTh.setAttribute("onclick", "GalyLogic.addLogic("+InDato.id+", 2)");
							lgTabTh.setAttribute("data-toggle", "popover");
							lgTabTh.setAttribute("data-placement", "bottom");
							lgTabTh.setAttribute("data-content", "Agregar");
							$(lgTabTr).append( lgTabTh );
							var lgTabH = Galy.getElem("thead");
							$(lgTabH).append( lgTabTr );
							$(lgTab).append( lgTabH );

							var lgTabB = Galy.getElem("tbody");
							for(j = 0; j < InDato.lgcI.length || j < InDato.lgcD.length; j++){
								var lgTabTr = Galy.getElem("tr");
								if(j < InDato.lgcI.length){
									var id = InDato.id + "_" + InDato.lgcI[j].id;
									GalyLogic.getElemTD( lgTabTr, true, [ GalyLogic.getSVGPoint(id, "336799"), InDato.lgcI[j].txt ] );
								}else{
									GalyLogic.getElemTD( lgTabTr, false, null );
								}

								if(j < InDato.lgcD.length){
									var id = InDato.id + "_" + InDato.lgcD[j].id;
									GalyLogic.getElemTD( lgTabTr, true, [InDato.lgcD[j].txt, GalyLogic.getSVGPoint(id, "D95F62") ] );
								}else{
									GalyLogic.getElemTD( lgTabTr, false, null );
								}
								$(lgTabB).append( lgTabTr );
							}// Fin Saltos
							$(lgTab).append( lgTabB );

							var lgTabF = Galy.getElem("tfoot");
							if(InDato.lgcIlig.length > 0 || InDato.lgcDlig.length > 0){
								var lgTabTr = Galy.getElem("tr");
								$(lgTabTr).append( Galy.getElem("th") );
								$(lgTabTr).append( Galy.getElemCA("th", "2", "Liga", "colspan", "") );
								$(lgTabTr).append( Galy.getElem("th") );
								$(lgTabF).append( lgTabTr );
							}
							for(j = 0; j < InDato.lgcIlig.length || j < InDato.lgcDlig.length; j++){
								var lgTabTr = Galy.getElem("tr");
								if(j < InDato.lgcIlig.length){
									var id = InDato.id + "_" + InDato.lgcIlig[j].id;
									GalyLogic.getElemTD( lgTabTr, true, [ GalyLogic.getSVGPoint(id, "336799"), InDato.lgcIlig[j].txt ] );
								}else{
									GalyLogic.getElemTD( lgTabTr, false, null );
								}

								if(j < InDato.lgcDlig.length){
									var id = InDato.id + "_" + InDato.lgcDlig[j].id;
									GalyLogic.getElemTD( lgTabTr, true, [ InDato.lgcDlig[j].txt, GalyLogic.getSVGPoint(id, "D95F62") ] );
								}else{
									GalyLogic.getElemTD( lgTabTr, false, null );
								}
								$(lgTabF).append( lgTabTr );
							}// Fin Saltos
							$(lgTab).append( lgTabF );

							$(logicObj).append( lgTab );
							return logicObj;
						}
						, getUpLineas: function(){
							$("#"+GalyLogic.pop).css("display", "none");
							$(".LogicLine").remove();
							var posPadre = $("#"+InObj).position();
							var posOff = $("#"+InObj).parent().offset();
							for(i = 0; i < InLogic.length; i++){
								var $idEleIni = $("#Point_"+InLogic[i].idP+"_"+InLogic[i].idH);
								var $idEleIniPos = $idEleIni.position();
								
								for(j = 0; j < InLogic[i].idLogs.length; j++){
									var $idEleFin = $("#Point_"+InLogic[i].idLogs[j].idP+"_"+InLogic[i].idLogs[j].idH).offset();
									$idEleFin.left -= $idEleIniPos.left;
									$idEleFin.top -= $idEleIniPos.top;
									var position = {
										w: $idEleFin.left
										, h: $idEleFin.top
										, x1: 0, y1: 0
										, x2: Math.abs($idEleFin.left)
										, y2: Math.abs($idEleFin.top)
										, offX: 0, offY: 0
									};
									
									if( position.w < 0 && position.h < 0 ){
										x1 = position.x1;
										y1 = position.y1;
										x2 = position.x2;
										y2 = position.y2;
										
										position.offX = position.w ;
										position.offY = position.h ;
									}else if( position.w > 0 && position.h < 0 ){
										x1 = position.x1;
										y1 = position.y2;
										x2 = position.x2;
										y2 = position.y1;
										
										position.offY = position.h ;
									}else if( position.w < 0 && position.h > 0 ){
										x1 = position.x1;
										y1 = position.y2;
										x2 = position.x2;
										y2 = position.y1;
										
										position.offX = position.w ;
									}else{
										x1 = position.x1;
										y1 = position.y1;
										x2 = position.x2;
										y2 = position.y2;
									}
									
									w = Math.abs(position.w);
									h = Math.abs(position.h);
									
									if(w == 0)
										w = 1;
									if(h == 0)
										h = 1;
									
									var svgLine = GalyLogic.getSVGLine(1, "3e3e3e", w, h, x1, y1, x2, y2 );
									svgLine.style.left = $idEleIniPos.left - posOff.left - posPadre.left + position.offX + 8;
									svgLine.style.top = $idEleIniPos.top - posOff.top - posPadre.top + position.offY + 8;
									$("#"+InObj).append( svgLine );
								}
							}
						}
						, updatePos: function(){
							var id = elMovimiento.getAttribute("mid");
							GalyLogic.actAddObj = GalyLogic.getElemnById(id);
							GalyLogic.actAddObj.cx = parseFloat(elMovimiento.style.left.replace("px", ""));
							GalyLogic.actAddObj.cy = parseFloat(elMovimiento.style.top.replace("px", ""));
						}
						, getElementos: function(){
							var inDatos = Array();
							$.each($("#"+obj).find(".logic-obj"), function( key, value ) {
								var logicObj = GalyLogic.getBsEl();
								logicObj.id = value.id.replace("logObj", "");
								logicObj.txt = $($(value).find("thead").find("th")[1]).html();
								logicObj.cx = value.style.left.replace("px", "");
								logicObj.cy = value.style.top.replace("px", "");
								logicObj.cw = value.style.width.replace("px", "");
								
								$.each($(value).find("tr"), function( keyTr, inTR ) {
									var inTD = $(inTR).find("td");
									if(inTD.length>1){
										if(inTR.parentElement.tagName == "TBODY"){
											GalyLogic.getLogicPointElem(inTD, logicObj.lgcI, logicObj.id, 1, 0);
											GalyLogic.getLogicPointElem(inTD, logicObj.lgcD, logicObj.id, 2, 3);
										}else{
											GalyLogic.getLogicPointElem(inTD, logicObj.lgcIlig, logicObj.id, 1, 0);
											GalyLogic.getLogicPointElem(inTD, logicObj.lgcDlig, logicObj.id, 2, 3);
										}
									}
								});
								
								inDatos.push( logicObj );
							});
							
							GalyLogic.inPreguntas = inDatos;
							return inDatos;
						}
						, getBsEl: function(){
							return {
								id: "",
								txt: "",
								cx: "",
								cy: "",
								cw: "",
								lgcI: [  ],
								lgcD: [  ],
								lgcIlig: [ ],
								lgcDlig: [ ],
								pregunta: { }
							}
						}
						, getBsEllgc: function(inTxt, inID){
							return {
								txt: inTxt,
								id: inID,
								logic: GalyLogic.getBsElLogic()
							}
						}
						, getBsElLogic: function(){
							return {
								tab: 0,
								atri: 0,
								codi: 0,
								valor: 0
							}
						}
						, getCX: function(cx, i){
							if( cx == null || cx == ""){
								cx = (160 * i) + 20;
							}
							return cx;
						}
						, getCY: function(cy, i){
							if( cy == null || cy == ""){
								cy = 100;
							}
							return cy;
						}
						, getCW: function(cw, i){
							if( cw == null || cw == ""){
								cw = 130;
							}
							return cw;
						}
						, getLogicPointElem: function(InTD, FinObj, id, x, y){
							if( InTD[x].innerHTML != "" ){
								var id = $(InTD[y]).find("svg").attr("id").replace("Point_"+id+"_", "");
								FinObj.push( { txt: InTD[x].innerHTML, id: id } );
							}else{
								return null;
							}
						}
						, getSVGPoint: function(id, color){
							var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
							svg.setAttributeNS(null,"id","Point_"+id);
							svg.setAttributeNS(null,"height","16");
							svg.setAttributeNS(null,"width","16");
							var circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
							circle.setAttributeNS(null, "cx", "8");
							circle.setAttributeNS(null, "cy", "8");
							circle.setAttributeNS(null, "r", "8");
							circle.setAttributeNS(null, "stroke-width", "0");
							circle.setAttributeNS(null, "fill", "#"+color);
							svg.appendChild(circle);
							return svg;
						}
						, getSVGLine: function(id, color, w, h, x1, y1, x2, y2){
							var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
							svg.setAttributeNS(null,"id","Line_"+id);
							svg.setAttributeNS(null,"width",  w);
							svg.setAttributeNS(null,"height", h);
							svg.setAttributeNS(null,"class","LogicLine");
							var line = document.createElementNS("http://www.w3.org/2000/svg", "line");
							line.setAttributeNS(null, "x1", x1);
							line.setAttributeNS(null, "y1", y1);
							line.setAttributeNS(null, "x2", x2);
							line.setAttributeNS(null, "y2", y2);
							line.setAttributeNS(null, "style", "stroke:#"+color+";stroke-width:1");
							svg.appendChild(line);
							return svg;
						}
						, getElemTD: function(lgTabTr, esPoint, elements){
							if(esPoint){
								$(lgTabTr).append( Galy.getElemCO("td", "", elements[0]) );
								$(lgTabTr).append( Galy.getElemCO("td", "", elements[1]) );
							}else{
								$(lgTabTr).append( Galy.getElem("td") );
								$(lgTabTr).append( Galy.getElem("td") );
							}
						}
						, getElemnById: function(id){
							var obj = null;
							for(i = 0; i < GalyLogic.inPreguntas.length; i++){
								if(GalyLogic.inPreguntas[i].id == id){
									obj = GalyLogic.inPreguntas[i];
									break;
								}
							}
							return obj;
						}
						, addLogic: function(id, tp){
							//$('#modal-logic').modal('show');
							var left = $("#logObj"+id).position().left + $("#logObj"+id).width()
								- ( $("#"+GalyLogic.pop).width() / 2 ) - 10 + $(".galy-logic-modal").scrollLeft();
							var top = $("#logObj"+id).position().top + 26 + $(".galy-logic-modal").scrollTop();
							var es_block = true;
							
							if( $("#"+GalyLogic.pop).css("left") == left+"px" && $("#"+GalyLogic.pop).css("top") == top+"px" ){
								if($("#"+GalyLogic.pop).css("display") == "none"){
									$("#"+GalyLogic.pop).css("display", "block");
								}else{
									es_block = false;
									$("#"+GalyLogic.pop).css("display", "none");
								}
							}else{
								$("#"+GalyLogic.pop).css("display", "block");
								$("#"+GalyLogic.pop).css("left", left);
								$("#"+GalyLogic.pop).css("top", top);
							}
							
							if(es_block){
								GalyLogic.actAddObj = GalyLogic.getElemnById(id);
								
								if(GalyLogic.actAddObj != null){
									$("."+GalyLogic.tabPop).find("th").css("display", "none");
									$("."+GalyLogic.tabPop).find("tbody").html("");
									var tabTh = $("."+GalyLogic.tabPop).find("thead").find("tr").find("th");
									var tabTf01 = $("."+GalyLogic.tabPop).find("tfoot").find(".tabTr01").find("th");
									var tabTf02 = $("."+GalyLogic.tabPop).find("tfoot").find(".tabTr02").find("th");
									var tabTf03 = $("."+GalyLogic.tabPop).find("tfoot").find(".tabTr03").find("th");

									// Iniciar Atributos - Codigo - Valores
									$("."+GalyLogic.tabPop).find(".help-block").parent().attr("class", "form-group");
									$("."+GalyLogic.tabPop).find(".help-block").html("");
									
									GalyLogic.actAddInt = GalyLogic.actAddObj.pregunta.tp_preg;
									switch(GalyLogic.actAddInt){
										case "0":
											$("#"+GalyLogic.pop).css("display", "none");
											break;
											
										case "1":
											$("#"+GalyLogic.pop).css("display", "none");
											break;
											
										case "2":
											$( tabTh[2] ).css("display", "");
											$( tabTh[3] ).css("display", "");
											
											$( tabTf01[2] ).css("display", "");
											$( tabTf01[3] ).css("display", "");
											
											$( tabTf03[1] ).css("display", "");
											
											/*
											$("."+GalyLogic.tabPop).find("tbody").html(''
												+'<tr>'
												+'	<td>menor o igual que <small>(<=)</small></td>'
												+'	<td>6</td>'
												+'</tr>'
												+'<tr>'
												+'	<td>mayor o igual que <small>(>=)</small></td>'
												+'	<td>9</td>'
												+'</tr>');
											*/
											break;
											
										case "3":
											$( tabTh[2] ).css("display", "");
											$( tabTh[3] ).css("display", "");
											
											$( tabTf02[2] ).css("display", "");
											$( tabTf02[3] ).css("display", "");
											
											$( tabTf03[1] ).css("display", "");
											
											$("."+GalyLogic.tabPop).find("tbody").html(''
												+'<tr>'
												+'	<td>igual que <small>(=)</small></td>'
												+'	<td>Sí</td>'
												+'</tr>'
												+'<tr>'
												+'	<td>igual que <small>(=)</small></td>'
												+'	<td>No</td>'
												+'</tr>');
											break;
											
										case "4":
											$( tabTh ).css("display", "");
											
											$( tabTf01 ).css("display", "");
											$( tabTf02 ).css("display", "");
											
											$( tabTf03 ).css("display", "");
											
											$("."+GalyLogic.tabPop).find("tbody").html(''
												+'<tr>'
												+'	<td>1</td>'
												+'	<td>Facilidad</td>'
												+'	<td>menor o igual que <small>(<=)</small></td>'
												+'	<td>6</td>'
												+'</tr>'
												+'<tr>'
												+'	<td>1</td>'
												+'	<td>Facilidad</td>'
												+'	<td>mayor o igual que <small>(>=)</small></td>'
												+'	<td>9</td>'
												+'</tr>'
												+'<tr>'
												+'	<td>2</td>'
												+'	<td>2</td>'
												+'	<td>igual que <small>(=)</small></td>'
												+'	<td>Sí</td>'
												+'</tr>');

											break;
									}
									
									for(i = 0; i < GalyLogic.actAddObj.lgcD.length; i++){
										var inLogic = GalyLogic.actAddObj.lgcD[i];
										if(inLogic.txt.trim() != ""){
											GalyLogic.addLogcfFl(inLogic.logic.atri, inLogic.logic.codi, inLogic.logic.tab, inLogic.logic.valor);
										}
									}
									
								}
							}
							
							
						}
						, addValLogcF: function(isHand, inObj){
							var esValido = true;
							$(inObj).parent().attr("class", "form-group")
							$(inObj).parent().find(".help-block").html("")
							var alerTxt = "";
							
							switch( GalyLogic.actAddInt ){
								case "0":
									break;

								case "1":
									break;

								case "2":
									var valor = GalyLogic.tab1_valor.val();
									if(valor.trim() === ""){
										esValido = false;
										alerTxt = "Falta agregar el valor.";
									}else{
										valor = parseInt( valor );
										if(GalyLogic.actAddObj.pregunta.sub_pre == 1){
											if(valor < GalyLogic.actAddObj.pregunta.RS3_preg ||
											  	valor > GalyLogic.actAddObj.pregunta.RS4_preg){
												esValido = false;
												alerTxt = "El valor debe de estar entre "
														+ GalyLogic.actAddObj.pregunta.RS3_preg
														+ " y "
														+ GalyLogic.actAddObj.pregunta.RS4_preg + ".";
											}
										}else{
											
										}
									}
									break;

								case "3":
									break;

								case "4":
									break;

							}
							
							if(!esValido){
								if(isHand){
									$(inObj).parent().attr("class", "form-group has-error");
									$(inObj).parent().find(".help-block").html(alerTxt)
								}else{
									swal("", alerTxt, "warning");
								}
							}
							
							return esValido;
						}
						, addLogcF: function(){
							var atributo = "";
							var codigo = "";
							var valor = "";
							var tab = 1;
							
							switch( GalyLogic.actAddInt ){
								case "0":
									break;
									
								case "1":
									break;
									
								case "2":
									if(!GalyLogic.addValLogcF(false, null)){
										return false;
									}else{
										atributo = GalyLogic.tab1_codigo.find("option:selected").text();
										codigo = GalyLogic.tab1_codigo.val();
										valor = GalyLogic.tab1_valor.val();
										tab = 1;
									}
									break;
									
								case "3":
									break;
									
								case "4":
									break;
							}
							
							GalyLogic.addLogcfFl(atributo, codigo, tab, valor);

							// Iniciar
							var opt = GalyLogic.tab1_codigo.find("option");
							GalyLogic.tab1_codigo.val( $(opt[0]).val() );
							GalyLogic.tab1_valor.val("");
							GalyLogic.Draw();
						}
						, addLogcfFl: function(atributo, codigo, inTab, valor){
							var tbody = $("."+GalyLogic.tabPop).find("tbody");
							++GalyLogic.actAddAut;
							
							switch( GalyLogic.actAddInt ){
								case "0":
									break;
									
								case "1":
									break;
									
								case "2":
									var tr = Galy.getElem("tr");
									tr.id = "nA_cod_" + GalyLogic.actAddAut;
									var td = Galy.getElem("td");
									$(td).html( atributo + " ");
									$(td).append( Galy.getElemCT("small", "", "("+codigo+")") );
									$(tr).append( td );

									td = Galy.getElem("td");
									$(td).html(valor);
									$(tr).append( td );
									atributo += " " + valor;
									var btns = [
										 { txt: "fa-edit"	, clic: "editAtributo("+GalyLogic.actAddAut+");" }
										//,{ txt: "fa-files-o", clic: "dupAtributo("+GalyLogic.actAddAut+", '"+atributo+"');" }
										,{ txt: "fa-trash-o", clic: "delAtributo('cod_"+GalyLogic.actAddAut+"', '"+atributo+"', null, 'condición')" }
									];
									$(td).append(  Galy.getElemLListD(btns) );
									$(tbody).append(tr);

									var InLog = GalyLogic.getBsEllgc(codigo+valor, GalyLogic.actAddAut);
									InLog.logic.tab = inTab;
									InLog.logic.atri = atributo;
									InLog.logic.codi = codigo;
									InLog.logic.valor = valor;
									GalyLogic.actAddObj.lgcD.push(InLog );
									break;
									
								case "3":
									break;
									
								case "4":
									break;
								
							}
							
							
						}
					};
					
					var MoverElementos = {
						carga: function(){
							posicion=0; elMovimiento=null;

							// IE
							if(navigator.userAgent.indexOf("MSIE")>=0) navegador=0;
							// Otros
							else navegador=1;
						}
						, setFinalFun: function(){ }
						, getMovElemento: function(obj, id){
							obj.setAttribute("onmousedown", "MoverElementos.comienzoMovimiento(event, '"+id+"')");
							obj.setAttribute("parent", id);
							obj.addEventListener("touchmove", MoverElementos.handleMove, false);
							obj.addEventListener("touchstart", MoverElementos.handleStart, false);
							return obj;
						}
						, evitaEventos: function(event){
							// Funcion que evita que se ejecuten eventos adicionales
							if(navegador==0)
							{
								window.event.cancelBubble=true;
								window.event.returnValue=false;
							}
							if(navegador==1) event.preventDefault();
						}
						, comienzoMovimiento: function(event, id){
							elMovimiento=document.getElementById(id);

							/* Si el elemento que se le hizo click es texto (nodeType=3) se toma como target
							el elemento padre */
							if(elMovimiento.nodeType==3) elMovimiento=elMovimiento.parentNode;

							 // Obtengo la posicion del cursor
							if(navegador==0)
							 {
								cursorComienzoX=window.event.clientX+document.documentElement.scrollLeft+document.body.scrollLeft;
								cursorComienzoY=window.event.clientY+document.documentElement.scrollTop+document.body.scrollTop;

								document.attachEvent("onmousemove", MoverElementos.enMovimiento);
								document.attachEvent("onmouseup", MoverElementos.finMovimiento);
							}
							if(navegador==1)
							{    
								cursorComienzoX=event.clientX+window.scrollX;
								cursorComienzoY=event.clientY+window.scrollY;

								document.addEventListener("mousemove", MoverElementos.enMovimiento, true); 
								document.addEventListener("mouseup", MoverElementos.finMovimiento, true);
							}

							elComienzoX=parseInt(elMovimiento.style.left);
							elComienzoY=parseInt(elMovimiento.style.top);
							// Actualizo el posicion del elemento
							elMovimiento.style.zIndex=++posicion;

							MoverElementos.evitaEventos(event);
						}
						, enMovimiento: function(event){  
							var xActual, yActual;
							if(navegador==0)
							{    
								xActual=window.event.clientX+document.documentElement.scrollLeft+document.body.scrollLeft;
								yActual=window.event.clientY+document.documentElement.scrollTop+document.body.scrollTop;
							}  
							if(navegador==1)
							{
								xActual=event.clientX+window.scrollX;
								yActual=event.clientY+window.scrollY;
							}

							elMovimiento.style.left=(elComienzoX+xActual-cursorComienzoX)+"px";
							elMovimiento.style.top=(elComienzoY+yActual-cursorComienzoY)+"px";

							MoverElementos.evitaEventos(event);
							MoverElementos.setFinalFun();
						}
						, finMovimiento: function(event){
							if(navegador==0)
							{    
								document.detachEvent("onmousemove", MoverElementos.enMovimiento);
								document.detachEvent("onmouseup", MoverElementos.finMovimiento);
							}
							if(navegador==1)
							{
								document.removeEventListener("mousemove", MoverElementos.enMovimiento, true);
								document.removeEventListener("mouseup", MoverElementos.finMovimiento, true); 
							}
						}
						, handleStart: function(event){
							var touches = event.changedTouches;
							elMovimiento=document.getElementById(event.target.getAttribute("parent"));

							/* Si el elemento que se le hizo click es texto (nodeType=3) se toma como target
							el elemento padre */
							if(elMovimiento.nodeType==3) elMovimiento=elMovimiento.parentNode;

							for (var i=0; i<touches.length; i++) {
								 // Obtengo la posicion del cursor
								cursorComienzoX=touches[i].clientX+window.scrollX;
								cursorComienzoY=touches[i].clientY+window.scrollY;
								elComienzoX=parseInt(elMovimiento.style.left);
								elComienzoY=parseInt(elMovimiento.style.top);
								// Actualizo el posicion del elemento
								elMovimiento.style.zIndex=++posicion;
							}
						}
						, handleMove: function(evt) {
							evt.preventDefault();
							var touches = evt.changedTouches;
							for (var i=0; i<touches.length; i++) {
								var xActual, yActual;
								xActual=touches[i].clientX+window.scrollX;
								yActual=touches[i].clientY+window.scrollY;

								elMovimiento.style.left=(elComienzoX+xActual-cursorComienzoX)+"px";
								elMovimiento.style.top=(elComienzoY+yActual-cursorComienzoY)+"px";
							}
							MoverElementos.setFinalFun();
						}
					};

				</script>

				
				
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="modal-logic" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content p-0">
            <div class="modal-header">
                <h4 class="modal-title">Visualizar</h4>
            </div>
            <div class="tab-content"> 
                <div class="tab-pane active">
                	<?php $inPreguntas->getBoxPrevisualizar("txt_visualizar_vista"); ?>
                </div> 
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="closeBoxAddPreguntas(); reBox1();">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?=$inDatos["JS_BASE"]?>

<!-- CK Editor -->
<?='<script src="https://cdn.ckeditor.com/4.7.3/standard-all/ckeditor.js"></script>'?>

<!-- AdminLTE for demo purposes -->
<?='<script src="myCss/dist/js/demo.js" type="text/javascript"></script>'?>

<script>
	<?php
		$md_pregunta = "modal-preguntas";
	?>
	cfg_pre = {
		tp_tab_actual: 0, tp_pre_actual: -1, tp_val_pre: '', es_cierre: false, mod_edit_pre: 0, id_pre: ''
		, txt_new: ["Agregar", "agrego", "agregado", "agregada"], txt_edi:  ["Editar", "edito", "editado", "editada"]
		, txt_mov: ["Mover", "movio", "moviendo", "movida"]
	}
	
	function reBox1(){}
	
	$(document).ready(function(e) {
		// Especiales
		$("#txt_visualizar_vista").attr("contenteditable", "false");
		
        verCampanias();
		CKEDITOR.config.resize_enabled = false;
		CKEDITOR.config.removePlugins = 'Source';
		
		CKEDITOR.replace( 'txt_pregunta', {
			height: 250,
			// Adding Text and Background Color, Font Family and Size buttons to make sample
			// text styling more spectacular.
			extraPlugins: 'colorbutton,font',
			// By default, some basic text styles buttons are removed in the Standard preset.
			// The code below resets the default config.removeButtons setting.
			removeButtons: '',
			// Rearrange the toolbar slightly.
			toolbarGroups: [
				{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
				{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
				{ name: 'links' },
				{ name: 'insert' },
				{ name: 'forms' },
				{ name: 'tools' },
				{ name: 'document',	   groups: [ 'document', 'doctools' ] },
				'/',
				{ name: 'colors' },
				{ name: 'others' },
				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
				{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
				{ name: 'styles' },
				{ name: 'about' },
			]
		} );
		
		CKEDITOR.inline( 'txt_visualizar', {
			extraPlugins: 'colorbutton,font',
			removeButtons: '',
			toolbarGroups: [
				{ name: 'colors' },
				{ name: 'others' },
				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
				{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
				'/',
				{ name: 'styles' },
				{ name: 'about' },
			]
		});
		
		$('#lis_atributos').sortable({
			placeholder         : 'sort-highlight',
			handle              : '.handle',
			forcePlaceholderSize: true,
			zIndex              : 999999
		});
		$('#lis_respuestas').sortable({
			placeholder         : 'sort-highlight',
			handle              : '.handle',
			forcePlaceholderSize: true,
			zIndex              : 999999
		});
		
		MoverElementos.carga();
		setTimeout(function(){
			verSubCampania('Mi prueba Jorge', 'b2B_n1PSpKyVk8KGe6Con5w.');
			verCuestionario('BBVA', 'Z2RfeHW4cw..', 2, 'b2B_n1PSpKyVk8KGe6Con5w.')
			verLogica();
			//prueba();
			
			// newPregunta();
			// addTpPregunta(0);
			// verTab(3);
		}, 200);
		
    });
	
	var tmp = Array();
	function generarVista(id){
		switch( cfg_pre.tp_pre_actual ){
			case 1:
				var obj = "<?=$this->vwCuestionario->getCuerpo("pr", 1, NULL) ?>";
				$("#"+id).html(obj);
				break;
				
			case 2:
				var obj = "<?=$this->vwCuestionario->getCuerpo("pr", 2, NULL) ?>";
				$("#"+id).html(obj);
				
				var li = $("#"+id).find(".list-inline").find("li");
				$(li[0]).html( $("#pal_palanca01").val() );
				$(li[1]).html( $("#pal_palanca02").val() );
				
				var gb = $("#"+id).find(".btn-group");
				$( gb ).html("");
				if( $("#sub_pregunta").val() == "1" ){
					var ini = $("#pal_ini01").val();
					var fin = $("#pal_fin01").val();
					if( $.isNumeric( ini ) && $.isNumeric( fin ) && ini != fin ){
						var por = 100 / ( Math.abs(ini - fin) + 1 );
						if( ini < fin )
							for(i = ini; i <= fin; i++)
								$( gb ).append( getBoxpr1(i, i, por) );
						else
							for(i = ini; i >= fin; i--)
								$( gb ).append( getBoxpr1(i, i, por) );
					}
				}else{
					var txts = $("#lis_atributos").find("li").find(".text");
					var por = 100 / ( txts.length );
					for(i = 0; i < txts.length; i++)
						$( gb ).append( getBoxpr1(i, txts[i].innerText, por) );
				}
				break;
				
			case 3:
				var obj = "<?=$this->vwCuestionario->getCuerpo("pr", 3, NULL) ?>";
				$("#"+id).html(obj);
				var gb = $("#"+id).find(".row");
				$( gb ).html("");
				var txts = $("#lis_respuestas").find("li");
				for(i = 0; i < txts.length; i++){
					if( $("#sub_pregunta").val() == "3" ){
						type = "radio";
					}else{
						type = "checkbox";
					}
					
					var txt = "<div class='col-xs-6 col-xs-offset-3 btn-group-vertical'>";
					txt += "<label class='btn btn-default btn-opcion'>";
					txt += "	<input type='"+type+"' name='pr' id='pr_"+i+"' value='"+i+"' autocomplete='off' onchange='verOtro(this);'> "
									+ $( txts[i] ).find(".text").html();
					txt += "</label>";
					if( $(txts[i]).find(".es_otro").length > 0 ){
						txt += "<input type='text' name='pr_txt' class='form-control txt-otro' placeholder='¿Cúal?' style='display:none;'>";
					}
					txt += "</div>";
					$( gb ).append( txt );
				}
				break;
				
			case 4:
				var obj = "<?=$this->vwCuestionario->getCuerpo("pr", 4, NULL) ?>";
				$("#"+id).html(obj);
				
				var li = $("#"+id).find(".list-inline").find("li");
				$(li[0]).html( $("#pal_palanca01").val() );
				$(li[1]).html( $("#pal_palanca02").val() );
				
				var gb = $("#"+id).find("ul");
				$( gb ).html("");
				var txts = $("#lis_respuestas").find("li");
				for(j = 0; j < txts.length; j++){
					var txt = "<li class='item'><div><a href='javascript:void(0)' class='product-title'>";
					txt += $( txts[j] ).find(".text").html() + "</a>";
					txt += "<ul class='list-inline'><li>"+$("#pal_palanca01").val()+"</li>"
							+ "<li class='pull-right'>"+$("#pal_palanca02").val()+"</li></ul>";
					txt += "<div class='product-description btn-group' data-toggle='buttons' style='width:100%;'>";
						
					if( $("#sub_pregunta").val() == "1" ){
						var ini = $("#pal_ini01").val();
						var fin = $("#pal_fin01").val();
						if( $.isNumeric( ini ) && $.isNumeric( fin ) && ini != fin ){
							var por = 100 / ( Math.abs(ini - fin) + 1 );
							if( ini < fin )
								for(i = ini; i <= fin; i++)
									txt += getBoxpr1(i, i, por, "pr_" + j);
							else
								for(i = ini; i >= fin; i--)
									txt += getBoxpr1(i, i, por, "pr_" + j);
						}
					}else{
						var inTxts = $("#lis_atributos").find("li").find(".text");
						var por = 100 / ( inTxts.length );
						for(i = 0; i < inTxts.length; i++)
							txt += getBoxpr1(i, inTxts[i].innerText, por, "pr_" + j);
					}
					txt += "</div>";
					txt += "</div></li>";
					$( gb ).append( txt );
				}
				break;
		}
	}
	
	// Logica
	function verLogica(){
		$('#modal-logica-visualizar').modal('show');
		
		// -----
		var jqxhr = $.ajax(  {
			type: "POST",
			dataType: "json",
			url: "galy/html/include/vw_preguntas.php",
			data: { tipo: 1, subtipo: 6, val: cfg_pre.tp_val_pre, exVal:2 }
		}).done(function( data, textStatus, jqXHR ) {
			if( data.estatus == 3 ){
				// --- 
				var inDatos = Array();
				var inDatosLogic = Array();
				var sinLogic = false;
				
				// data.pregunta.length
				for(xj = 0; xj < data.pregunta.length; xj++){
					var pregunta = data.pregunta[xj];
					var txt = pregunta.nombre_ct;
					if( txt == ""){
						var texto = pregunta.pregunta.replace(/<[^>]*>?/g, '');
						txt = texto.substr(0, 10);
					}
					
					var logicObj = GalyLogic.getBsEl();
					logicObj.id = ( xj + 1 );
					logicObj.txt = txt;
					logicObj.cx = GalyLogic.getCX( pregunta.cx, xj );
					logicObj.cy = GalyLogic.getCY( pregunta.cy, xj );
					logicObj.cw = GalyLogic.getCW( pregunta.cw, xj );
					logicObj.pregunta = pregunta;
					
					if(!sinLogic){
						if(xj != 0)
							logicObj.lgcI.push( GalyLogic.getBsEllgc(" ", 1) );
						
						if(xj+1 < data.pregunta.length){
							logicObj.lgcD.push( GalyLogic.getBsEllgc(" ", 2) );
							
							inDatosLogic.push({
								idP: ( xj + 1 ), idH: 2,
								idLogs: [
									{ idP: ( xj + 2 ), idH: 1 }
								]
							});
						}
					}
					
					inDatos.push( logicObj );
				}
				
				GalyLogic.setIniDatos("bxLogic", inDatos, inDatosLogic);
				MoverElementos.setFinalFun = function(){ GalyLogic.getUpLineas(); GalyLogic.updatePos(); };
				setTimeout(function(){
					GalyLogic.getUpLineas();
				}, 300);
			}else{
				swal("", "Error al "+txts[0]+" la respuesta ("+data.text+").", "warning");
			}
		}).fail(function(jqXHR, textStatus, errorThrown) {
			swal("", "Error al "+txts[0]+" la respuesta ("+errorThrown+").", "warning");
		});
	}
	
	
	
	
	
	// ---- 
	var Galy = {
	  getElem: function(txt){
			return document.createElement( txt );
	  }
	  , getElemC: function(ele, cls){
		return this.getElemCT(ele, cls, "");
	  }
	  , getElemCT: function(ele, cls, txt){
		return this.getElemCA( ele, cls, txt, "class", "" );
	  }
	  , getElemCA: function(ele, cls, txt, att, clic){
		var obj = this.getElem( ele );
		if( att != "" && cls != "" )
			obj.setAttribute(att, cls);
		if( clic != "" && clic != null)
			obj.setAttribute("onclick", clic);
		obj.innerHTML = txt;
		return obj;
	  }
	  , getElemCH: function(cls, txt){
		var obj = this.getElem( "input" );
		obj.setAttribute("type", "hidden");
		obj.setAttribute("class", cls);
		obj.setAttribute("value", txt);
		return obj;
	  }
	  , getElemCO: function(ele, cls, inObj){
		var obj = this.getElem( ele );
		if(cls != "")
			obj.setAttribute("class", cls);
		  
		try{
			$(obj).append(inObj);
		} catch(err){ 
			alert(err) 
		}
		return obj;
	  }
	  , getElemTxt: function(txt, inner){
		var obj = this.getElem(txt);
		obj.innerHTML = inner;
		return obj;
	  }
	  , getElemTxO: function(txt, inner){
		var obj = this.getElem(txt);
		$(obj).append(inner);
		return obj;
	  }
	  , getElemLb: function(cls, txt){
		var obj = this.getElem("span");
		obj.setAttribute("class", "label label-" + cls)
		obj.innerHTML = txt;
		return obj;
	  }
	  , getElemLi: function(cls, txt){
		var obj = this.getElem("i");
		obj.setAttribute("class", "fa "+cls+" "+txt)
		return obj;
	  } 
	  , getElemIClock: function(txt){
		var obj = this.getElem("span");
		obj.setAttribute("class", "time")
		$(obj).append( this.getElemC("i", "fa fa-clock-o") );
		obj.innerHTML = txt;
		return obj;
	  }
	  , getElemB: function(cls, fa, onclick, txt){
		if( typeof( txt ) == "undefined" || txt == null )
			txt = "";
		var i = this.getElem("i");
		i.setAttribute("class", "fa fa-fw fa-" + fa);
		var obj = this.getElem("button");
		obj.setAttribute("type", "button");
		obj.setAttribute("onclick", onclick);
		obj.setAttribute("class", "btn btn-"+cls+" btn-xs");
		obj.innerHTML = " " + txt;
		obj.prepend(i);
		return obj;
	  }
	  , getElemA: function(txt, ref, onclick){
		var a = this.getElem("a");
		a.innerHTML = txt;
		a.setAttribute("href", ref);
		if( onclick != "" )
			a.setAttribute("onclick", onclick);
		return a;
	  }
	  , getElemBList: function(txt, elemnts){
		  var div = this.getElem("div");
		  div.setAttribute("class", "btn-group");
		  var btn = this.getElem("button");
		  btn.setAttribute("type", "button");
		  btn.setAttribute("class", "btn btn-default btn-xs dropdown-toggle");
		  btn.setAttribute("data-toggle", "dropdown");
		  btn.setAttribute("aria-expanded", "false");
		  btn.innerHTML = txt + " <span class='caret'></span>";
		  $(div).append( btn );
		  var ul = this.getElemC("ul", "dropdown-menu");
		  for( i = 0; i < elemnts.length; i++ ){
			  $(ul).append( this.getElemTxO("li", this.getElemCA("a", "#", elemnts[i].txt, "href", elemnts[i].clic) ) );
		  }
		  $(div).append( ul );
		  return div;
	  }
	  
	  , getElemLListD: function(elemnts){
		  var div = this.getElemC("div", "tools oculEditAtri");
		  for( i = 0; i < elemnts.length; i++ ){
			  $(div).append( this.getElemCA("i", "fa " + elemnts[i].txt, "", "class", elemnts[i].clic) );
		  }
		  return div;
	  }
	  , getElemLList: function(id, txt, txt_o, elemnts){
		  var li = this.getElem("li");
		  li.id = id;
		  var span = this.getElemC("span", "handle ui-sortable-handle oculEditAtri");
		  $(span).append( this.getElemC("i", "fa fa-fw fa-arrows") );
		  $(li).append( span );
		  $(li).append( this.getElemCT("span", "text", txt) );
		  $(li).append( this.getElemCT("span", "edit", "") );
		  if( txt_o )
			  $(li).append( this.getElemCT("small", "label label-primary es_otro", "Especifica") );
		  $(li).append( Galy.getElemLListD(elemnts) );
		  return li;
	  }
	  
	  , getElemMiniEdit: function(id, val, txt, clic01, clic02, clic03, fg){
		var div = this.getElemC("div", "input-group input-group-sm");
		div.id = id;
		var input = this.getElemC("input", "form-control");
		input.setAttribute("type", "text");
		input.setAttribute("value", txt);
		input.setAttribute("onkeydown", "return "+clic01+"("+val+", "+fg+", event);");
		$(div).append( input );
		var span = this.getElemC("span", "input-group-btn");
		var btn = this.getElemCT("button", "btn btn-danger btn-flat", "Cancelar");
		btn.setAttribute("type", "button");
		btn.setAttribute("onclick", clic02 + "("+fg+");");
		$(span).append( btn );
		var btn = this.getElemCT("button", "btn btn-info btn-flat", "Editar");
		btn.setAttribute("type", "button");
		btn.setAttribute("onclick", clic03 + "("+val+", "+fg+");");
		$(span).append( btn );
		$(div).append( span );
		return div;
		
	  }
	  , getElemSplitButtons: function(id, ic_btn, txt_btn, elemnts, color){
			var div = this.getElemC("div", "btn-group");
			if(id != null && id != "")
				div.id = id;
		  	var but = Galy.getElemB(color, ic_btn, "", txt_btn);
			but.setAttribute("data-toggle", "dropdown");
			$(div).append( but );
			var but = this.getElemC("button", "btn btn-"+color+" dropdown-toggle btn-xs");
			but.setAttribute("type", "button");
			but.setAttribute("data-toggle", "dropdown");
			but.setAttribute("aria-expanded", "false");
			$(but).append( this.getElemC("span", "caret") );
			$(but).append( this.getElemCT("span", "sr-only", "Toggle Dropdown") );
			$(div).append( but );
			var ul = this.getElemC("ul", "dropdown-menu");
			ul.setAttribute("role", "menu");
			for( i = 0; i < elemnts.length; i++ ){
				var inLi = this.getElem("li");
				if( elemnts[i].txt != "-" ){
					var inA = this.getElem("a");
					inA.setAttribute("href", "javascript:"+elemnts[i].onC+";");
					inA.innerHTML = elemnts[i].txt;
					$(inLi).append( inA );
				}else{
					inLi.setAttribute("class", "divider");
				}
				$(ul).append( inLi );
			}
			$(div).append( ul );

			return div;
		}
		, soloNumeros: function(e){
			var key = window.Event ? e.which : e.keyCode
			return (key >= 48 && key <= 57)
		}
	};
</script>
<?php
	include("include/js_campania.php");
	$inPreguntas->getJS();
	$this->vwCuestionario->getJS();
?>
