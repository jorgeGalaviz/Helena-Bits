<?php
	include_once ("config.inc.php");
	include_once("DB_Connect.php");
	include_once("galy_css.php");
	include_once("galy_ssl.php");
	//include_once("generadorCuestionario.php");
	
	class Galy{
		private $db, $css, $segurity;
		private $title;
		
		public function __construct() {
			$this->db = new BaseDatos(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE, SYS_ENTORNO);
			$this->db->conectar();
			$this->css = new GY_CSS( $this->db );
			$this->segurity = new GY_SSL( $this->db );
		}
		
		public function __destruct(){
			$this->db->desconectar();
		}
		
		public function getCuerpo(){
			$pag = 0;
			$es_inicio = $this->segurity->getSesion();
			
			if( $es_inicio == 1 ){
				$this->css->setDatos( $this->segurity->getDatos() );
				$pag = 1;
				if( isset($_GET["pag"]) ){
					if( $_GET["pag"] == "2" ){
						$this->segurity->setCloseSesion();
						$pag = 0;
					}else{
						$pag = $_GET["pag"];
					}
				}
			}
			
			$this->css->setPagina($pag);
			$this->css->getHTML( $this->title, $es_inicio );
		}
		
	}
	
	/*
	$tp = "1";

	$db = new BaseDatos(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE, SYS_ENTORNO);
	$db->conectar();
	
	$sql = "select * from cat_preguntas where id_campania = $tp";
	$sql .= " order by id_orden;";
	
	$resultado = $db->ejecutar($sql);
	echo "<ul>\n";
	while ($actor = $db->getFetchAssoc($resultado) ) {
		echo "<li>";
		print_r( $actor );
		echo "<br><br></li>\n";
	}
	echo "</ul>\n";
	$db->libera($resultado);
	*/
?>