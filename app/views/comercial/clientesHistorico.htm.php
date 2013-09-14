<script>
    $(function(){
        $("button,.botao, inputsubmit, inputbutton, button", "html").button();
        $("input:text").setMask();
        $("input[alt=date]").datepicker({"dateFormat":"dd-mm-yy"});

        $("#formHistorico").ajaxForm(function(){
            alert("Cadastrado com Sucesso");
            loadDiv("#gridHistorico","/comercial/clientesHistorico/grid/<?php echo $cliente_id ?>");
        }); 
    });
</script>

<?php
$canais = array(
    "Selecione...",
    "Telefone",
    "Email",
    "Email - Sistema"
);

$retornos = array(
    "Neutro",
    "Negativo",
    "Positivo"
);
switch ($op) {
    case "cadastrar":
        if(!empty($dadosForm)){
            $disabled["disabled"] = "1";
        }
        echo $form->create("", array("id" => "formHistorico", "class" => "formee"));
        echo $form->input("canal", array("type" => "select", "div" => "grid-4-12",$disabled, "options" => $canais, "value" => $dadosForm["canal"]));
        echo $form->input("retorno", array("type" => "select", "div" => "grid-4-12",$disabled, "options" => $retornos, "value" => $dadosForm["retorno"]));
        echo $form->input("remind", array("alt" => "date","label"=>"Lembrar em", "div" => "grid-4-12", "value" => $date->format("d-m-Y",$dadosForm["remind"])));
        echo $form->input("texto", array("label"=>"Perspectiva Comercial","type" => "textarea","div"=>"grid-12-12" ,"value" => $dadosForm["texto"],$disabled));
        echo $form->close("Salvar",array("class"=>"botao formee-button grid-3-12",$disabled));
        break;
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->caption("Contatos Realizados")
                ->alternate("grid_claro", "grid_escuro")
                ->hidden(array("texto","modified","cliente_id","id"))
                ->col("canal")->conditions($canais)
                ->col("retorno")->conditions($retornos)
                ->col("remind")->date("d/m/Y")->title("Lembrar em")
                ->col("created")->date("d/m/Y H:i")->title("Data")
                ->col("who")->title("Por")
                ->col("editar")->title("")->cell("editar.png","javascript:AbreJanela('/comercial/clientesHistorico/cadastrar/{cliente_id}/{id}',600,300,'Historico de Contatos',null,true);");
        echo $html->link("Adicionar", "javascript:AbreJanela('/comercial/clientesHistorico/cadastrar/{$cliente_id}',600,300,'Historico de Contatos',null,true);", array("class" => "botao grid-3-12"));
        break;
}
?>
