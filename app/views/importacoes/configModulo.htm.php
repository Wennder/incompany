<script>
    $(function(){
        $("#configImportacoes").ajaxForm(function(data){
           alert(data); 
        });
    })
</script>
<?php

echo $form->create("", array("class" => "formee","id"=>"configImportacoes"));
echo $html->openTag("div", array("class" => "container_16"));
//Caixa de Configuração do Aviso de Atracação
echo $html->openTag("div", array("class" => "grid_8"));
echo $html->tag("h3", "Aviso de Atracação", array("class" => "title"));

echo $form->input("cfg1",array("type"=>"select","options"=>array_range(0,60),"div"=>"grid-3-12","label"=>"Dias","value"=>$dadosForm["cfg1"]));
echo $form->input("cfg2",array("type"=>"select","options"=>$layoutEmailAtracacao,"div"=>"grid-9-12","label"=>"Mensagem para Envio","value"=>$dadosForm["cfg2"]));

echo $html->closeTag("div");

//Caixa de Configuração LOCAWEB EMAIL MARKETING
//echo $html->openTag("div",array("class"=>"grid_8"));
//echo $html->tag("h3","",array("class"=>"title"));
//echo $html->closeTag("div");

echo $html->closeTag("div");
echo $form->close("Salvar", array("class" => "formee-button"));
?>