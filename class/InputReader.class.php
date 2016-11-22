<?php
/*
 Classe basica para manipular entrada do teclado pelo terminal
*/
class InputReader{

	private $file_handler;

	/**
	* Construtor
	**/
	function __construct(){
		$this->file_handler = fopen('php://stdin', 'r');
	}

	/**
		Exibe na tela a mensagem e aguarda o valor de entrada do tipo $type 

		@param $message Mensagem a ser exibida na tela
		@param $type O tipo do valor que se deseja ler segundo o formato 
					 especificado em http://php.net/manual/pt_BR/function.sprintf.php
		@return Retorna o valor lido pelo terminal no formato especificado por $type;      
	**/
	public function read($message, $type='%s'){

		print($message);
		fscanf($this->file_handler, $type, $rvar);

		return $rvar;
	}

	private function close(){
		fclose($this->file_handler);
	}


	function __destruct(){
		$this->close();

	}

}
