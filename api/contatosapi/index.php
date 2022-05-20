<?php
 // import do arquivo autoload, que fara as instancias do slim;
 require_once('vendor/autoload.php');

 //criando um objeto do slim chamandi app, para configurar os EndPoints;
 $app = new \Slim\app();

  //EndPoint Requisicao para listar todos os contatos
  $app->get('/contatos',function($request,$response,$args){

   require('../modulo/config.php');
   require_once('../controller/ControllerContatos.php');

   //solicita o dados
   if($dados = listarContatos()){

      if($dadosJson = creatJson($dados)){
           //caso os dados de certo , retorna o status code 200 para confirmar e logo envia o json
        return $response->withStatus(200)
                 ->withHeader('content-Type','application/json')
                 ->write($dadosJson);

      }
      
      // caso os dados de errado ele retorn o status code 404 
   }else{
    return $response->withStatus(404)
    ->withHeader('content-Type','application/json')
    ->write('{"message": "item nao encontrado"}');
   }


  });
 //EndPoint Requisicao para listar todos os contatos/id
  $app->get('/contatos/{id}',function($request,$response,$args){

    require('../modulo/config.php');
    require_once('../controller/ControllerContatos.php');
 
    $id = $args['id'];

    if($idContatos = buscarContatos($id)){

         if($dadosID = creatJson($idContatos)){

          return $response->withStatus(200)
          ->withHeader('content-Type','application/json')
          ->write($dadosID);
         }
    

        }else{
        return $response->withStatus(404)
            ->withHeader('content-Type','application/json')
             ->write('{"message": "item nao encontrado"}');
   }

    
   
  });
    //EndPoint Requisicao para inserir um novo contato
  $app->post('/contatos',function($request,$response,$args){

   

  });

  $app->run();
 


  /**********
   * Request = ele recebe dados do corpo da requisicao ex: JSON,DATA,XML 
   * 
   * Reposnde = envia/devolve os dados de retorno da api
   * 
   * Arg     =  permiti receber dados de atributos na api
   * ******************/

?>