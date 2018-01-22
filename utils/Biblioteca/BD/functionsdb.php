<?php 

				//Função de consulta com Encode incluso
				function consulta($tabela,$campo,$where=NULL,$order=NULL){
				$sql = "SELECT {$campo} FROM {$tabela} {$where} {$order}";
				$result = $conn->query($sql);
				
				$query_rows = mysql_query($sql_rows);
				$num = mysql_num_fields($query_rows);
				
				for($y = 0; $y < $num; $y++){ 
					$names[$y] = mysql_field_name($query_rows,$y);
				}
				for($k=0;$resultado = mysql_fetch_array($query);$k++){
					for($i = 0; $i < $num; $i++){ 
						$resultados[$k][$names[$i]] = $resultado[$names[$i]];
					}
				}
			}
				
				
				
				//Função Encode UTF8 de Arrays
				//Para solucionar o problema de conversão de strings ao serem puxadas do bd
					function utf8_encode_array(&$input) {
						if (is_string($input)) {
							$input = utf8_encode($input);
						} else if (is_array($input)) {
							foreach ($input as &$value) {
								utf8_encode_array($value);
							}

							unset($value);
						} else if (is_object($input)) {
							$vars = array_keys(get_object_vars($input));

							foreach ($vars as $var) {
								utf8_encode_array($input->$var);
							}
						}
					}

?>