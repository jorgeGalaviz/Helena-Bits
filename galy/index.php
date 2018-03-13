<?php
	include("../sys_helena/helena.php");
	
	// Menu - Cambiar a BD?
	$menu = array(
		"p_0" => array( 0, "Login"			, "html/login.html" ),
		"p_1" => array( 1, "Dashboard"		, "html/dash.php"),
		"p_3" => array( 2, "Cuestionario"	, ""),
		"p_2" => array( 1, "Cerrar Sesión"	, ""),
	);
	$raiz = "helenabits/galy";
	$inConexion = array(
		"DB_USER" => "root",
		"DB_PASSWORD" => "",
		"DB_DATABASE" => "ely",
	);

	$Helena = new Helena( $raiz, $menu, $inConexion );
	$Helena->getCuerpo();
	
	
?>