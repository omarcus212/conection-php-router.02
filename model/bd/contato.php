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



      mysqli_query($conexao,$sql);   // executa o escrip no bds , mysqli_query(QUALBANCODEDADOS,QUAISDADOS);
    }

    function updateContato(){
        
    }


    function deleteContato(){
        
    }


    function selectAllContatos(){
        
    }



?>