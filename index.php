<?php

/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim(array(
    'templates.path' => 'templates'
));

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

// GET route
$app->get(
    '/',
    function () use ($app) {
        $objCandidato = new app\controllers\Candidato();
        $candidatos = $objCandidato->listaCandidatos();
    
        echo "{candidatos:".json_encode($candidatos)."}";
        
        //$data = array("candidatos" => $candidatos);
        //$app->render('default.php', $data);
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

// PUT route
$app->put(
    '/put',
    function () {
        echo 'This is a PUT route';
    }
);

// PATCH route
$app->patch('/patch', function () {
    echo 'This is a PATCH route';
});

// DELETE route
$app->delete(
    '/delete',
    function () {
        echo 'This is a DELETE route';
    }
);

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
