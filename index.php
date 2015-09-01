<?php

require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim(array(
    'templates.path' => 'templates'
));

$app->get(
    '/',
    function () use ($app) {
        $app->render('default.php');
    }
);

$app->get(
    '/cadastraUEVTeste',
    function () {
        $servidor = 'http://ueg.com.br/cadastraUEV';

        // Parametros da requisição
        $content = json_encode(array(
            'nome' => 'UEV 1',
            'url_resposta' => 'uev1.com.br/dados'
        ));
        
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => "Connection: close\r\n".
                            "Content-type: application/json\r\n".
                            "Content-Length: ".strlen($content)."\r\n",
                'content' => $content
            )
        ));

        // Realize comunicação com o servidor
        $contents = file_get_contents($servidor, null, $context);            
        
        echo $contents;
    }
);

$app->get(
    '/testeAdm', '\app\controllers\Administrador:fechaCadastro'
);

// Recebe requisição de cadastro da UEV
$app->post(
    '/cadastraUEV', '\app\controllers\Uev:SolicitaCadastroUEV'
);

$app->get(
    '/listaCandidatos', '\app\controllers\Candidato:listaCandidatos'
);

$app->run();