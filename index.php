<?php

//($form) = variavel para saber se o conteudo do formulario vai ser para editar(atualiza) ou inserir
// caso seja inserir o $form vai para o action do formulario e inseri o novo dado
// se os dados ja existirem entao o btn é editar ai ele entre na estrutura de repeticao e excuta o script de editar;
$form = (string)"router.php?componente=contatos&action=inserir";


if(session_status()){                                     // verifica se a variavel de sessao esta ativa 
    if(!empty($_SESSION['dadosContatos'])){              // verifica se a variavel de sessao nao esta vazia 
                    
        $id=       $_SESSION['dadosContatos']['id'];
        $nome=     $_SESSION['dadosContatos']['Nome'];
        $telefone= $_SESSION['dadosContatos']['Telefone'];
        $celular=  $_SESSION['dadosContatos']['Celular'];
        $email=    $_SESSION['dadosContatos']['Email'];
        $obs=      $_SESSION['dadosContatos']['Obs'];


        $form = "router.php?componente=contatos&action=editar&id=".$id;
        unset($_SESSION['dadosContatos']);  // destroi uma variavel de sessao; 
        /*session_destroy(); destrou todo variavel de sessao do codigo intero*/ 
    }

     
  
}


?>

<!DOCTYPE>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title> Cadastro </title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
      


    </head>
    <body>
       
        <div id="cadastro"> 
            <div id="cadastroTitulo"> 
                <h1> Cadastro de Contatos </h1>
                
            </div>
            <div id="cadastroInformacoes">
                <form  action="<?=$form?>" name="frmCadastro" method="post" >
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Nome: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="text" name="txtNome" value="<?=@$nome?>" placeholder="Digite seu Nome" maxlength="100">
                        </div>
                    </div>
                                     
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Telefone: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="tel" name="txtTelefone" value="<?=isset($telefone)?$telefone:null ?>">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Celular: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="tel" name="txtCelular" value="<?=isset($celular)?$celular:null?>">
                        </div>
                    </div>
                   
                    
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Email: </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <input type="email" name="txtEmail" value="<?=isset($email)?$email:null?>">
                        </div>
                    </div>
                    <div class="campos">
                        <div class="cadastroInformacoesPessoais">
                            <label> Observações:  </label>
                        </div>
                        <div class="cadastroEntradaDeDados">
                            <textarea name="txtObs" cols="50" rows="7"><?=isset($obs)?$obs:null?></textarea>
                        </div>
                    </div>
                    <div class="enviar">
                        <div class="enviar">
                            <input type="submit" name="btnEnviar" value="Salvar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="consultaDeDados">
            <table id="tblConsulta" >
                <tr>
                    <td id="tblTitulo" colspan="6">
                        <h1> Consulta de Dados.</h1>
                    </td>
                </tr>
                <tr id="tblLinhas">
                    <td class="tblColunas destaque"> Nome </td>
                    <td class="tblColunas destaque"> Celular </td>
                    <td class="tblColunas destaque"> Email </td>
                    <td class="tblColunas destaque"> Opções </td>
                </tr>
                
               <?php
                 require_once('controller/ControllerContatos.php');
                 $listcontatos = listarContatos();
                 
                foreach ($listcontatos as $item){
                  
                
            ?>
                <tr id="tblLinhas">
                    <td class="tblColunas registros"><?=$item['Nome']?></td>
                    <td class="tblColunas registros"><?=$item['Celular']?></td>
                    <td class="tblColunas registros"><?=$item['Email']?></td>
                   
                    <td class="tblColunas registros">

                            <a href="router.php?componente=contatos&action=buscar&id=<?=$item['id']?>" href="">
                            <img src="img/edit.png" alt="Editar" title="Editar" class="editar">
                            </a>
                            
                            <a onclick=" return confirm('Deseja excluir esse item')" href="router.php?componente=contatos&action=deletar&id=<?=$item['id']?>">
                            <img src="img/trash.png" alt="Excluir" title="Excluir" class="excluir">
                            </a>  

                            <img src="img/search.png" alt="Visualizar" title="Visualizar" class="pesquisar">
                    </td>
                </tr>
            <?php
              }
            ?>
            </table>
        </div>
    </body>
</html>