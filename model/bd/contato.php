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
              
                     if(mysqli_affected_rows($conexao))         //se teve uma linha afetada ou nao no bds = linha afeteda = se o banco recusou ou add a linha 'script';

                        return true;

                     else

                        return false;

               }
                 else{                             

                  return false;
               }


}

                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                                                                                                                                                                                          

    function updateContato(){
        
    }


    function deleteContato(){
        
    }


    function selectAllContatos(){
       $conetion = conexaoMysql();            //abrindo conexao com bds

       $slq = 'select "from tblcontatos"' ;

       $result = mysqli_query($conetion,$slq);
        if($result){
           $cont = 0;
              while($rsdados = mysqli_fetch_assoc($result)){
                      
               $arreydados[$cont] = array(

                  "Nome"  =>$rsdados['nome'],
                  "Telefone"  =>$rsdados['telefone'],
                  "Celular"  =>$rsdados['celular'],
                  "Email"  =>$rsdados['Email'],
                  "Obs"  =>$rsdados['obs']
               );
               $cont++;
            } 
            return $arreydados;
        }

    
    }



?>