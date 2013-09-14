<script>
    $(function(){
                
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        
        $("#novaMoeda").ajaxForm(function(){
            alert("Cadastrado com Sucesso");
            loadDiv("#contAdmin","/admin/moedas/grid/");
        });
    });
</script>

<?php
switch ($op) {
    default:
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->caption("Moedas")
                ->alternate("grid_claro", "grid_escuro")
                ->col("id")->hidden()
                ->col("codigo")->title("ID. Internacional")
                ->col("nome")->title("Moeda")
                ->col("editar")->title("")->cell("editar.gif", "javascript:AbreJanela('/admin/moedas/cadastrar/{id}', 300, 160, 'Editar Moeda - {nome} ({codigo})', null, true);")
                ->col("deletar")->title("")->cell("deletar.png", "javascript:delAjax('/admin/moedas/deletar/{id}','contAdmin', '/admin/moedas/grid');");
        echo $html->link("Nova Moeda","javascript:AbreJanela('/admin/moedas/cadastrar/', 300, 160, 'Cadastrar Moeda', null, true);",array("class"=>"botao"));
        break;

    case "cadastrar":
        echo $form->create("", array("id" => "novaMoeda","class"=>"formee"));
        echo $form->input("nome", array("type" => "text", "label" => "Moeda", "div" => "grid-12-12", "value" => $dadosFormulario["nome"]));
        echo $form->input("simbolo", array("type" => "text", "label" => "Simbolo","div"=>"grid-6-12", "value" => $dadosFormulario["simbolo"]));
        echo $form->input("codigo", array("type" => "text", "label" => "ID. Internacional", "div" => "grid-6-12", "value" => $dadosFormulario["codigo"]));
        echo $form->close("Salvar", array("class" => "botao grid-3-12"));

        break;
}
?>