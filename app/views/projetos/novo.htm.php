<script type="text/javascript">
    $(function(){
         $("button,.botao, input:submit, input:button, button", "html").button();
         $("input:text").setMask();
         
     });
    
</script>
<?php

    echo $form->create("");

    echo $form->input("nome",
            array("type"=>"text","label"=>"Nome do projeto:",
                "class"=>"Form2Blocos","value"=>$dadosForm['nome']));

    echo $form->input("descricao",array(
        "type"=>"textarea","cols"=>"5",
        "rows"=>"10","label"=>"Descrição do projeto","class"=>"Form2Blocos",
        "value"=>$dadosForm['descricao']
    ));


    echo $form->input("valor", array(
       "type"=>"text", "class"=>"Form1Bloco",
        "div"=>"ladoalado" , "alt"=>"moeda", "value"=>$dadosForm['valor']
    ));

    echo $form->input("ativo", array(
        "type"=>"select","options"=>$bool,
        "class"=>"Form1Bloco","label"=>"Ativo:","value"=>$dadosForm['ativo']
    ));

    echo $form->input("responsavel",array(
        "type"=>"select", "class"=>"Form2Blocos", "label"=>"Responsável","options"=>$dadosResponsavel,"value"=>$dadosForm['responsavel']["id"]
    ));

    echo $form->input("cliente", array(
        "type"=>"select", "class"=>"Form2Blocos", "label"=>"Cliente","options"=>$dadosCliente, "value"=>$dadosForm['cliente']["id"]
    ));

    echo $form->input("inicio", array(
       "alt"=>"date",  "class"=>"Form1Bloco", "div"=>"ladoalado", "label"=>"Previsão de início:",
        "value"=>$date->format("d-m-Y",$dadosForm['inicio'])
    ));

    echo $form->input("termino", array(
       "alt"=>"date",  "class"=>"Form1Bloco", "label"=>"Previsão de Término:",
        "value"=>$date->format("d-m-Y",$dadosForm['termino'])
    ));


    echo $form->close("Enviar",
            array(
                "class"=>"ladoalado botao"
                ));

?>
