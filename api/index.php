<?php

/*****************
 * obj: arquivo principal da api que ira receber a url e requisita e redireciona para as APIs (router/+ou-)
 * 
 * data:19/05/2022
 * 
 * autor: Marcus-Spider
 * 
 * <version:1 class="0"></version:1>
 * ***************** */


/*permiti ativar quais endereços de site que poderão fazer requisiçoes na api;  (*) = all*/
header('Acess-Control-Allow-Origin:*');

/*permiti ativar os metodos do protocolo http que ira requisitar a api */
header('Acess-Control-Allow-Methods:GET,POST,PUT,DELET,OPTION');

/*permiti ativar o content type da requisiçoes / formado de dados que sera ultilizado ex = json, xml, form/data etc...*/
header('Acess-Control-Allow-HeaderS:content-type');

/*permite liberar qual content-type sera ultilizado na api*/
header('Content-Type:application.json');

//receber a url digitada na requisição
$urlHTTPS = (string)$_GET['url'];

//converte a url requisitada em um arrey para dividir as opcoes de busca, que é separada pela barra 
$url = explode('/',$urlHTTPS);


//verifica qual a api sera encaminhada a requisição contatos/estados/produtos/etc...
switch(strtoupper($url[0])){

  // case 'CONTATOS';

  //   require_once('contatosapi/index.php'); 
  
  // break; 



  // case 'ESTADOS';
  
  //  require_once('contatosapi/index.php'); 


  // break; 

}
require_once('contatosapi/index.php'); 