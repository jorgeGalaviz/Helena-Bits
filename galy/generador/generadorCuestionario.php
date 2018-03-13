<?php
	class ELY{
		private $db;
		private $tab_preguntas;
		
		function __construct() {
			$this->db = new BaseDatos();
			$this->tab_preguntas = "cat_preguntas";
		}
		
		function __destruct() {
			$this->db = null;
		}
		
		function getSQLCAM($tp_cuestionario){
			$sql = "select * "
				. " from ".$this->tab_preguntas." where id_campania = $tp_cuestionario";
			$sql .= " order by id_orden;";
			
			return $sql;
		}
		
		function generar($tp_cuestionario){
			$sql = $this->getSQLCAM($tp_cuestionario);
			
			$this->db->conectar();
			$resultado = $this->db->ejecutar($sql);	
			while ($fila = $this->db->getRegistros($resultado, MYSQLI_USE_RESULT)) {
				$categoria = $fila["categoria"];
				$tp_pregunta = $fila["tipo"];
				
				if($categoria != "" && $tp_pregunta != ""){
					switch($categoria){
						case "NA":
							$this->tp_pre_label($fila);
							break;
						case "AP":
							switch($tp_pregunta){
								case 1:
									$this->tp_pre_tp1($fila, "jsCust");
									break;
								default:
									printf("ID: %s  Nombre: %s<br>", $categoria, $tp_pregunta);  
									break;
							}
							break;
						default:
							echo("Categoria desconocida (" . $fila["id_pregunta"] .")");
							break;
					}
				}else{
					echo("Categoria desconocida (" . $fila["id_pregunta"] .")");
				}
			}
			
			$this->db->liberar($resultado);
		}
		
		//-------------- Tipos de Preguntas
		function tp_pre_label($row){
			$preg = $row["pregunta"];
			$css = "";
			if($row["tipo"] == "0"){
				$css = "well";
			}
			
			echo '<div id="pr'.$row["id_orden"].'" class="'.$css.'">';
			echo "$preg";
			echo '</div>';
		}// --- LABEL NA
		
		//-------------------------------------- P1 ------------------
		function tp_pre_tp1($row, $jsCust){
			$preg = $row["pregunta"];
			$pregNumero = $row["nombre_corto"];
			
			echo "<div id='pr".$row["id_orden"]."' class='form-group' style='margin-bottom:20px;'>";
			echo "<h3>$pregNumero <span class='font-noraml num'>$preg</span></h3>";
			
			if($row["opcion"] != null && $row["opcion"] != ""){
				for($i = 1; $i <= intval($row["opcion"] ); $i++){
					$N_leer = "N";
					if($i == 1)
						$N_leer  = "Y";
					//Click
					$click = "";
					if($jsCust != "" && $jsCust != null){
						$click = "onKeyUp='" . $jsCust . "(this, $i)'";
					}
					
					$name = "";
					//---________------Texto
					echo "<div id='prs".$row["id_orden"]."'>";
					echo "	<label class='col-lg-12 control-label label-white'>";
					echo "		$i";
					echo "	</label>";
					echo "	<textarea id='ptxt".$row["id_orden"]."' name='$name'"
						. " $click n-pregunta='$pregNumero' no-leer='$N_leer' "
						. " class='form-control required col-lg-12 textoArea'></textarea>";
					echo "</div>";
					//----___---
				}//Fin menciones
			}else{
				$click = "";
				if($jsCust != "" && $jsCust != null){
					$click = "onKeyUp='" . $jsCust ."(this)'";
				}
				
				$N_leer = "S";
				if($row["subtipo"] == "1")
					$N_leer = "N";
				
				$name = $row["campo"];
				//---TEXT PLANO
				echo "<div id='prs".$row["id_orden"]."'>";
				echo "	<textarea id='ptxt".$row["id_orden"]."' name='$name'"
					. " $click n-pregunta='$pregNumero' no-leer='$N_leer' "
					. " class='form-control required col-lg-12 textoArea'></textarea>";
				echo "</div>";
				//--
			}
			
			echo "</div>";
		  

		}
		
		
	}
?>