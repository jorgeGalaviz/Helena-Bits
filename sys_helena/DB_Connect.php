<?php
class BaseDatos{
    private $conexion, $host, $user, $password, $base;
	private $info, $SYS_ENTORNO, $lb_ejec;

    public function __construct($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE, $SYS_ENTORNO) {
		$this->host = $DB_HOST;
		$this->user = $DB_USER;
		$this->password = $DB_PASSWORD;
		$this->base = $DB_DATABASE;
		$this->SYS_ENTORNO = $SYS_ENTORNO;
		$this->info = "";
    }

    public function __destruct(){
		//$this->desconectar();
    }
	
    public function conectar(){
		$this->conexion = new mysqli(
			$this->host,
			$this->user,
			$this->password,
			$this->base
		);
		
		if (!$this->conexion && !$this->SYS_ENTORNO){
			if  ($this->conexion->connect_error) {
				$this->info = "ERROR CODE=DB100: Conexion fallida <br> " . $conn->connect_error;
				$this->desconecta();
				echo $this->getInfo();  
			} else {
				$this->info = "ERROR CODE=DB101: Conexion fallida <br> ";
				$this->desconecta();
				echo $this->getInfo();
			}
		}
		
		if (!$this->conexion->set_charset("utf8")) {
			printf("Error cargando el conjunto de caracteres utf8: %s\n", $this->conexion->error);
		}
		
    }

    public function desconectar(){
        if( $this->conexion ){
			$this->conexion->close();
        }
    }
	
    public function getInformacio() {
        return $this->info;
    }
	
    public function numResultados( $res ){
		return $res->num_rows;
    }
	
	public function ejecutar( $query ){
		if ( !$resultado = $this->conexion->query($query) ) {
			$resultado = NULL;
		
			if(!$this->SYS_ENTORNO ){
				$this->info = "Error: La ejecución de la consulta falló debido a: \n"
					+ "Query: " . $query . "\n"
					+ "Errno: " . $this->conexion->errno . "\n"
					+ "Error: " . $this->conexion->error . "\n";
				exit;
			}
		}
		
		return $resultado;
	}
	
	
    public function libera($res){
		$res->free();
    }

    public function getFetchAssoc( $res ){
		return $res->fetch_assoc();          
    }

    public function setConsulta( $query ){
		if( $this->conexion->query($query) ) {
			return "0";
		}else{
			if(!$this->SYS_ENTORNO){
    			$this->info = "Falló la consulta: (" . $this->conexion->errno . ") " . $this->conexion->error;
			}
			return "1";
			
		}
    }
	
}
	
?>