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
    '/solicitaDadosTeste',
    function () {
        $servidor = 'http://ueg.com.br/solicitaDados';

        // Parametros da requisição
        $content = json_encode(array(
            'token' => 'uev1'
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
    '/enviaVotacaoTeste',
    function () {
        $servidor = 'http://ueg.com.br/enviaVotacao';

        // Parametros da requisição
        $content = json_encode(array(
            'token' => 'uev1',
            'votacao' => array('1' => array('1' => 123, '2' => 52, 'branco' => 20, 'nulo' => 20), 
                               '2' => array('11' => 85, '22' => 37, 'branco' => 2, 'nulo' => 33)
                        ),
            'eleitores' => array('1' => 'João', '3' => 'Maria')
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

// Recebe requisição de cadastro da UEV
$app->post(
    '/cadastraUEV', '\app\controllers\Uev:SolicitaCadastroUEV'
);

$app->get(
    '/listaCandidatos', '\app\controllers\Candidato:listaCandidatos'
);

$app->get(
    '/listaEleitores', '\app\controllers\Eleitor:listaEleitores'
);

$app->post(
    '/solicitaDados', '\app\controllers\Uev:solicitaDados'
);

$app->post(
    '/enviaVotacao', '\app\controllers\Uev:enviaVotacao'
);

$app->run();