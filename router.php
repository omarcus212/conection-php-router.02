<?php

/**************
 * obejtivo : arquivo de rota para segmentar as açoes emcaminhadas pelo view(front-end)
 *    esse arquivo sera responsavel por encaminhar a solicitaçao para a controller
 * 
 * autor : marcus-spinder
 * 
 * data : 04/03/22
 * 
 * versao : 1.0
 * 
/***************/


$action = (string)null;
$componente = (string)null;




/*validando se o metodo do index é post ou get*/  /* o post vai pegar so os dados do usuario */  /*o get chamar a controller que tem aver com os dados do user (se ele quer insiri/deletar/ comer kkkkkk etc...)*/
if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {

  $componente = strtoupper($_GET['componente']);
  $action = strtoupper($_GET['action']);


  //estrura condicional para avalidar quem esta solicitando  algo
  switch ($componente) {

    case 'CONTATOS';

      require_once('./controller/ControllerContatos.php');

      if ($action == 'INSERIR') {
              
        if(isset($_FILES) && !empty($_FILES)){

          $resposta =  inserirContatos($_POST,$_FILES);        // esta colocando o return do inserirContatos na variavel %resposta
          
        }else{
          $resposta =  inserirContatos($_POST,null);   
        }
         
  

      if (is_bool($resposta)) {                                       // verificando se o return é booleano 
                      echo ("<script>
                              alert('REGISTRO INSIRIDO COM SUCESSO');
                              window.location.href = 'index.php';
                              </script>");

      } elseif (is_array($resposta)) {                                      // (se nao) / verificando se o return é um arrey
                      echo ("<script>
                            alert('" . $resposta['message'] . "');
                            window.history.back();
                            </script>");
      }

      } else if ($action == 'DELETAR') 
      { 
                                     // DELETAR veio da href da index(linha 99/100), onde criamos um compenento e uma action em GET para poder colocar e trazer o id
          $idContatos = $_GET['id'];
          $foto = $_GET['foto'];
           
          $arraydados = array(
                     "id" => $idContatos,
                     "fotoname" => $foto        
          );

          $respostadados = excluirContatos($arraydados);

          if (is_bool($respostadados)) {
                    echo ("<script>
                          alert('REGISTRO EXCLUIDO COM SUCESSO');
                          window.location.href = 'index.php';
                            </script>");

          }else if(is_array($respostadados)){
                      echo ("<script>
                      alert('" . $resposta['message'] . "');
                      window.history.back();
                      </script>");

         }


        
      }else if($action == 'BUSCAR')
      {

        $idContatos = $_GET['id'];
        $respostadados = buscarContatos($idContatos);
         
        session_start();                                                                            //ativa a utilizacao de variaveis de sessao no servidor 
        $_SESSION['dadosContatos']=$respostadados;                                                 //guarda em uma variavel de sassao os dados que o banco de dados retornou para a buscar do id
                                                                                                  //(obs esse variavel de sessao sera utilizada na index, para colocar os dados na caixas de texto = passando os dados da route pra index e colocando nas caixa de texto)
         require_once('index.php');  

      }else if($action == 'EDITAR'){
            
        $idcontatos = $_GET['id'];     //id do action do form 
        $foto = $_GET['foto'];    

        $arraydados = array(
            "id" => $idcontatos,
            "foto" => $foto,
            "file" => $_FILES,
            $_POST
        );

        $resposta =  atualizarContatos($arraydados);                                // esta colocando o return do inserirContatos na variavel %resposta

      if (is_bool($resposta)) {                                       // verificando se o return é booleano 
                      echo ("<script>
                              alert('REGISTRO ATUALIZADO COM SUCESSO');
                              window.location.href = 'index.php';
                              </script>");

      } elseif (is_array($resposta)) {                                      // (se nao) / verificando se o return é um arrey
                      echo ("<script>
                            alert('" . $resposta['message'] . "');
                            window.history.back();
                            </script>");
      }


      }                                                                                         

      break;
          

  }
}
