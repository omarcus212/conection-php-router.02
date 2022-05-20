<?php
/**********************************************************************************
 * Objetivo: Arquivo para fazer upload de img;
 * Autor: Marcus
 * Data: 25/04/2022
 * Versão: 1.0
 ***********************************************************************************/

/******************** VARIAVEIS E CONSTANTES GOBLAIS DO PROJETO*************** */

//LIMITACAO DE 5MB PARA UPLOAD DE IMGS; (5*1024 = 5120); 
 const MAX_FILE_UPLOAD = 5120;
 const EXT_FILE_UPLOAD = array("image/jpg", "image/png", "image/jpeg", "image/gif");
 const DIRETORIO_FILE_UPLOAD = "arquivos/";

/****/

define('SRC', $_SERVER['DOCUMENT_ROOT'].'/Marcus/conectionPhpRouter02/');


/*********************************** FUNCTIONS GLOBAIS PARA O PROJETO **************************************************/
//function para converter o array em json;

function creatJson($arrayDados){ 

    if(!empty($arrayDados)){
     //configura o padrao da convercao para formato json
     header('Content-Type:application.json');

     //encode = converte um array para json 
   $dadosJson = json_encode($arrayDados);
 
      //decode = converte um json para array
     // json_decode();   
 
      return $dadosJson;
                        
    }else{

        return false;
        
    }
 
 }
  
?>