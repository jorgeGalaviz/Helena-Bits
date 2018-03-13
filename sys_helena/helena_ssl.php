<?php
class HB_SSL{
	private $es_activo;
	private $db;
	private $miniLlave;
	private $idUS;
	private static $miniDatos = array(
		"nombre" => "nombre",
		"id_user" => "env0",
		"pass" => "env1",
	);
	
	private static $miniCampos = array(
		"base" => "ap_usuarios",	//ap_usuarios
		"id" => "id_usuario"		// id_usuario
	);
	
    public function __construct($inDB) {
		session_start();
		$this->es_activo = 0;
		$this->db = $inDB;
		$this->miniLlave = sha1(md5("MEGUSTAELPAY"));
    }

    public function __destruct(){
		session_destroy();
    }
	
	public function getSesion(){
		$es_form = false;
		$user = "";
		$pass = "";
		if( isset($_POST["sesion"]) ){
			if( $_POST["sesion"] == "1" ){
				$es_form = true;
			}
		}
		
		if( $es_form ){
			$query = "select " . self::$miniCampos["id"] . ", pass_cod, nombre from " . self::$miniCampos["base"]
				. " where usuario = '".$_POST["usuario"]."' and pass_cod = '".sha1(md5($_POST["pass"]))."'";
			$id_user = $this->getIdUser( $query );
			if( $id_user != 0 ){
				$query = "update " . self::$miniCampos["base"] . " set accesos = accesos + 1 where " . self::$miniCampos["id"] . " = " . $id_user;
				$this->db->ejecutar($query);
				// Generar Registro
				$this->setIngresos($id_user, "ACCESO");
			}else{
				$this->es_activo = 501;
			}
			
		}else{
			$id_user = $this->getIdUserCook();
		}
		$this->idUS = $id_user;
		
		return $this->es_activo;
	}
	
	public function setCloseSesion( $inRaiz ){
		$id_user = $this->getIdUserCook();
		// Generar Registro
		$this->setIngresos($id_user, "SALIDA");
		
		$fec_manana = time() - (1);
		setcookie(self::$miniDatos["nombre"], "", $fec_manana);
		setcookie(self::$miniDatos["id_user"], "", $fec_manana);
		setcookie(self::$miniDatos["pass"], "", $fec_manana);
		$this->es_activo = 0;
		
		header('Location: /' . $inRaiz . '/');
	}
	
	public function getDatos(){
		$datosDinamicos = array(
			"id" => "",
			"nombre" => "",
			"fecAlta" => ""
		);
		$id_user = $this->idUS;
		$datosDinamicos["id"] = $id_user;
		
		if( $id_user != 0 ){
			$query = "select DATE_FORMAT(fecha_alta, '%b %Y') as fecha_alta, nombre
				from " . self::$miniCampos["base"] . " where " . self::$miniCampos["id"] . " = $id_user";
			$resultado = $this->db->ejecutar($query);
			if ($usuario = $this->db->getFetchAssoc($resultado) ) {
				$datosDinamicos["nombre"] = $usuario["nombre"];
				$datosDinamicos["fecAlta"] = $usuario["fecha_alta"];
			}
			$this->db->libera($resultado);
		}
		return $datosDinamicos;
	}
	
	// ------------------------------ Funciones Internas
	
	// Ir por el id_usuario a partir de las cookies
	private function getIdUserCook(){
		$id_user = 0;
		if( isset($_COOKIE[self::$miniDatos["id_user"]]) && isset($_COOKIE[self::$miniDatos["pass"]]) ){
			if( $_COOKIE[self::$miniDatos["id_user"]] != "" && $_COOKIE[self::$miniDatos["pass"]] != ""  ){
				$query = "select " . self::$miniCampos["id"] . ", pass_cod, nombre from " . self::$miniCampos["base"]
					. " where " . self::$miniCampos["id"] . " = '".$this->decrypt($_COOKIE[self::$miniDatos["id_user"]], $this->miniLlave)."' "
					. "     and pass_cod = '".$this->decrypt($_COOKIE[self::$miniDatos["pass"]], $this->miniLlave)."'";
				$id_user = $this->getIdUser( $query );
			}
		}
		
		return $id_user;
	}
	
	// Ir por el id_usuario a partir de una consulta
	private function getIdUser($query){
		$id_user = 0;
		$resultado = $this->db->ejecutar($query);
		if ($usuario = $this->db->getFetchAssoc($resultado) ) {
			$id_user = $usuario[self::$miniCampos["id"]];
			$this->setCooSesionn($usuario["nombre"], $id_user, $usuario["pass_cod"]);
			$this->es_activo = 1;
		}
		$this->db->libera($resultado);
		
		return $id_user;
	}
	
	// Registrar la actividad
	private function setIngresos($id_user, $txt){
		$info = $this->getIpCliente();
		$query = "insert into cat_ingresos (ip, id_usuario, fecha, accion) values ";
		$query .= " ('".$info[0]."', '".$id_user."', current_timestamp(), '$txt')";
		$this->db->ejecutar($query);
	}
	
	private function getIpCliente(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$dis = $_SERVER['HTTP_USER_AGENT'];
		
		return array( $ip, $dis);
	}
	
	// Funcion de cifrado y cookies basicas
	private function setCooSesionn($nombre, $id_usuario, $pass_cod){
		$fec_manana = time() + (3600 * 12);
		
		setcookie(self::$miniDatos["nombre"] , $nombre, $fec_manana);
		setcookie(self::$miniDatos["id_user"], $this->encrypt($id_usuario, $this->miniLlave), $fec_manana);
		setcookie(self::$miniDatos["pass"]   , $this->encrypt($pass_cod  , $this->miniLlave), $fec_manana);
	}
	
	private function encrypt($string, $key) {
		$result = '';
		for($i=0; $i<strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char)+ord($keychar));
			$result.=$char;
		}
		
		$result=base64_encode($result);
		$result = str_replace(array('+','/','='),array('-','_','.'),$result);
		return $result;
	} 
	
	 private function decrypt($string, $key) {
		$string = str_replace(array('-','_','.'),array('+','/','='),$string);
		$result = '';
		$string = base64_decode($string);
		for($i=0; $i<strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char)-ord($keychar));
			$result.=$char;
		}
		return $result;
	}
	
	public function setVuetla($txt){
		return $this->encrypt($txt, $this->miniLlave);
	}
	
	public function getVuetla($txt){
		return $this->decrypt($txt, $this->miniLlave);
	}
	
}
?>