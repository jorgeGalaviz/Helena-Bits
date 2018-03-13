<?php
	include_once ("../../config.inc.php");
	include_once("../../DB_Connect.php");
	include_once("../../galy_fun.php");
	include_once("../../galy_ssl.php");
	
	class Campanias{
		private $db, $css, $segurity;
		private $title;
		
		public function __construct() {
			$this->db = new BaseDatos(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE, SYS_ENTORNO);
			$this->db->conectar();
			$this->segurity = new GY_SSL( $this->db );
		}
		
		public function __destruct(){
			//$this->db->desconectar();
		}
		
		public function getJson($tipo, $subtipo, $inDatos){
			$es_inicio = $this->segurity->getSesion();
			
			if( $es_inicio == 1 ){
				$miniDatos = $this->segurity->getDatos();
				
				switch($tipo){
					case 1: // Vista Preguntas
						switch($subtipo){
							case 0: // agregar
								$llave_pregunta = Funciones::getLlave(true);
								$id_ele = explode("-", $this->segurity->getVuetla($inDatos["exVal"]) );
								if( $inDatos["RS3_preg"] == "" && $inDatos["RS3_preg"] == NULL )
									$inDatos["RS3_preg"] = "0";
								if( $inDatos["RS4_preg"] == "" && $inDatos["RS4_preg"] == NULL )
									$inDatos["RS4_preg"] = "0";
								
								$query = "insert into cat_preguntas (id_usuario, id_sub, id_estatus, id_orden, tipo, subtipo, nombre_corto
													, pregunta, opcion, pagina, fec_Add, R1, R2, R3, R4, llave) values "
									. " (" . $miniDatos["id"] . ", ".$id_ele[0].", 1, '".$inDatos["n_orden"]."', '".$inDatos["tp_preg"]."'
										, '".$inDatos["sub_pre"]."', '".Funciones::limpiarTXT($inDatos["nombre_ct"])."'
										, '".Funciones::limpiarTXT($inDatos["pregunta"])."'
										, '".$inDatos["opcion"]."', '".$inDatos["pestana"]."', current_timestamp()
										, '".$inDatos["RS1_preg"]."', '".$inDatos["RS2_preg"]."', '".$inDatos["RS3_preg"]."', '".$inDatos["RS4_preg"]."'
										, $llave_pregunta);";
								$this->db->ejecutar($query);
								
								$id_pregunta = 0;
								$query = "select id_pregunta from cat_preguntas where llave = " .$llave_pregunta;
								$resultado = $this->db->ejecutar($query);
								while ($preguntas = $this->db->getFetchAssoc($resultado) ) {
									$id_pregunta = $preguntas["id_pregunta"];
								}
								$this->db->libera($resultado);
								
								// Preguntas
								if( $inDatos["valores"] != "" ){
									$sql_respuestas = "";
									$i = 0;
									foreach( $inDatos["valores"] as $respuesta ){
										if( $i == 0 )
											$sql_respuestas = "insert into cat_respuestas (id_pegunta, respuesta, opcion, es_otro, n_orden, fec_add) values ";
										if( $i > 0 )
											$sql_respuestas .= ", ";
											
										$sql_respuestas .= " ($id_pregunta, '".Funciones::limpiarTXT( $respuesta["txt"] )."', 1, "
												.Funciones::getConvertBN( $respuesta["es_otro"] ).", ".$respuesta["orden"].", current_timestamp())";
										$i++;
									}
									if( $sql_respuestas != "" )
										$this->db->ejecutar($sql_respuestas);
								}
								
								// atributos
								if( $inDatos["atributos"] != "" ){
									$sql_atributos = "";
									$i = 0;
									foreach( $inDatos["atributos"] as $atributo ){
										if( $i == 0 )
											$sql_atributos = "insert into cat_respuestas (id_pegunta, respuesta, opcion, es_otro, n_orden, fec_add) values";
										if( $i > 0 )
											$sql_atributos .= ",";
										$sql_atributos .= "($id_pregunta, '".Funciones::limpiarTXT( $atributo["txt"] )."', 2, 0, "
															. $atributo["orden"].", current_timestamp()) ";
										$i++;
									}
									if( $sql_atributos != "" )
										$this->db->ejecutar($sql_atributos);
								}
								echo " { \"estatus\": 3, \"text\": \"done\" }";
								break; // -- fin agregar
								
							case 1: // Ver
								$id_ele = explode("-", $this->segurity->getVuetla($inDatos["val"]) );
								$query = "select id_pregunta, id_orden, nombre_corto, pregunta, pagina, fec_Add, es.nombre as estatus 
											, es.lb_class as lb_class_es, tp.nombre as tp_nombre, tp.lb_class, tp.lb_icono, tp.tipo 
											, pre.id_estatus
										from cat_preguntas pre inner join es_cat_campanias es on es.id_estatus = pre.id_estatus 
										inner join tp_cat_preguntas tp on tp.tipo = pre.tipo 
										where pre.id_estatus in (1, 0) and id_sub = " . $id_ele[0]. " order by id_orden;";
								$index = 0;
								
								echo " { \"cam\": [ ";
								$resultado = $this->db->ejecutar($query);
								while ($preguntas = $this->db->getFetchAssoc($resultado) ) {
									$index++;
									if($index > 1) echo ",";
									$datos = array(
										'id' => $this->segurity->setVuetla( $preguntas["id_pregunta"] . "-" . $preguntas["tp_nombre"] ),
										'n_orden'	=> $preguntas["id_orden"],
										'label'		=> $preguntas["nombre_corto"],
										'pre_txt'	=> $preguntas["pregunta"],
										'pre_pag'	=> $preguntas["pagina"],
										'pre_fec'	=> $preguntas["fec_Add"],
										'es_txt'	=> $preguntas["estatus"],
										'es_lbc'	=> $preguntas["lb_class_es"],
										'tp_txt'	=> $preguntas["tp_nombre"],
										'tp_ico'	=> $preguntas["lb_icono"],
										'tp_lbc'	=> $preguntas["lb_class"],
										'tp_pre'	=> $preguntas["tipo"],
										'activa'	=> $preguntas["id_estatus"],
									);
									echo json_encode($datos);
								}
								$this->db->libera($resultado);
								echo "] }";
								break; // -- fin ver
								
							case 2: // Borrar
								$id_ele = explode("-", $this->segurity->getVuetla($inDatos["val"]) );
								$query = "update cat_preguntas set id_estatus = 2 where id_pregunta = " . $id_ele[0];
								$this->db->ejecutar($query);
								echo " { \"estatus\": 3, \"text\": \"done\" }";
								break; // -- fin borrar
								
							case 3: // Editar
								$id_ele = explode("-", $this->segurity->getVuetla($inDatos["val"]) );
								if( $inDatos["RS3_preg"] == "" && $inDatos["RS3_preg"] == NULL )
									$inDatos["RS3_preg"] = "0";
								if( $inDatos["RS4_preg"] == "" && $inDatos["RS4_preg"] == NULL )
									$inDatos["RS4_preg"] = "0";
									
								$id_pregunta = $id_ele[0];
								
								$query = "update cat_preguntas set fec_mod = current_timestamp()
										, id_usuario = '".$miniDatos["id"]."'
										, tipo = '".$inDatos["tp_preg"]."'
										, subtipo = '".$inDatos["sub_pre"]."'
										, nombre_corto = '".Funciones::limpiarTXT($inDatos["nombre_ct"])."'
										, pregunta = '".Funciones::limpiarTXT($inDatos["pregunta"])."'
										, opcion = '".$inDatos["opcion"]."'
										, pagina = '".$inDatos["pestana"]."'
										, R1 = '".$inDatos["RS1_preg"]."'
										, R2 = '".$inDatos["RS2_preg"]."'
										, R3 = '".$inDatos["RS3_preg"]."'
										, R4 = '".$inDatos["RS4_preg"]."'"
										. "  where id_pregunta = ". $id_pregunta;
								$this->db->ejecutar($query);
								
								$query = "update cat_respuestas set opcion = 3 where opcion = 1 and id_pegunta = ".$id_pregunta.";";
								$this->db->ejecutar($query);
								$query = "update cat_respuestas set opcion = 4 where opcion = 2 and id_pegunta = ".$id_pregunta.";";
								$this->db->ejecutar($query);
								
								
								// Preguntas
								if( $inDatos["valores"] != "" ){
									$sql_respuestas = "";
									$i = 0;
									foreach( $inDatos["valores"] as $respuesta ){
										if( $respuesta["id"] != "" ){
											$id_val = explode("-", $this->segurity->getVuetla($respuesta["id"]) );
											$query = "update cat_respuestas set fec_mod = current_timestamp()"
												. ", respuesta = '".Funciones::limpiarTXT( $respuesta["txt"] )."'"
												. ", opcion = 1, n_orden = " . $respuesta["orden"]
												. ", es_otro = " . Funciones::getConvertBN( $respuesta["es_otro"] )
												. " where id_prespuesta = " . $id_val[0];
											$this->db->ejecutar($query);
										}else{
											if( $i == 0 )
												$sql_respuestas = "insert into cat_respuestas (id_pegunta, respuesta, opcion, es_otro, n_orden, fec_add) values ";
											if( $i > 0 )
												$sql_respuestas .= ", ";
												
											$sql_respuestas .= " ($id_pregunta, '".Funciones::limpiarTXT( $respuesta["txt"] )."', 1, "
													.Funciones::getConvertBN( $respuesta["es_otro"] ).", ".$respuesta["orden"].", current_timestamp())";
											$i++;
										}
									}
									if( $sql_respuestas != "" )
										$this->db->ejecutar($sql_respuestas);
								}
								
								// atributos
								if( $inDatos["atributos"] != "" ){
									$sql_atributos = "";
									$i = 0;
									foreach( $inDatos["atributos"] as $atributo ){
										if( $atributo["id"] != "" ){
											$id_val = explode("-", $this->segurity->getVuetla($atributo["id"]) );
											$query = "update cat_respuestas set fec_mod = current_timestamp()"
												. ", respuesta = '".Funciones::limpiarTXT( $atributo["txt"] )."'"
												. ", opcion = 2, n_orden = " . $atributo["orden"]
												. ", es_otro = 0"
												. " where id_prespuesta = " . $id_val[0];
											$this->db->ejecutar($query);
										}else{
											if( $i == 0 )
												$sql_atributos = "insert into cat_respuestas (id_pegunta, respuesta, opcion, es_otro, n_orden, fec_add) values";
											if( $i > 0 )
												$sql_atributos .= ",";
											$sql_atributos .= "($id_pregunta, '".Funciones::limpiarTXT( $atributo["txt"] )."', 2, 0, "
																. $atributo["orden"].", current_timestamp()) ";
											$i++;
										}
									}
									if( $sql_atributos != "" )
										$this->db->ejecutar($sql_atributos);
								}
								echo " { \"estatus\": 3, \"text\": \"done\" }";
								break; // -- fin Editar
							
							case 4: // Mover de posicion
								$id_ele01 = explode("-", $this->segurity->getVuetla($inDatos["val"]) );
								$query = "update cat_preguntas set id_orden = " . $inDatos["tp_preg"]
										. "  where id_pregunta = ". $id_ele01[0];
								$this->db->ejecutar($query);
								
								$id_ele02 = explode("-", $this->segurity->getVuetla($inDatos["exVal"]) );
								$query = "update cat_preguntas set id_orden = " . $inDatos["sub_pre"]
										. "  where id_pregunta = ". $id_ele02[0];
								$this->db->ejecutar($query);
							
								$id_sub = 0;
								$query = "select id_sub from cat_preguntas where id_pregunta = ". $id_ele02[0];
								$resultado_1 = $this->db->ejecutar($query);
								while ($preguntas_1 = $this->db->getFetchAssoc($resultado_1) ) {
									$id_sub = $preguntas_1["id_sub"];
								}
								$this->db->libera($resultado_1);
								
								$query = Funciones::getSQLReorden("cat_preguntas", "id_pregunta", "id_orden", " id_estatus in (1) and id_sub = " . $id_sub);
								$this->db->ejecutar( $query[0] );
								$this->db->ejecutar( $query[1] );
								$this->db->ejecutar( $query[2] );
								$this->db->ejecutar( $query[3] );
								echo " { \"estatus\": 3, \"text\": \"done\" }";
								break;// -- fin mover
							
							case 5: // Duplicar
								$id_ele = explode("-", $this->segurity->getVuetla($inDatos["val"]) );
								$query = " select id_orden, id_sub from cat_preguntas where id_pregunta = ".$id_ele[0]."; ";
								$resultado = $this->db->ejecutar($query);
								while ($preguntas = $this->db->getFetchAssoc($resultado) ) {
									$query = "update cat_preguntas set id_orden = id_orden + 1 where id_estatus in (1) and id_sub = ".$preguntas["id_sub"]
											." and id_orden > ".$preguntas["id_orden"].";";
									$this->db->ejecutar($query);
											
									$llave_pregunta = Funciones::getLlave(true);
									$query = "insert into cat_preguntas (id_usuario, id_sub, id_estatus, id_orden, tipo, subtipo, nombre_corto "
										. " , pregunta, opcion, pagina, fec_Add, R1, R2, R3, R4, llave ) "
										. " select '".$miniDatos["id"]."', id_sub, id_estatus, (".$preguntas["id_orden"]."+1) as id_orden, tipo, subtipo, nombre_corto"
										. " , pregunta, opcion, pagina, current_timestamp(), R1, R2, R3, R4, $llave_pregunta as llave"
										. " from cat_preguntas where id_pregunta = " . $id_ele[0];
									$this->db->ejecutar($query);
									
									// Nuevas Preguntas
									$id_pregunta = 0;
									$query = "select id_pregunta from cat_preguntas where llave = " .$llave_pregunta;
									$resultado_1 = $this->db->ejecutar($query);
									while ($preguntas_1 = $this->db->getFetchAssoc($resultado_1) ) {
										$id_pregunta = $preguntas_1["id_pregunta"];
									}
									$this->db->libera($resultado_1);
									
									// 
									$query = "insert into cat_respuestas (id_pegunta, respuesta, opcion, es_otro, fec_add) "
										. "select $id_pregunta as id_pegunta, respuesta, opcion, es_otro, current_timestamp() as fec_add "
										. " from cat_respuestas where id_pegunta = " . $id_ele[0];
									$this->db->ejecutar($query);
											
								}
								$this->db->libera($resultado);
								
								echo " { \"estatus\": 3, \"text\": \"done\" }";
								break; // -- fin duplicar
								
							case 6: // Ver Pregunta para editar
								$id_ele = explode("-", $this->segurity->getVuetla($inDatos["val"]) );
								
								$datos = array(
									"estatus" => "3"
									, "text" => "done"
									, "pregunta" => array()
								);
								
								$base_pregunta = array(
									"tp_preg" => ""
									,"pregunta" => ""
									,"sub_pre" => ""
									,"nombre_ct" => ""
									,"opcion" => ""
									,"pestana" => ""
									,"RS1_preg" => ""
									,"RS2_preg" => ""
									,"RS3_preg" => ""
									,"RS4_preg" => ""
									
									,"cx" => ""
									,"cy" => ""
									,"cw" => ""

									, "valores" => array()
									, "atributos" => array()
								);
								
								// ----- Elementos Pregunta
								$query = "select id_pregunta, tipo, subtipo, nombre_corto, opcion, pagina, R1, R2, R3, R4, pregunta"
									. " , cx, cy, cw "
									. " from cat_preguntas ";
								if($inDatos["exVal"] == "1"){
									$query .= " where id_pregunta = " . $id_ele[0];
								}else{
									$query .= " where id_sub = " . $id_ele[0] . " and id_estatus = 1 order by id_orden";
								}
								
								$resultado = $this->db->ejecutar($query);
								while ($preguntas = $this->db->getFetchAssoc($resultado) ) {
									$inPregunta = $base_pregunta;
									$inPregunta["tp_preg"]		= $preguntas["tipo"];
									$inPregunta["pregunta"]		= $preguntas["pregunta"];
									$inPregunta["sub_pre"]		= $preguntas["subtipo"];
									$inPregunta["nombre_ct"]	= $preguntas["nombre_corto"];
									$inPregunta["opcion"]		= $preguntas["opcion"];
									$inPregunta["pestana"]		= $preguntas["pagina"];
									
									$inPregunta["RS1_preg"] 	= $preguntas["R1"];
									$inPregunta["RS2_preg"]		= $preguntas["R2"];
									$inPregunta["RS3_preg"]		= $preguntas["R3"];
									$inPregunta["RS4_preg"]		= $preguntas["R4"];
									
									$inPregunta["cx"]		= $preguntas["cx"];
									$inPregunta["cy"]		= $preguntas["cy"];
									$inPregunta["cw"]		= $preguntas["cw"];
									
									// --- Preguntas
									$inQuery = "select id_prespuesta, respuesta, es_otro, valor from cat_respuestas where opcion = 1 and id_pegunta = " . $preguntas["id_pregunta"]
										. " order by n_orden";
									
									$inResultado = $this->db->ejecutar($inQuery);
									while ($inRespuesta = $this->db->getFetchAssoc($inResultado) ) {
										array_push( $inPregunta["valores"], array(
											'id' => $this->segurity->setVuetla( $inRespuesta["id_prespuesta"] . "-" . $inRespuesta["respuesta"] )
											, "txt"		=> $inRespuesta["respuesta"], "es_otro"	=> $inRespuesta["es_otro"], "val"	=> $inRespuesta["valor"]
										) );
										$this->db->ejecutar($inQuery);
									}
									$this->db->libera($inResultado);

									// --- atributos
									$inQuery = "select id_prespuesta, respuesta, es_otro, valor from cat_respuestas where opcion = 2 and id_pegunta = " . $preguntas["id_pregunta"]
										. " order by n_orden";
									$inResultado = $this->db->ejecutar($inQuery);
									while ($inRespuesta = $this->db->getFetchAssoc($inResultado) ) {
										array_push( $inPregunta["atributos"], array(
											'id' => $this->segurity->setVuetla( $inRespuesta["id_prespuesta"] . "-" . $inRespuesta["respuesta"] )
											, "txt"		=> $inRespuesta["respuesta"], "es_otro"	=> $inRespuesta["es_otro"], "val"	=> $inRespuesta["valor"]
										) );
										$this->db->ejecutar($inQuery);

									}
									$this->db->libera($inResultado);
									
									array_push($datos["pregunta"], $inPregunta);
									$this->db->ejecutar($query);
											
								}
								$this->db->libera($resultado);
								
								echo json_encode($datos);
								break;
								
							case 7: // Activar Preguntas
								$id_ele = explode("-", $this->segurity->getVuetla($inDatos["exVal"]) );
								$query = "update cat_preguntas set id_estatus = ".$inDatos["val"]." where id_pregunta = " . $id_ele[0];
								$this->db->ejecutar($query);
								echo " { \"estatus\": 3, \"text\": \"done\" }";
								break; // -- fin borrar
								break;
						}
						break;// -- Fin Vista Preguntas
						
					case 2:
						$id_sub = 0;
						$id_orden = 0;
						$pagina = 0;
						$id_ele = explode("-", $this->segurity->getVuetla($inDatos["exVal"]) );
						$query = "select id_sub, id_orden, pagina from cat_preguntas where id_pregunta = " . $id_ele[0];
						$resultado = $this->db->ejecutar($query);
						while ($preguntas = $this->db->getFetchAssoc($resultado) ) {
							$id_sub   = $preguntas["id_sub"]  ;
							$id_orden = $preguntas["id_orden"];
							$pagina = $preguntas["pagina"];
						}
						$this->db->libera($resultado);
						
						$query = "";
						$tp = $inDatos["val"];
						switch($subtipo){
							case "1":
								if($tp != "-1")
									$tp = " + " . $tp;
								$query = "update cat_preguntas set pagina = pagina + 1 "
									. " where id_sub = $id_sub  and id_estatus = 1"
									. " and id_orden >= $id_orden $tp";
								break;
							case "2":
								if( $tp == "-1"){
									$query = "update cat_preguntas set pagina = $pagina "
										. " where id_sub = $id_sub  and id_estatus = 1"
										. " and id_orden = $id_orden - 1";
								}else{
									$query = "update cat_preguntas set pagina = pagina - 1 "
										. " where id_sub = $id_sub  and id_estatus = 1"
										. " and id_orden = $id_orden ";
								}
								break;
							case "3":
								$query = "update cat_preguntas set pagina = pagina - 1 "
									. " where id_sub = $id_sub and id_estatus = 1"
									. " and pagina >= $pagina";
								break;
						}
						if($query != "")
							$this->db->ejecutar($query);
						
						echo " { \"estatus\": 3, \"text\": \"done\" }";
						break;// -- Fin Vista Pestañas
				}
			}
		}
		
	}
	
	// -----
	$tipo = 0;
	$subtipo = 0;
	if( isset($_POST["tipo"]) )
		$tipo = $_POST["tipo"];
	if( isset($_POST["subtipo"]) )
		$subtipo = $_POST["subtipo"];
		
	// - Datos
	$inDatos = array(
		  "val"			=> Funciones::getElem("val")		// id_pregunta
		, "exVal"		=> Funciones::getElem("exVal")		// id_sub
		, "tp_preg"		=> Funciones::getElem("tp_preg")	// tipo
		, "sub_pre"		=> Funciones::getElem("sub_pre")	// subtipo
		, "opcion"		=> Funciones::getElem("opcion")		// opcion
		, "pestana"		=> Funciones::getElem("pestana")	// pagina
		, "n_orden"		=> Funciones::getElem("n_orden")	// id_orden
		
		, "nombre_ct"	=> Funciones::getElem("codigo")		// nombre_corto
		, "pregunta"	=> Funciones::getElem("pregunta")	// pregunta
		, "RS1_preg"	=> Funciones::getElem("RS1_preg")
		, "RS2_preg"	=> Funciones::getElem("RS2_preg")
		, "RS3_preg"	=> Funciones::getElem("RS3_preg")
		, "RS4_preg"	=> Funciones::getElem("RS4_preg")
		
		, "atributos"	=> Funciones::getElem("atributos")
		, "valores"	=> Funciones::getElem("valores")
		
		
	);
	
	$Camp = new Campanias();
	$Camp->getJson($tipo, $subtipo, $inDatos);
	
	
?>