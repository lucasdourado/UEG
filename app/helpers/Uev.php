<?php

namespace app\helpers;

class Uev {

	private $msgsErro;

	public function __construct() {

		$this->msgsErro = array(
			'formato_json' => 'Dados informados incorretos.<br>Formato do JSON:<br>{"nome": "Nome da UEV", "url_resposta": "nomedauev.com.br/recebeDados"}',
			'nome_uev' => 'Informar o nome da UEV.<br>',
			'url_resposta_uev' => 'Informar a URL para que os dados sejam enviados da UEV.<br>',
			'num_maximo' => 'O número máximo de cadastro de 10 UEVs foi atingido. Impossível realizar o cadastro.<br>'
		);
	}

	public function getMsgsErro($chave) {
		if($chave)
			return $this->msgsErro[$chave];
		return $this->msgsErro;
	}

}