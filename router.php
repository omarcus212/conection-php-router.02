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
$nome = (string)null;



/*validando se o metodo do index é post ou get*/  /* o post vai pegar so os dados do usuario */  /*o get chamar a controller que tem aver com os dados do user (se ele quer insiri/deletar/ comer kkkkkk etc...)*/
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $componente = strtoupper($_GET['componente']);       
    $action = $_GET['action'];


    //estrura condicional para avalidar quem esta solicitando  algo
       switch($componente){

            case 'CONTATOS':
               
                        echo('chamando a controlle de contatos');
            break;
  }
}

?>