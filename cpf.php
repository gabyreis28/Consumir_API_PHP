<?php

/*
 Author: Gabriela Dias
 Description: simple api consult document cpf
*/


$config = parse_ini_file("config.ini"); // arquivo de configuração

$out = file_get_contents($config['BASE_URL'] . "/cpf?cpf=" . $_GET['cpf']); // get private url api

$result = json_decode($out, true); // decode json result $out

switch($result) {
		
	/* Verificação se CPF existe */ 
	case $result == "NULL": 
		die($config['ERROR_MENSAGEM']); // mensagem de erro configuravel em .ini
		break;
		
	/* Caso CPF exista, seguir com aplicação */ 
	default:
		$array = $result['Entities'];

		/* Foreach dados pessoais */ 
		foreach ($array as $valor) {
			$arr1 = $valor['People'];

			foreach ($arr1 as $name){
				echo "Nome: " . $name['Name'] . "<br>";
				echo "Birthdate: " . $name['Birthdate'] . "<hr>";
			}
		}
		
		/* Foreach dados mãe */ 
		foreach ($array as $valor) {
			$arr1 = $valor['People'];

			foreach ($arr1 as $valor2) {
			   $arr2 = $valor2['RelatedPeople'];

				foreach ($arr2 as $valor3) {

					if ($valor3['Name'] == "") {
						echo "Nome mãe: NÃO LOCALIZADO";
						return;
					}

					if ($valor3['Birthdate'] == "") {
						echo "Birthdate: NÃO LOCALIZADO";
						return;
					}


					echo "Nome mãe: " .  $valor3['Name'] . "<br>";
					echo "Birthdate: " . $valor3['Birthdate'];
				}
			}
		}
		
		break;
}


