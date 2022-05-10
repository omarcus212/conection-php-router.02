<?php
/*******
 * objetivo : arquivo responsavel pela manipulacao de dados de Estados
 * 
 * autor : Marcus
 * 
 * Data : 10/05/22
 * 
 * versao : 1.0
 */

require_once('modulo/config.php'); 
require_once('model/bd/Estado.php'); 

function listarEstado(){
         
    $dados = selectAllEstados();

    if(!empty($dados))
        
        return $dados;

    else

        return false;
    
}













 ?>