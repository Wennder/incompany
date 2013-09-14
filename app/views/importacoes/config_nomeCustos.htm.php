<script>
    $(function(){
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        
        $("#formNomeCustos").ajaxForm(function(data) {
            alert(data);
            loadDiv("#contImportacoes","/importacoes/config_nomeCustos/");
        });
    });
</script>
<?php
$optMultiplicacao = array("Não Multiplica", "X Contâiner", "X Carretas");
switch ($op) {
    default :
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->caption("Configuração de Possíveis Custos")
                ->alternate("grid_claro", "grid_escuro")
                ->hidden(array("created", "modified", "id"))
                ->col("multiplicacao")->conditions($optMultiplicacao)->title("Multiplicação")
                ->col("editar")->title("")->cell("editar.gif", "javascript:AbreJanela('/importacoes/config_nomeCustos/cadastrar/{id}',400,250,'Editar Custo',null,true);")
                ->col("deletar")->title("")->cell("deletar.png", "javascript:delAjax('/importacoes/config_nomeCustos/deletar/{id}','contImportacoes','/importacoes/config_nomeCustos/grid');");
        echo $html->link("Novo", "javascript:loadDiv('#contImportacoes','/importacoes/config_nomeCustos/cadastrar');", array("class" => "botao"));
        break;

    case "cadastrar":
        echo $form->create("", array("id" => "formNomeCustos", "class" => "formee"));
        echo $form->input("nome", array("div" => "grid-12-12", "value" => $dadosForm["nome"]));
        echo $form->input("multiplicacao", array("type" => "select", "options" => $optMultiplicacao, "div" => "grid-12-12", "value" => $dadosForm["multiplicacao"]));
        echo $form->close("Salvar", array("class" => "formee-button"));
        break;
}
?>
