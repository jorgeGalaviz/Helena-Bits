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
					case 1: // Campañas
						switch($subtipo){
							case 0: // agregar
								$query = "insert into cat_campanias (id_usuario, id_estatus, name_nombre, fec_alta) values "
									. " (" . $miniDatos["id"] . ", 0, '".$inDatos["nombre"]."', current_timestamp());";
								$this->db->ejecutar($query);
								echo " { \"estatus\": 3, \"text\": \"done\" }";
								break; // -- fin agregar
								
							case 2: // Borrar
								$id_ele = explode("-", $this->segurity->getVuetla($inDatos["nombre"]) );
								$query = "update cat_campanias set id_estatus = 2 where id_campania = "
											. $id_ele[0];
								$this->db->ejecutar($query);
								echo " { \"estatus\": 3, \"text\": \"done\" }";
								break; // -- fin borrar
								
							case 3: // Editar
								$id_ele = explode("-", $this->segurity->getVuetla($inDatos["exNombre"]) );
								$query = "update cat_campanias set name_nombre = '".Funciones::limpiarTXT($inDatos["nombre"])."'"
										. "  where id_campania = ". $id_ele[0];
								$this->db->ejecutar($query);
								echo " { \"estatus\": 3, \"text\": \"done\" }";
								break; // -- fin Editar
								
							case 1: // Ver
								$query = "select cam.id_campania, cam.name_nombre, cam.fec_alta, es.nombre, es.lb_class
											, count(distinct sub.id_sub) total
										from cat_campanias cam
										inner join es_cat_campanias es on es.id_estatus = cam.id_estatus
										left join cat_subcampanias sub on sub.id_campania = cam.id_campania
										where cam.id_estatus in (0, 1) and id_usuario = " . $miniDatos["id"] . "
										group by cam.id_campania, cam.name_nombre, cam.fec_alta, es.nombre, es.lb_class;";
								$index = 0;
								
								echo " { \"cam\": [ ";
								$resultado = $this->db->ejecutar($query);
								while ($campania = $this->db->getFetchAssoc($resultado) ) {
									$index++;
									if($index > 1) echo ",";
									?>
                                    {
                                    	 "id": "<?=$this->segurity->setVuetla( $campania["id_campania"] . "-" . $campania["name_nombre"] )?>"
                                        ,"nombre": "<?=$campania["name_nombre"]?>"
                                        ,"estatus": "<?=$campania["nombre"]?>"
                                        ,"lb_clas": "<?=$campania["lb_class"]?>"
                                        ,"total": "<?=$campania["total"]?>"
                                    }
									<?php
								}
								$this->db->libera($resultado);
								echo "] }";
								break; // -- fin ver
						}
						break;// -- Fin Campanañas
						
					case "2":// -- Fin Campanañas
						switch($subtipo){
							case 0: // agregar
								$id_ele = explode("-", $this->segurity->getVuetla($inDatos["exVal"]) );
								$query = "insert into cat_subcampanias (id_campania, id_estatus, nombre, fec_alta) values "
									. " (" . $id_ele[0] . ", 1, '".$inDatos["nombre"]."', current_timestamp());";
								$this->db->ejecutar($query);
								echo " { \"estatus\": 3, \"text\": \"done\" }";
								break; // -- fin agregar
								
							case 2: // Borrar
								$id_ele = explode("-", $this->segurity->getVuetla($inDatos["nombre"]) );
								$query = "update cat_subcampanias set id_estatus = 2 where id_sub = " . $id_ele[0];
								$this->db->ejecutar($query);
								echo " { \"estatus\": 3, \"text\": \"done\" }";
								break; // -- fin borrar
								
							case 3: // Editar
								$id_ele = explode("-", $this->segurity->getVuetla($inDatos["exNombre"]) );
								$query = "update cat_subcampanias set nombre = '".Funciones::limpiarTXT($inDatos["nombre"])."'"
										. "  where id_sub = ". $id_ele[0];
								
								$this->db->ejecutar($query);
								echo " { \"estatus\": 3, \"text\": \"done\" }";
								break; // -- fin Editar
								
							case 1: // Ver
								$id_ele = explode("-", $this->segurity->getVuetla($inDatos["exNombre"]) );
								$query = "select sub.id_sub, sub.nombre as name_nombre, sub.fec_alta, es.nombre, es.lb_class 
											, count(distinct pre.id_pregunta) total 
										from cat_subcampanias sub 
										inner join es_cat_campanias es on es.id_estatus = sub.id_estatus 
										left join cat_preguntas pre on pre.id_sub = sub.id_sub 
										where sub.id_estatus in (0, 1) and id_campania = " . $id_ele[0] . " 
										group by sub.id_sub, sub.nombre, sub.fec_alta, es.nombre, es.lb_class;";
								$index = 0;
								
								echo " { \"cam\": [ ";
								$resultado = $this->db->ejecutar($query);
								while ($campania = $this->db->getFetchAssoc($resultado) ) {
									$index++;
									if($index > 1) echo ",";
									?>
                                    {
                                    	 "id": "<?=$this->segurity->setVuetla( $campania["id_sub"] . "-" . $campania["name_nombre"] )?>"
                                        ,"nombre": "<?=$campania["name_nombre"]?>"
                                        ,"estatus": "<?=$campania["nombre"]?>"
                                        ,"lb_clas": "<?=$campania["lb_class"]?>"
                                        ,"total": "<?=$campania["total"]?>"
                                    }
									<?php
								}
								$this->db->libera($resultado);
								echo "] }";
								break; // -- fin ver
						}
						break;
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
		  "nombre"		=> Funciones::getElem("nombre")
		, "exNombre"	=> Funciones::getElem("exNombre")
		, "exVal"		=> Funciones::getElem("exVal")
		
	);
	
	$Camp = new Campanias();
	$Camp->getJson($tipo, $subtipo, $inDatos);
	
	
?>