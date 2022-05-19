<?php
 // import do arquivo autoload, que fara as instancias do slim;
 require_once('vendor/autoload.php');

 //criando um objeto do slim chamandi app, para configurar os EndPoints;
 $app = new \Slim\app();

  //EndPoint Requisicao para listar todos os contatos
  $app->get('/contatos',function($request,$response,$args){

   $response->white('Testeando a requisicao / get ');

  });
 //EndPoint Requisicao para listar todos os contatos/id
  $app->get('/contatos/{id}',function($request,$response,$args){

   

  });
    //EndPoint Requisicao para inserir um novo contato
  $app->post('/contatos',function($request,$response,$args){

   

  });
 


?>