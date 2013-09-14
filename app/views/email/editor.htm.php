<?php
echo $html->tag("script", "CKEDITOR.replace('FormTexto',{toolbar:'Email',height:500});");
echo $form->create("", array("class" => "formee", "id" => "formEnvioProposta"));
echo $form->input("assunto", array("div" => "grid-12-12", "value" => $dadosForm["assunto"]));
//echo $form->input("ccRepresentante", array("type"=>"select","options"=>$bool,"div" => "grid-6-12","label"=>"Cópia para o Representante", "value" => $dadosForm["ccRepresentante"]));
echo $form->input("mensagem", array("type" => "textarea", "label" => false, "class" => "ckeditor", "div" => "grid-12-12", "value" => $dadosForm["mensagem"]));
echo $form->close(null);
?>
