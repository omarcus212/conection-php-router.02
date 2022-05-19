<?php
/**********************************************************************************
 * Objetivo: Arquivo resposavel por manipular os dados dentro do bd
 * Autor: Marcus
 * Data: 10/05/2022
 * Versão: 1.0
 ***********************************************************************************/


require_once('conexaoMysql.php');



function selectAllEstados(){
    $conetion = conexaoMysql();            //abrindo conexao com bds

    $slq = "select * from tblEstado order by nome asc" ;                 ///coloca na lista no mysql em orede decrecente(desc) = descendente (asc) = acendente;

    $result = mysqli_query($conetion,$slq);
     if($result){
        $cont = 0;
           while($rsdados = mysqli_fetch_assoc($result)){
                   
            $arreydados[$cont] = array(
               "idestado"   => $rsdados['idestado'],
               "Nome"  =>$rsdados['nome'],
               "Sigla" => $rsdados['sigla']

            ); 

            $cont++;
         } 
        
         
         fecharConexaoMyslq($conetion);
         return $arreydados;
         
     }
}








?>