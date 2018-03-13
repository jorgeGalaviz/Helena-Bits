<?php
	include_once ("config.inc.php");
	include_once("DB_Connect.php");
	include_once("helena_css.php");
	include_once("helena_ssl.php");
	
	class Helena{
		private $db, $css, $segurity;
		private $title;
		private $raiz;
		
		public function __construct( $inRaiz, $inMenu, $inConexion ) {
			$this->db = new BaseDatos(DB_HOST, $inConexion["DB_USER"], $inConexion["DB_PASSWORD"], $inConexion["DB_DATABASE"], SYS_ENTORNO);
			$this->db->conectar();
			$this->css = new HB_CSS( $this->db, $inMenu );
			$this->segurity = new HB_SSL( $this->db );
			$this->raiz = $inRaiz;
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
						$this->segurity->setCloseSesion( $this->raiz );
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
	
?>