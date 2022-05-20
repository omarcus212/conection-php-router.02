<?php

/**********************************************************************************
 * Objetivo: Arquivo resposavel por manipular os dados dentro do bd
 * Autor: Marcus
 * Data: 11/03/2022
 * Versão: 1.0
 ***********************************************************************************/

require_once('conexaoMysql.php');

// funcoes para realizar  no banco de dados



function insertContato($dadocontatos){    
  $resposta = (boolean)false;

        // conexao esta recebendo o retorn na fuction conexaoMysql(); // abrindo conexao com o bds
       $conexao = conexaoMysql();

      $sql = "insert into tblcontatos 
         (nome,
         telefone, 
         celular, 
         email, 
         obs,
         foto,
         idestado)

      value 

         ('".$dadocontatos{'nome'}."', 
         '".$dadocontatos{'telefone'}."', 
         '".$dadocontatos{'celular'}."', 
         '".$dadocontatos['email']."',
         '".$dadocontatos{'obs'}."',
         '".$dadocontatos{'foto'}."',
          '".$dadocontatos{'idestado'}."');";

        
      //se deu certo ou se deu erro no script
      if(mysqli_query($conexao,$sql)){// executa o escrip no bds , mysqli_query(QUALBANCODEDADOS,QUAISDADOS);  
              
                     if(mysqli_affected_rows($conexao))  {
                        $resposta = true;
                     }    
                        //se teve uma linha afetada ou nao no bds = linha afeteda = se o banco recusou ou add a linha 'script';
                    fecharConexaoMyslq($conexao);
                    return $resposta;
        } 
       
}                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                                                                                                                                                                                          

function updateContato($dadocontatos){
      $resposta = (boolean)false;
      // conexao esta recebendo o retorn na fuction conexaoMysql(); // abrindo conexao com o bds
     $conexao = conexaoMysql();

    $sql = "update tblcontatos set 
       nome =     '".$dadocontatos{'nome'}."',
       telefone = '".$dadocontatos{'telefone'}."',
       celular =  '".$dadocontatos{'celular'}."',  
       email =    '".$dadocontatos['email']."',
       obs =      '".$dadocontatos{'obs'}."',
       foto =     '".$dadocontatos{'foto'}."',
       idestado =  '".$dadocontatos{'idestado'}."' 
       where idcontato =".$dadocontatos['id'];

    
   

    //se deu certo ou se deu erro no script
    if(mysqli_query($conexao,$sql)){// executa o escrip no bds , mysqli_query(QUALBANCODEDADOS,QUAISDADOS);  
            
                   if(mysqli_affected_rows($conexao))  {
                      $resposta = true;
                   }    
                      //se teve uma linha afetada ou nao no bds = linha afeteda = se o banco recusou ou add a linha 'script';
                  fecharConexaoMyslq($conexao);
                  return $resposta;
      } 
     
        
}


function deleteContato($id){

      $statusResposta = (boolean)false;

        $conexao = conexaoMysql();

        $slq ="delete from tblcontatos where idcontato = ".$id;

       if(mysqli_query($conexao,$slq)){
          if(mysqli_affected_rows($conexao)){            //verifica se o bds teve sucesso na execucao
            $statusResposta = true;

          }
          fecharConexaoMyslq($conexao);    
          return $statusResposta;
       }

       return $statusResposta;
        
}



function selectAllContatos(){
       $conetion = conexaoMysql();            //abrindo conexao com bds

       $slq = "select * from tblcontatos order by idcontato desc" ;                 ///coloca na lista no mysql em orede decrecente(desc) = descendente (asc) = acendente;

       $result = mysqli_query($conetion,$slq);
        if($result){
           $cont = 0;
              while($rsdados = mysqli_fetch_assoc($result)){
                      
               $arreydados[$cont] = array(
                  "id"   => $rsdados['idcontato'],
                  "Nome"  =>$rsdados['nome'],
                  "Telefone"  =>$rsdados['telefone'],
                  "celular"  =>$rsdados['celular'],
                  "Email"  =>$rsdados['email'],
                  "Obs"  =>$rsdados['obs'],
                  "foto" =>$rsdados['foto'],
                  "idestado" =>$rsdados['idestado']
               );
               $cont++;
            } 
           
            
            fecharConexaoMyslq($conetion);


            if(isset($arreydados)){
               return $arreydados;
            }else{
               return false;
            }
           
            
        }
}



function selectByidContatos($id){                         // function para buscar no bds um contato ja registrado 



      $conetion = conexaoMysql();            //abrindo conexao com bds

      $conexao = conexaoMysql();

      //script para listar todos os dados do BD
      $sql = "select * from tblcontatos where idcontato = ".$id;
      
      //Executa o scrip sql no BD e guarda o retorno dos dados, se houver
      $result = mysqli_query($conexao, $sql);

      //Valida se o BD retornou registros
      if($result)
      {
          //mysqli_fetch_assoc() - permite converter os dados do BD 
          //em um array para manipulação no PHP
          //Nesta repetição estamos, convertendo os dados do BD em um array ($rsDados), além de
          //o próprio while conseguir gerenciar a qtde de vezes que deverá ser feita a repetição
          
          if ($rsDados = mysqli_fetch_assoc($result))
          {
              //Cria um array com os dados do BD
              $arrayDados = array (
                  "id"        =>  $rsDados['idcontato'],
                  "nome"      =>  $rsDados['nome'],
                  "telefone"  =>  $rsDados['telefone'],
                  "celular"   =>  $rsDados['celular'],
                  "email"     =>  $rsDados['email'],
                  "obs"       =>  $rsDados['obs'],
                  "foto"      =>  $rsDados['foto'],
                  "idestado"  =>  $rsDados['idestado']
              );
          }
      }    
          //Solicta o fechamento da conexão com o BD
         fecharConexaoMyslq($conexao);
             
         if(isset($arrayDados)){
            return $arrayDados;
         }else{
            return false;
         }
         

}



?>