<?php
	include("../sys_helena/helena.php");

	// Menu - Cambiar a BD?
	$menu = array(
		"p_0" => array( 0, "Login"			, "html/login.html" ),
		"p_1" => array( 1, "Dashboard"		, "html/dash.php"),
		"p_3" => array( 1, "Agendas"		, "html/agendas.php"),
		"p_4" => array( 1, "Usuarios"		, "html/usuarios.php"),
		"p_2" => array( 1, "Cerrar Sesión"	, ""),
	);
	$raiz = "helenabits/royal";
	$inConexion = array(
		"DB_USER" => "root",
		"DB_PASSWORD" => "",
		"DB_DATABASE" => "royal_prestige",
	);

	$Helena = new Helena( $raiz, $menu, $inConexion );
	$Helena->getCuerpo();
	
?>