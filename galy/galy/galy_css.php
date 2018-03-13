<?php
include("galy_vw_cuestionario.php");

class GY_CSS{
	// Elementos Basicos
	private static $html_base = "galy/html/base/";
	private static $html_head = "galy/html/base/head.html";
	private static $html_js_b = "galy/html/base/js_base.html";
	
	// Base Template
	private static $base_head = "galy/html/base_template/menu_header.php";
	private static $base_left = "galy/html/base_template/menu_left.php";
	private static $base_foot = "galy/html/base_template/menu_footer.php";
	
	// Paginas Internas
	private static $html_logn = "galy/html/base/login.html";
	private static $html_dass = "galy/html/dash.php";
	private static $html_encs = "galy/html/encuestas.php";
	
	// Control de la vista de las paginas
	private $pagina = 0;
	private $db;
	private static $variables = array(
		"{TITLE}", "{JS_BASE}", "{NOMBRE}"
	);
	private $valores = array(
		"", "", ""
	);
	
	private $miniDatos;
	private $vwCuestionario;
	
    public function __construct( $inDB ) {
		$this->db = $inDB;
		$this->vwCuestionario = new GalyVistaCuestionario();
    }

    public function __destruct(){
    }
	
	public function getHTML($tittle, $msg_error){
		$this->valores[0] = $this->getTitle($tittle);
		$this->valores[1] = file_get_contents(self::$html_js_b);
		
		// ---- HTML
		echo "<!DOCTYPE html>\n<html lang=\"es\" xml:lang=\"es\" class=\"full-height\">\n";
		
		// Head
		$HTML = file_get_contents(self::$html_head);
		echo str_replace(self::$variables, $this->valores, $HTML);
		
		// Body
		echo "\n<body class=\"login-page\">\n";
		// Script
		$this->getBody();
		
		// Script Errores
		$this->getMsgError($msg_error);
		
		//Pagina Actual
		echo "\n</body>";
		
		// --- FIN HTML
		echo "\n</html>";
	}
	
	// DB
	public function getEjecutarQ($query){
		return $this->db->ejecutar($query);
	}
	
	public function getFetchQ($query){
		return $this->db->getFetchAssoc($query);
	}
	
	public function getLiberar($resultado){
		$this->db->libera($resultado);
	}
	
	// Datos
	public function setDatos($inDatos){
		$this->miniDatos = $inDatos;
	}
	
	private function getTitle($inTitle){
		$title = "Galy";
		if($inTitle != "" && $inTitle != NULL){
			$title .= " - " . $inTitle;
		}
		return $title;
	}
	
	private function getBody(){
		$HTML = $this->irElmPagina();
		if( substr($HTML, -3) == "php" ){
			//Mini DAtos
			$inDatos = $this->miniDatos;
			$inDatos["JS_BASE"] = $this->valores[1];
			
			$img_perfil = "https://image.freepik.com/iconos-gratis/perfil-macho-sombra-de-usuario_318-40244.jpg";
			
			// Elementos del Logeo
			echo "<div class='wrapper'>";
			include(self::$base_head);
			// <!-- Left side column. contains the logo and sidebar -->
			include(self::$base_left );
			// Pagina
			include( $HTML );
			include(self::$base_foot);
			echo "</div><!-- ./wrapper -->";
		}else{
			$HTML = file_get_contents( $HTML );
			echo str_replace(self::$variables, $this->valores, $HTML);
		}
	}
	
	private function irElmPagina(){
		switch($this->pagina){
			case 0:
				return self::$html_logn;
			case 1:
				return self::$html_dass;
			case 3:
				return self::$html_encs;
		}
	}
	
	private function getMsgError($tipo_err){
		if( $tipo_err >= 501 ){
			$msg = "Si el error persiste reportar al Administrador";
			$msg2 = "Error desconocido";
			
			switch($tipo_err){
				case "501":
					$msg = "El usuario o contraseña son incorrectos";
					$msg2 = "ERROR EN INICIO DE SESION";
					break;
				case "502":
					$msg = "Por Favor eliminar sus Cookies y volver a ingresar";
					$msg2 = "ERROR DE SESION";
					break;
			}
			?>
			<script>
                toastr.options = {
                  "closeButton": true,
                  "debug": false,
                  "progressBar": false,
                  "preventDuplicates": false,
                  "positionClass": "toast-top-right",
                  "onclick": null,
                  "showDuration": "400",
                  "hideDuration": "1000",
                  "timeOut": "7000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
                toastr.error("<?=$msg?>", "<?=$msg2?>")
            </script>
            <?php
		}
	}
	
	// Seleccionar pagina numerica HTML
	public function setPagina($pagina){
		$this->pagina = $pagina;
	}
	
	public function htmlTab($id, $txt, $onClick, $css, $expan, $disabled){
		if( $expan ){
			$aria_ex = "true";
			$css = "active " . $css ;
		}else{
			$aria_ex = "true";
		}
		
		$ext_css = "";
		if( !$disabled ){
			$ext_css .= "display: none;";
		}
		
		if( $onClick != "" ){
			$onClick = "onclick='$onClick'";
		}
		
		return "<li id='tab-$id' class='$css' style='$ext_css'>"
			. "<a href='#$id' data-toggle='tab' aria-expanded='$expan' $onClick>"
			//. "<span class='visible-xs'><i class='fa fa-home'></i></span> "
			//. "<span class='hidden-xs'>$txt</span>"
			. "<span>$txt</span>"
			. "</a></li>";
	}
	
}
?>