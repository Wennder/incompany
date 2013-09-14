<?php
switch($op){
  case "email":
      echo $form->create("",array("class"=>"formee","id"=>"formConfig"));
      //Método de Envio
      echo $form->input("cfg1",array("type"=>"select","div"=>"grid-12-12","label"=>"Método de Envio","options"=>array("Selecione...","SMTP","SendMail","PHP - Mail"),"value"=>$dadosForm["cfg1"]));
      //Servidor
      echo $form->input("cfg2",array("label"=>"Servidor","div"=>"grid-12-12","value"=>$dadosForm["cfg2"]));
      //Usuário
      echo $form->input("cfg3",array("label"=>"Usuário","div"=>"grid-6-12","value"=>$dadosForm["cfg3"]));
      //Senha
      echo $form->input("cfg4",array("label"=>"Senha","div"=>"grid-6-12","value"=>$dadosForm["cfg4"]));
      //Limite Hora
      echo $form->input("cfg5",array("label"=>"Limite Envios / Hora","div"=>"grid-6-12","value"=>$dadosForm["cfg5"]));
      //Intervalo de minutos que o script roda
      echo $form->input("cfg6",array("label"=>"Intervalo Execução / Minutos","div"=>"grid-6-12","value"=>$dadosForm["cfg6"]));
      
      echo $form->close("Salvar");
      break;
  default:
  case "index":
      break;
}
?>