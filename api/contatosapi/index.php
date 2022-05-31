<?php
// import do arquivo autoload, que fara as instancias do slim;
require_once('vendor/autoload.php');

//criando um objeto do slim chamandi app, para configurar os EndPoints;
$app = new \Slim\app();

//EndPoint Requisicao para listar todos os contatos
$app->get('/contatos', function ($request, $response, $args) {

   require('../modulo/config.php');
   require_once('../controller/ControllerContatos.php');

   //solicita o dados
   if ($dados = listarContatos()) {

      if ($dadosJson = creatJson($dados)) {
         //caso os dados de certo , retorna o status code 200 para confirmar e logo envia o json
         return $response->withStatus(200)
            ->withHeader('content-Type', 'application/json')
            ->write($dadosJson);
      }

      // caso os dados de errado ele retorn o status code 404 
   } else {
      return $response->withStatus(404)
         ->withHeader('content-Type', 'application/json')
         ->write('{"message": "item nao encontrado"}');
   }
});/*feito*/

//EndPoint Requisicao para listar todos os contatos/id
$app->get('/contatos/{id}', function ($request, $response, $args) {

   require('../modulo/config.php');
   require_once('../controller/ControllerContatos.php');

   $id = $args['id'];

   if ($idContatos = buscarContatos($id)) {

      if ($dadosID = creatJson($idContatos)) {

         return $response->withStatus(200)
            ->withHeader('content-Type', 'application/json')
            ->write($dadosID);
      }
   } else {
      return $response->withStatus(404)
         ->withHeader('content-Type', 'application/json')
         ->write('{"message": "item nao encontrado"}');
   }
});/*feito*/

$app->delete('/contatos/{id}', function ($request, $response, $args) {

   if (is_numeric($args['id'])) {

      //$id recebe o id do registro que será retornada pela API. Esse ID está chegando pela variável criada no endpoint
      $id = $args['id'];

      //imports
      require('../modulo/config.php');
      require_once('../controller/ControllerContatos.php');

      //buca o nome da foto para ser excluída na controller
      if ($dados = buscarContatos($id)) {

         //recebe o nome da foto que a controller retornou 
         $foto = $dados['foto'];

         //cria um array com o ID e o nome da foto a ser enviada p/ cotroller excluir o registro
         $arrayDados = array(
            "id"    => $id,
            "foto"  => $foto
         );

         $resposta = excluirContatos($arrayDados);
         if (is_bool($resposta) && $resposta == true) { //chama a fução de excluir o contato, encaminhando o array com o ID e a foto

            // retorna ao cliente o sucesso da exclusão 
            return $response->withStatus(200)
               ->withHeader('Content-Type', 'application/json')
               ->write(
                  '{"message": "Registro e imagem exluído com sucesso" }'
               );
         } elseif (is_array($resposta) && isset($resposta['idErro'])) {

            //Validação referente ao erro 5
            if ($resposta['idErro'] == 5) {

               // retorna ao cliente o sucesso da exclusão E IMAGEM NÃO EXISTIA NO SERVIDOR
               return $response->withStatus(200)
                  ->withHeader('Content-Type', 'application/json')
                  ->write(
                     '{"message": "Registro exluído com sucesso. IMAGEM COM ERRO NO SERVIDOR " }'
                  );
            } else {
               //converte para json o erro, pois a controller retorna em array
               $dadosJson = creatJson($dados);/*ESTA NA PASTA CONFIG*/

               //status code 404, erro caso o cliente passa dados errados
               return $response->withStatus(404)
                  ->withHeader('Content-Type', 'application/json')
                  ->write('{"message": "ERRO AO EXCLUIR",
                                               "ERRO": ' . $dadosJson . ' 
                   }');
            }
         }
      } else {
         return $response->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write(
               '{"message": "ID INFORMADO NÃO EXISTE" }'
            );
      }
   } else {
      return $response->withStatus(404)
         ->withHeader('Content-Type', 'application/json')
         ->write(
            '{"message": "É OBRIGATÓTO INFORMAR UM ID NO FORMATO VÁLIDO (NUMÉRICO)" }'
         );
   }
});/*feito*/

//EndPoint Requisicao para inserir um novo contato
$app->post('/contatos', function ($request, $response, $args) {

    // Recebe do header da requisição qual será o content-type
    $contentTypeHeader = $request->getHeaderLine('Content-Type');

    // Cria um array, pois dependendo do content-type temos mais informações separadas pela ';'
    // $contentTypeHeader = explode(";", $request->getHeaderLine('Content-Type') )[0];
    $contentType = explode(";", $contentTypeHeader);

    switch ($contentType[0]) {
        case 'multipart/form-data':

            // Convertendo o corpo da requisição e transfromando em um Array - Sem a imagem
            // Recebe os dados enviados dados comuns enviados pelo corpo da requisição
            $dadosBody = $request->getParsedBody();

            // Recebe uma imagem enviada pelo corpo da requisição
            $uploadFiles = $request->getUploadedFiles();

            // Cria um array com todos os dados que chegaram pela requisição,
            // Devido aos dados serem protected (protegidos) - criamos um array
            // e recuperamos os dados pelos métodos do objeto
            $arrayFoto = array(
                "name"      => $uploadFiles['foto']->getClientFileName(),
                "type"      => $uploadFiles['foto']->getClientMediaType(),
                "size"      => $uploadFiles['foto']->getSize(),
                "tmp_name"  => $uploadFiles['foto']->file

            );


            // Cria uma chave 'foto' para colocar todos os dados do  obejto conforme é esperado na controller
            $file = array("foto" => $arrayFoto);

            // Cria um array com todos os dados comuns e do arquivo que será enviado para o servidor
            $arrayDados = array(
                $dadosBody,
                "file" => $file
            );

            // Import da controller de contatos, que fará a busca de dados
            require_once('../modulo/config.php');
            require_once('../controllers/controllerContatos.php');

            // Chama a função da controller para inserir os dados
            $resposta = inserirContatos($arrayDados);

            if(is_bool($resposta) && $resposta == true) {
                  return $response->write('{ "message": "Registro inserido com sucesso."}')
                                 ->withHeader('Content-Type', 'application/json')
                                 ->withStatus(201);

            } elseif(is_array($resposta) && isset($resposta['idErro'])) {
                // Realiza a conversão do array de dados em formato JSON
                $dadosJSON = creatJSON($resposta);

                // Retorna um erro que significa que o cliente passou dados errados
                return $response->write('{"message": "Houve um problema no processo de inserir.", "Erro": '. $dadosJSON .'}')
                                ->withHeader('Content-Type', 'application/json')
                                ->withStatus(400);
            }
            break;

            case 'application/json':
            return $response->write('{ "message": "O formato selecionado foi: JSON."}')
                            ->withHeader('Content-Type', 'application/json')
                            ->withStatus(200);
            break;
        default:
        return $response->write('{ "message": "O formato do Content-Type não é válido para essa requisição."}')
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus(400);
            break;
    }
   
});


/*simulando o put */ /*"uptade"*/ /*laravel seria put*/
$app->post('/contatos/{id}', function ($request, $response, $args) {

   if (is_numeric($args['id'])) {
      // Recebe o ID do registro que deverá ser retornado pela API
      // Esse ID esta chegando pela variável criada no endpoint
      $id = $args['id'];

      // Recebe do header da requisição qual será o content-type
      $contentTypeHeader = $request->getHeaderLine('Content-Type');

   
      // Cria um array, pois dependendo do content-type temos mais informações separadas pela ';'
      // $contentTypeHeader = explode(";", $request->getHeaderLine('Content-Type') )[0];
      $contentType = explode(";", $contentTypeHeader);

      switch ($contentType[0]) {
         case 'multipart/form-data':

            require('../modulo/config.php');
            require_once('../controller/ControllerContatos.php');

            if ($dadosContato = buscarContatos($id)) {

          

               // Convertendo o corpo da requisição e transfromando em um Array - Sem a imagem
               // Recebe os dados enviados dados comuns enviados pelo corpo da requisição
               $dadosBody = $request->getParsedBody();

               // Recebe uma imagem enviada pelo corpo da requisição
               $uploadFiles = $request->getUploadedFiles();

               // Cria um array com todos os dados que chegaram pela requisição,
               // Devido aos dados serem protected (protegidos) - criamos um array
               // e recuperamos os dados pelos métodos do objeto
               $arrayFoto = array(
                  "name"      => $uploadFiles['foto']->getClientFileName(),
                  "type"      => $uploadFiles['foto']->getClientMediaType(),
                  "size"      => $uploadFiles['foto']->getSize(),
                  "tmp_name"  => $uploadFiles['foto']->file

               );


               // Cria uma chave 'foto' para colocar todos os dados do  obejto conforme é esperado na controller
               $file = array("foto" => $arrayFoto);

               // Cria um array com todos os dados comuns e do arquivo que será enviado para o servidor
               $arrayDados = array(
                  $dadosBody,
                  "file" => $file,
                  "id" => $id,
                  "foto" => $fotoatual
               );

               // Import da controller de contatos, que fará a busca de dados
               require_once('../modulo/config.php');
               require_once('../controllers/controllerContatos.php');

               // Chama a função da controller para inserir os dados
               $resposta = inserirContatos($arrayDados, $arrayDados['file']);

               if (is_bool($resposta) && $resposta == true) {
                  return $response -> withStatus(200)
                        ->withHeader('Content-Type', 'application/json')
                       -> write('{ "message": "Registro atualizado com sucesso."}');
                    


               } elseif (is_array($resposta) && isset($resposta['idErro'])) {
                  // Realiza a conversão do array de dados em formato JSON
                  $dadosJSON = creatJson($resposta);

                  // Retorna um erro que significa que o cliente passou dados errados
                  return $response->write('{"message": "Houve um problema no processo de inserir.", "Erro": ' . $dadosJSON . '}')
                     ->withHeader('Content-Type', 'application/json')
                     ->withStatus(400);
               }
            } else {
               return $response->withStatus(404)
               ->withHeader('Content-Type', 'application/json')
               ->write(
                  '{"message": "ID INFORMADO NÃO EXISTE" }'
               );
            }

            break;

            case 'application/json':
            return $response->write('{ "message": "O formato selecionado foi: JSON."}')
               ->withHeader('Content-Type', 'application/json')
               ->withStatus(200);
            break;
             default:
            return $response->write('{ "message": "O formato do Content-Type não é válido para essa requisição."}')
               ->withHeader('Content-Type', 'application/json')
               ->withStatus(400);
            break;
      }
   } else {
      // Retorna um erro que significa que o cliente passou dados errados
      return $response->write('{"message": "É obrigatório informar um ID com um formato válido (número)."}')
         ->withHeader('Content-Type', 'application/json')
         ->withStatus(404);
   }
});

$app->run();



/**********
 * Request = ele recebe dados do corpo da requisicao ex: JSON,DATA,XML 
 * 
 * Reposnde = envia/devolve os dados de retorno da api
 * 
 * Arg     =  permiti receber dados de atributos na api
 * ******************/
