<?php
/*******
 * objetivo : arquivo responsavel pela manipulacao de dados de contatos 
 * obs(esse arquivo fara a ponte entre a view e a model);
 * 
 * autor : Marcus
 * 
 * Data : 04/03/22
 * 
 * versao : 1.0
 */



 function inserirContatos($dadoscontatos){
      
     if(!empty($dadoscontatos)){              //verificando se a caixa esta vazia     //empty = serve para verificar se o elemento esta vazio 


        if(!empty($dadoscontatos['txtNome']) & !empty($dadoscontatos['txtCelular']) & !empty($dadoscontatos['txtEmail'])){
   
  $arreyDados = array(
            
      "nome" => $dadoscontatos['txtNome'],
      "telefone" => $dadoscontatos['txtTelefone'],
      "celular" => $dadoscontatos['txtCelular'],
      "email" => $dadoscontatos['txtEmail'],
      "obs" => $dadoscontatos['txtObs']
        
  );

  require_once('./model/bd/contato.php');          //chamanda e mandando para a funcao insert la na model
  insertContato($arreyDados);

        }else{

                echo('falso');

        }

     }else{
         echo('<alert> sem dados </alert> ');
     }
 }


 function atualizarContatos(){
     
 }


 function deletarContatos(){
     
 }
 
 
 function listarrContatos(){
     
     
}
