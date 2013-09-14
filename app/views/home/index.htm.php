<?php
    switch($op){
        default:
        case "index":
            break;
        case "trocarSenha":
            foreach($validationErrors as $error){
                echo $html->printWarning($error,"error");
            }
            echo $form->create("",array("class"=>"formee"));
            echo $form->input("senhaAtual",array("type"=>"password","label"=>"Senha Atual","div"=>"grid-12-12"));
            echo $form->input("password",array("type"=>"password","label"=>"Nova Senha","div"=>"grid-12-12"));
            echo $form->input("confirmPassword",array("type"=>"password","label"=>"Confirme Nova Senha","div"=>"grid-12-12"));
            echo $form->close("Salvar");
            break;
    }
?>