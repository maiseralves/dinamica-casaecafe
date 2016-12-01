<?php
require 'vendor/autoload.php';
require 'class/InputReader.class.php';
include 'forms/form_opportunities.inc.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

$url = 'http://ec2-35-164-223-211.us-west-2.compute.amazonaws.com';
$recurso = '/opportunities';
$verbo = 'POST';


$input = new InputReader();
$id = "";


do{
	$id = $input->read('ID do contratante (hirer) a ser criado no recurso '.$recurso.': ', '%d');
	
	$checagem = !is_integer($id);

	if($checagem){
		 echo PHP_EOL."\t -> Digite um valor inteiro".PHP_EOL.PHP_EOL;
	}

}while($checagem);



// funcao que faz preencher os campos do objeto json
function fill_fields(&$value, $field_name, $array_key){
	
	$input = new InputReader();

	if(!is_array($value)){
		//monta o label do campo a ser preenchido
		$lbl = '"'.$array_key.$field_name.'" ('.$value.') : ';
	}else{
		//se o valor for um array chama esta função recursivamente
		array_walk($value, __FUNCTION__, $field_name.'.');
	}

	if($value === 'string'){ 
		
		$value = $input->read($lbl, '%s');

	}elseif($value === 'integer'){

		valida_inteiro:

		$value = $input->read($lbl, '%d');

		if(!is_integer($value)){
			echo "\tO valor deve ser um inteiro".PHP_EOL;
			goto valida_inteiro;
		}

		
	}elseif($value === 'bool'){

		valida_bool:

		$bool = $input->read($lbl, '%s');
		

		if($bool !== "true" && $bool !== "false") {
			echo "\tO valor deve ser: true ou false".PHP_EOL;
			goto valida_bool;
		}else{
			$value = settype($bool, 'boolean');
		}
		
	}elseif($value === 'float'){

		valida_float:

		$value = $input->read($lbl, '%f');

		if(!is_float($value)){
			echo "\tO valor deve ser um float (use ponto para separar o decimal)".PHP_EOL;
			goto valida_float;
		}

	}

}


$FORM_FIELDS = str_replace('%ID%', $id, $FORM_FIELDS);
$FORM_FIELDS = str_replace('%DATA%', date("Y-m-d H:i:s"), $FORM_FIELDS);


$key = "";
$json = json_decode($FORM_FIELDS, true);

echo PHP_EOL."\tEntre com os valores dos campos da oportunidade: ".PHP_EOL.PHP_EOL;

//percorre o array json aplicando a função "fill_fields"
array_walk($json, 'fill_fields', $key);

$json_coded = json_encode($json);


$client = new Client();

try{

	$response = $client->post($url.$recurso, ['body' => $json_coded ]);
	$body = $response->getBody();
	$json_response = json_decode($body, true);

	if( $response->getStatusCode() == '201' ){

		echo PHP_EOL."\t".$json_response['message'].PHP_EOL.PHP_EOL;

	}else{
	
		echo PHP_EOL.'Erro('. $request->getStatusCode().'): '.
			  $json_response['message'].PHP_EOL;;

	}

} catch (RequestException $e) {

    if ($e->hasResponse()) {
		
        echo PHP_EOL.$e->getMessage().PHP_EOL;
    }

}

?>
