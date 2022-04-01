<?php

/**********************************************************************************
 * Objetivo: Arquivo resposavel por manipular os dados dentro do bd
 * Autor: Marcel
 * Data: 11/03/2022
 * Versão: 1.0
 ***********************************************************************************/

include('conexaoMysql.php');

// funcoes para realizar  no banco de dados



    function insertContato($dadocontatos){    
  $resposta = (boolean)false;

        // conexao esta recebendo o retorn na fuction conexaoMysql(); // abrindo conexao com o bds
       $conexao = conexaoMysql();

      $sql = "insert into tblcontatos 
         (nome,
         telefone, 
         celular , 
         email , 
         obs)

      value 

         ('".$dadocontatos{'nome'}."', 
         '".$dadocontatos{'telefone'}."', 
         '".$dadocontatos{'celular'}."', 
         '".$dadocontatos['email']."',
         '".$dadocontatos{'obs'}."');";

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
                                                                                                                                                                                                                                                                                                                                                                                                                                                          

    function updateContato(){
        
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
                  "Celular"  =>$rsdados['celular'],
                  "Email"  =>$rsdados['email'],
                  "Obs"  =>$rsdados['obs']
               );
               $cont++;
            } 
           
            
            fecharConexaoMyslq($conetion);
            return $arreydados;
            
        }

    
    }



    function selectByidContatos($id){                         // function para buscar no bds um contato ja registrado 

      $conetion = conexaoMysql();            //abrindo conexao com bds

       $slq = "select * from tblcontatos where idcontato =".$id ;                 ///coloca na lista no mysql em orede decrecente(desc) = descendente (asc) = acendente;

       $result = mysqli_query($conetion,$slq);
        if($result){
           
              if($rsdados = mysqli_fetch_assoc($result)){
                      
               $arreydados = array(
                  "id"   => $rsdados['idcontato'],
                  "Nome"  =>$rsdados['nome'],
                  "Telefone"  =>$rsdados['telefone'],
                  "Celular"  =>$rsdados['celular'],
                  "Email"  =>$rsdados['email'],
                  "Obs"  =>$rsdados['obs']
               );
               
            } 
           
            
            fecharConexaoMyslq($conetion);
            return $arreydados;
            
        }

    }



?>