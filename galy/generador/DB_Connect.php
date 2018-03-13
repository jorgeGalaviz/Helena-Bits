<?php
class BaseDatos{
    private $conexion;

    public function __construct() {
		$this->host = DB_HOST;
		$this->user = DB_USER;
		$this->password = DB_PASSWORD;
		$this->base = DB_DATABASE;
    }

    public function __destruct(){
		$this->desconecta();
    }


    public function conectar(){
		$this->conexion= mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
				or die ("No se puede conectar al servidor SQL: " . DB_HOST);

		if (DB_DATABASE != null && DB_DATABASE != ""){
			mysql_select_db(DB_DATABASE)
					or die ("No es posible seleccionar a la base de datos: " . DB_DATABASE);
		}
    }

    function desconecta(){
        if($this->conexion){
            mysql_close($this->conexion);
        }
        
    }

	
    function ejecutar($query)
    {
		$resultado= mysql_query($query, $this->conexion)
				or die ("La consulta $query no regresó resultados");
		return $resultado;
    }

    function getRegistros($res, $type)
    {
		$w;
		if ( $w= mysql_fetch_array ($res, $type) )
				return $w;          
    }

    function getRegistro($query){
        $w = mysqli_query($this->conexion, $query, MYSQLI_USE_RESULT);
        return $w;
    }

    function liberar($res){
		mysql_free_result($res);
    }

    function setConsulta ($query){
            mysql_query( $query, $this->conexion);
            $afectadas= mysql_affected_rows();
            return $afectadas;
    }


    function numLineas ( $res)
    {
            // es igual que mysql_affected_rows, pero solo funciona con SELECT
            $num= mysql_num_rows($res);
            return $num;
    }

    function libera($res)
    {
            $result= mysql_free_result($res) or die ("No hay resultados que liberar");
            return $result;
    }
}
	
?>