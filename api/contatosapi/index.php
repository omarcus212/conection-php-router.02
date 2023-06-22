<?php
// import do arquivo autoload, que fara as instancias do slim;
require_once('vendor/autoload.php');

//criando um objeto do slim chamandi app, para configurar os EndPoints;
$app = new \Slim\app();

//EndPoint Requisicao para listar todos os contatos
$app->get('/contatos', function ($request, $response, $args) {


    return $response->withStatus(200)->write('res de json');
 
});/*feito*/


$app->run();



/**********
 * Request = ele recebe dados do corpo da requisicao ex: JSON,DATA,XML 
 * 
 * Reposnde = envia/devolve os dados de retorno da api
 * 
 * Arg     =  permiti receber dados de atributos na api
 * ******************/
