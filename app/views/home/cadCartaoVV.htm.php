<script>
     $("button,.botao, input:submit, input:button, button", "html").button();
      $("input:text").setMask();
</script>
<?php
    echo $form->create();
    echo $form->input("cartaoVV",array("value"=>$loggedUser["cartaoVV"],"label"=>"Número do Cartão", "class"=>"Form1Bloco", "alt"=>"cc"));
    echo $form->close("Salvar", array("class"=>"botao"));
    echo $html->openTag("p");
    echo "Esta aplicação possui somente a funcionalidade de agilizar sua consulta de saldo, nenhuma informação sobre saldo é gravada no sistema.<br/>Os dados informados neste formulário somente você poderá incluir, alterar e visualizar, nenhum colaborador da Empresa possui permissão para isso.";
    echo $html->closeTag("p");
?>
