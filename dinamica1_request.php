<?php
require 'vendor/autoload.php';
require 'class/InputReader.class.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

$input = new InputReader();
$id = $input->read('Entre com a id do usuário: ', '%s');


$url = 'http://ec2-35-164-223-211.us-west-2.compute.amazonaws.com';
$recurso = '/hirers/'.$id.'/opportunities';
$verbo = 'GET';


$client = new Client();

try{

	$request = $client->request($verbo, $url.$recurso);
	$body = $request->getBody();

	if( $request->getStatusCode() == '200' ){
	
		$json = json_decode($body);
		
		if(is_array($json)){
			$n = count($json);
			echo $n."\n";
		}else{
			echo "PHP: json_decode() possui mais de 127 objetos.";
		}

	}else{
	
		echo 'Erro('. $request->getStatusCode().'): '.$body;

	}

} catch (RequestException $e) {

    if ($e->hasResponse()) {
        echo Psr7\str($e->getResponse())."\n";
    }

}

?>
