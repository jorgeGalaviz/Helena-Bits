<?php
	class GalyVistaCuestionario{
		public function __construct() {
		}
		
		public function __destruct(){
		}
		
		// la vista de las pregunta se divide en dos partes
		// 1.- Vista de la pregunta, el texto
		// 2.- Contenido
		
		public function getCuerpo($id, $tp, $els){
			// Inicializar Elementos
			if( $els == NULL ){
				$els = $this->getBasicElemnts($tp);
			}
			
			// Generar vista de las preguntas
			$txt = "";
			switch($tp){
				case 1: // Texto
					$txt =  "<div id='".$id."_body'>"
						. "<p> <textarea class='form-control noresize' rows='3' placeholder='' onkeydown='return eveMaxLetras(event, this, 50);' onKeyUp='return eveMaxLetras(event, this, 50);'></textarea> </p>"
						. "<p class='form-group has-error'> <span class='pull-right text-muted lbLetras'>0 / 50 Letras</span> </p>"
						. "</div>";
					break;
					
				case 2: // Escala
					$txt =  "<div id='".$id."_body'>"
						. "<ul class='list-inline'><li>".$els["palI"]."</li><li class='pull-right'>".$els["palD"]."</li></ul>"
						. "<div class='btn-group' data-toggle='buttons' style='width:100%;'>";
						
					foreach( $els["escala"] as $i => $valor ){
						if( $valor["type"] == "radio" )
							$name = $els["name"];
						else
							$name = $valor["name"];

						$txt .= "<label class='btn btn-default'>"
							. "<input type='".$valor["type"]."' name='".$name."' id='".$name."_".$i."' value='".$valor["valor"]."' autocomplete='off'> "
								. $valor["txt"]
							. "</label>";
					}
					
					$txt .= "</div></div>";
					break;
					
				case 3: // Opcion Multiple
					$txt =  "<div id='".$id."_body'>"
						. "<div class='row btn-group-vertical' data-toggle='buttons' style='width:100%;'>";
						
					foreach( $els["escala"] as $i => $valor ){
						if( $valor["type"] == "radio" )
							$name = $els["name"];
						else
							$name = $valor["name"];

						$txt .= "<div class='col-xs-6 col-xs-offset-3 btn-group-vertical' >"
							. "<label class='btn btn-default btn-opcion'>"
							. "<input type='".$valor["type"]."' name='".$name."' id='".$name."_".$i."' value='".$valor["valor"]."' autocomplete='off' onchange='verOtro(this);'> "
								. $valor["txt"]
							. "</label>";
						if( $valor["es_otro"] == "1" ){
							$txt .= "<input type='text' name='".$name."_txt' class='form-control txt-otro' placeholder='¿Cúal?' style='display:none;'>";
						}
							
						$txt .= "</div>";
					}
					
					$txt .= "</div></div>";
					break;
					
				case 4:
					$txt =  "<ul id='".$id."_body' class='products-list product-list-in-box'>";
					
					
					foreach( $els["atributos"] as $i => $atributo ){
						$txt .= "<li class='item'>";
						$txt .= "<div>";
						$txt .= "<a href='javascript:void(0)' class='product-title'>" . $atributo["txt"];
						$txt .= "<div class='product-description btn-group' data-toggle='buttons' style='width:100%;'>";
						
						foreach( $els["escala"] as $j => $escala ){
							$txt .= "<label class='btn btn-default'>"
								. "<input type='radio' name='".$atributo["name"]."_".$i."'"
									. " id='".$atributo["name"]."_".$i."_".$j."'"
									. " value='".$escala["valor"]."' autocomplete='off'> "
									. $escala["txt"]
								. "</label>";
						}
						
						$txt .= "</div>";
						$txt .= "</div>";
						$txt .= "</li>";
					}
					$txt .= "</ul>";
					break;
			}
			return $txt;
		}
		
		public function getJS(){
			?>
            <script>
				function eveMaxLetras(e, obj, maxL){
					tmp = obj;
					var parent = $(obj).parent().parent();
					var ltxt = $(obj).val();
					var txt = ltxt.length+" / "+maxL+" Letras";
					$(parent).find(".lbLetras").html(txt);
					if( ltxt.length < maxL || (
						e.keyCode == 8 || e.keyCode == 46
					) ){
						$(parent).find(".lbLetras").removeClass("help-block");
						return true;
					}else{
						$(parent).find(".lbLetras").addClass("help-block");
						return false;
					}
				}
				
				function verOtro(obj){
					tmp = obj;
					$.each( $(obj).parent().parent().parent().find(".btn"), function( key, value ) {
						var objOtro = $(value).parent().find(".txt-otro");
						if( $(value).find("input").prop("checked") ){
							$(objOtro).css("display", "");
						}else{
							$(objOtro).css("display", "none");
						}
					});
				}
			</script>
            <?php
		}
		
		private function getBasicElemnts($tp){
			$bElems = "";
			switch( $tp ){
				case 2: // Elementos Base para generar las vistas
					$bElems = array(
						"palI" => "Palancas Izquierda"
						,"palD" => "Palancas Derecha"
						,"name" => "pr"
						, "escala" => array(
							array(
								"type" => "radio"
								, "name" => "pr"
								, "txt" => "1"
								, "valor" => "1"
							)
						)
					);
					break;
					
				case 3: // Opcion multiple
					$bElems = array(
						  "name" => "pr"
						, "escala" => array(
							array(
								"type" => "radio"
								, "name" => "pr"
								, "txt" => "Uno"
								, "valor" => "1"
								, "es_otro" => "0"
							)
							,array(
								"type" => "radio"
								, "name" => "pr"
								, "txt" => "Otro"
								, "valor" => "2"
								, "es_otro" => "1"
							)
						)
					);
					break;
					
				case 4: // Matriz
					$bElems = array(
						  "name" => "pr"
						, "escala" => array(
							array(
								"txt" => "Uno"
								, "valor" => "1"
							)
							,array(
								"txt" => "Dos"
								, "valor" => "2"
							)
						)
						, "atributos" => array(
							array(
								"name" => "pr1"
								, "txt" => "Atri 1"
							)
							,array(
								"name" => "pr2"
								, "txt" => "Atri 2"
							)
						)
					);
					break;
			}
			return $bElems;
		}
	}
?>