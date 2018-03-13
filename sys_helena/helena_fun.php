<?php
class Funciones{
	public static function getElem($txt) {
		if( isset($_POST[$txt]) )
			return $_POST[$txt];
		else
			return "";
    }
	
	public static function limpiarTXT($txt){
		$h = array("'", "\n", "\t");
		$y = array("''", "", " ");
		
		$newTXT = str_replace($h, $y, $txt);
		
		return $newTXT;
	}
	
	public static function limpiarTXT_JSON($txt){
		$h = array("'", "", "\t");
		$y = array("\'", "\"", " ");
		
		$newTXT = str_replace($h, $y, $txt);
		
		return $newTXT;
	}
	
	public static function getLlave($es_corta){
		if( $es_corta ){
			return date("ymdGis") . rand(1000, 9999);
		}else{
			return date("ymd-Gis") . rand(10000, 99999);
		}
		
	}
	
	public static function getConvertBN($valor){
		if( $valor == "false" ){
			return 0;
		}else if( $valor == "true" ){
			return 1;
		}else{
			return 99;
		}
	}
	
	public static function getSQLReorden($tabla, $campoId, $campoNo, $inWhere){
		$query = array();
		$inQuery = "CREATE TEMPORARY TABLE re_orden ( new_orden INT NOT NULL AUTO_INCREMENT, id int, PRIMARY KEY (new_orden)); ";
		array_push( $query, $inQuery );
		
		$inQuery = "insert into re_orden (id) select $campoId from $tabla";
		if( $inWhere != "" && $inWhere != NULL ){
			$inQuery .= " where " . $inWhere;
		}
		array_push( $query, $inQuery . " order by $campoNo;" );
		
		$inQuery = "update $tabla as nTabla inner join re_orden as re on re.id = nTabla." . $campoId
					. " set nTabla." . $campoNo . " = re.new_orden;";
		array_push( $query, $inQuery );
		
		$inQuery = "drop table re_orden;";
		array_push( $query, $inQuery );
		return $query;
	}
}
?>