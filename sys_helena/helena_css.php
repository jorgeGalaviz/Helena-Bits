<?php
// Generar Cuestionario
include("assets/cuestionarios/helena_vw_cuestionario.php");

class HB_CSS{
	// Elementos Basicos
	private static $html_base = "../sys_html/base/";
	private static $html_head = "../sys_html/base/head.html";
	private static $html_js_b = "../sys_html/base/js_base.html";
	
	// Base Template
	private static $pagInterna;
	// ----- private static $base_head = "helena/html/base_template/menu_header.php";
	// ----- private static $base_left = "helena/html/base_template/menu_left.php";
	// ----- private static $base_foot = "helena/html/base_template/menu_footer.php";
	
	// Paginas Internas
	private static $html_encs = "assets/cuestionarios/html/encuestas.php";
	// -- private static $html_logn = "helena/html/base/login.html";
	// -- private static $html_dass = "helena/html/dash.php";
	
	
	// Menu
	/* private static $item_menu = array(
		array( "1", "Dashboard" ),
		array( "3", "Agendas" ),
		array( "4", "Usuarios" ),
		array( "2", "Cerrar sesión" ),
	); */
	
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
	
    public function __construct( $inDB, $inMenu ) {
		$this->db = $inDB;
		$this->vwCuestionario = new GalyVistaCuestionario();
		
		// Menu Interno
		self::$pagInterna = $inMenu;
    }

    public function __destruct(){
    }
	
	public function getHTML($tittle, $msg_error){
		$this->valores[0] = $this->getTitle($tittle);
		$this->valores[1] = file_get_contents(self::$html_js_b);
		
		// ---- HTML
		echo "<!DOCTYPE html>\n<html lang=\"es\" xml:lang=\"es\">\n";
		
		// Head
		$HTML = file_get_contents(self::$html_head);
		echo str_replace(self::$variables, $this->valores, $HTML);
		
		// Body
		echo "\n<body class=\"fixed-sn mdb-skin-custom\" data-spy=\"scroll\" data-target=\"#scrollspy\" data-offset=\"15\">\n";
		
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
		$title = "Royal";
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
			// -- echo "<div class='wrapper'>";
			// -- include(self::$base_head);
			// <!-- Left side column. contains the logo and sidebar -->
			// --- include( self::$base_left );
			// Pagina
			include( $HTML );
			// -- include(self::$base_foot);
			// -- echo "</div><!-- ./wrapper -->";
		}else{
			$HTML = file_get_contents( $HTML );
			echo str_replace(self::$variables, $this->valores, $HTML);
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
					$msg2 = "";
					break;
				case "502":
					$msg = "Por Favor eliminar sus Cookies y volver a ingresar";
					$msg2 = "ERROR DE SESION";
					$msg2 = "";
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
	
	// Funcion para las paguinas
	private function irElmPagina(){
		try {
			if( self::$pagInterna["p_" . $this->pagina ][0] == 2 ){
				return self::$html_encs;
			}else{
				return self::$pagInterna["p_" . $this->pagina ][2];
			}
		} catch (Exception $e) {
			if(SYS_ENTORNO){
				echo 'Erro en: ',  $e->getMessage(), "\n";
			}
			return "";
		}
		/* switch( ){
			case 0:
				return self::$html_logn;
			case 1:
				return self::$html_dass;
			case 3:
				return self::$html_encs;
		} */
	}
	
	// Menu de Navegacion
	private function irElmNav(){
		?>
		<nav class="navbar fixed-top navbar-expand-md navbar-dark doublee-nav scrolling-navbar ">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01"
			aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
				<a class="navbar-brand" href="#">
					<img class="image-responsive" src="https://rpprod.azureedge.net/media/1823/logoroyalprestige.png" alt="Royal Prestige" style="height: 23px;">
				</a>
				<ul class="navbar-nav mr-auto mt-lg-0">
					<?php
						// for($i = 0; $i < sizeof(self::$pagInterna); $i++ ){
						foreach( self::$pagInterna as $llave => $item ){
							if( $item[0] == 1 ){
								$activo = "";
								$pag = str_replace( "p_", "", $llave );
								if( $pag == $this->pagina  ){
									$activo = "active";
								}
								echo "<li class='nav-item $activo'>";
								echo "   <a class='nav-link' href='?pag=" . $pag . "'>"
										. $item[1] . "</a>";
								echo "</li>";
							}
						}
					?>
				</ul>
			</div>

			<!--Navigation icons-->
			<ul class="nav navbar-nav nav-flex-icons ml-auto">
				<!-- Login / register -->
				<li class="nav-item ">
					<a href="?pag=2" id="navbar-static-login" class="nav-link">
						<i class="fa fa-sign-in mr-1"></i>
						<span class="clearfix d-none d-sm-inline-block">Cerrar sesión</span>
					</a>
				</li>
			</ul>
		</nav>
		<?php
	}
	
	// Pie de Pagina 
	private function irElemFoot(){
		?>
		<!--Footer-->
		<footer id="footer" class="page-footer pt-4 mt-4">
			<!--Copyright-->
			<div class="footer-copyright wow fadeIn py-3 text-center" data-wow-delay="0.2s">
				<div class="container-fluid">
					&copy;
					2018 Copyright: <a href="https://www.royalprestige.com/MX-Espanol"> RoyalPrestige </a>
				</div>
			</div>
			<!--/.Copyright-->
		</footer>
		<!--/.Footer-->
		<?php
	}
	
}
?>