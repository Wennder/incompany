<script type="text/javascript">
    $(function(){
         $("button,.botao, input:submit, input:button, button", "html").button();
         $("input:text").setMask();
    });
</script>
<?php

switch ($op) {
    case "novo":
        echo $form->create("");
        echo $form->input("nome", array(
            "type" => "text", "label" => "Nome do milestone:", "class" => "Form2Blocos",
            "value" => $dadosForm['nome']
        ));
        echo $form->input("previsao",array("label"=>"Previsão","alt"=>"date"));
        echo $form->close("Enviar", array("class"=>"botao"));
        break;
}
?>