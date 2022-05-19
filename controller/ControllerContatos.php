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

function inserirContatos($dadoscontatos, $file){
   $resultfoto = (string)null;
        
        if(!empty($dadoscontatos)){  //verificando se a caixa esta vazia     //empty = serve para verificar se o elemento esta vazio 

        
            if(!empty($dadoscontatos['txtNome']) & !empty($dadoscontatos['txtcelular']) & !empty($dadoscontatos['txtEmail']) & !empty($dadoscontatos['sltestado'])){
    
              if($file['flefoto']['name'] != null){
                require_once('modulo/upload.php');      
                $resultfoto = uploand($file['flefoto']);

                if(is_array($resultfoto)){
                    require_once('modulo/config.php'); 
                   
                    return $resultfoto;
                }
                
              }else{
                $file['flefoto'] = 'sem-foto.gif';
              }
             
                   
        $arreyDados = array(
                
        "nome" => $dadoscontatos['txtNome'],
        "telefone" => $dadoscontatos['txtTelefone'],
        "celular" => $dadoscontatos['txtcelular'],
        "email" => $dadoscontatos['txtEmail'],
        "obs" => $dadoscontatos['txtObs'],
        "foto" => $resultfoto ,
        "idestado" => $dadoscontatos['sltestado']
    );

            require_once('./model/bd/contato.php');         //chamanda e mandando para a funcao insert la na model
            if(insertContato($arreyDados)){

                return true;

            }else{

                    return array('idErro ' => 1, 
                    'message' => 'nao foi possivel inserir os dados' );     
            }

            
                }else {

                return array('idErro ' => 2,  'message' => 'existem campos obrigatorios que nao foram preenchidos');

                }



        }

            
}
 


function atualizarContatos($dadoscontatos,$arreydados){ 

  $statusfoto = (boolean)false;  
        
  $id = $arreydados['id'];
  $namefoto = $arreydados['foto'];
  $file = $arreydados['file'];

        if(!empty($dadoscontatos)){              //verificando se a caixa esta vazia     //empty = serve para verificar se o elemento esta vazio 


            if(!empty($dadoscontatos['txtNome']) & !empty($dadoscontatos['txtcelular']) & !empty($dadoscontatos['txtEmail'])){
                         

                if(!empty($id) && $id != 0 && is_numeric($id)){

                if($file['flefoto']['name'] != null){
                    require_once('modulo/upload.php');      
                    $novafoto = uploand($file['flefoto']); 
                    $statusfoto = true;
                }else{
                    $novafoto = $namefoto;                 //se nova foto tiver null peranence as msm foto que esta no bd;
                }

        $arreyDados = array(

        "id" => $id,   
        "nome" => $dadoscontatos['txtNome'],
        "telefone" => $dadoscontatos['txtTelefone'],
        "celular" => $dadoscontatos['txtcelular'],
        "email" => $dadoscontatos['txtEmail'],
        "obs" => $dadoscontatos['txtObs'],
        "foto" => $novafoto,
        "idestado"=> $dadoscontatos['sltestado']
         
    );

   
  
            require_once('./model/bd/contato.php');         //chamanda e mandando para a funcao insert la na model
            if(updateContato($arreyDados)){
               
                //validacao para verificar se sera necessario para apagar a foto antiga
                if($resultfoto){

                    unlink(DIRETORIO_FILE_UPLOAD.$foto);
                }
                return true;

            }else{

                    return array('idErro ' => 1, 
                    'message' => 'nao foi possivel atualizar os dados' );     
            }

        }else{                 // else de fechamento do estrura de deciçao do $id;
            return array('idErro ' => 4, 
            'message' => 'id inexistente' );     
        }
                }else {

                return array('idErro ' => 2,  'message' => 'existem campos obrigatorios que nao foram preenchidos');

                }



        }
        
}




function excluirContatos($arreydados){

    $id = $arreydados['id'];
    $foto = $arreydados['fotoname'];


        if($id != 0 && !empty($id) && is_numeric($id)){

            require_once('model/bd/contato.php');
            require_once('modulo/config.php');

            if(deleteContato($id)){

                if($foto != null ){

                    unlink(DIRETORIO_FILE_UPLOAD.$foto);

                    return true;

                }else{
                    return true;
                }
                 
            }else{

                return array('idErro' => 3,
                                'message' => 'o banco de dados nao pode excluir o regristo');
            }


        }else{

            return array('idErro' => 4,
                        'message' => 'nao é possivel excluir o registro sem um id valido');
        }
        
}
    
    


function listarContatos(){
        
        require_once('model/bd/contato.php');
        
        $dados = selectAllContatos();
    
        if(!empty($dados))
            
            return $dados;

        else

            return false;
        
}



function buscarContatos($id){
        
        if($id != 0 && !empty($id) && is_numeric($id)){
            require_once('model/bd/contato.php');

            $dadosarrey = selectByidContatos($id);

            if(!empty($dadosarrey)){
                  return $dadosarrey;
            }else{
                return false;
            }

        }else{
            return array('idErro' => 4,
            'message' => 'nao é possivel buscar o registro sem um id valido');
           
        }

}