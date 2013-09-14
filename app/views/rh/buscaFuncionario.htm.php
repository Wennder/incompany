<script>
    $("button,.botao, input:submit, input:button, button", "html").button();
</script>
<?php
echo $form->create("/rh/gridFuncionario");
echo $form->input("nome",array("class"=>"Form2Blocos","label"=>"Nome ou Sobrenome ou Mínimo 3 letras do Nome"));
echo $form->input("estado",array("type"=>"select","class"=>"Form2Blocos","options"=>array("Indiferente","Ativo","Desativado")));
echo $html->openTag("br",array(),true);
echo $html->openTag("center");
echo $form->close("Buscar");
echo $html->closeTag("center");
?>
