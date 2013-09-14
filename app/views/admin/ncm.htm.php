<script>
    $(function(){
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        
        $("#cadNcm").ajaxForm(function(){
            alert("Cadastrado com Sucesso!");
            loadDiv("#contAdmin","/admin/ncm/grid/");
        });
        
        $("#buscaNcm").ajaxForm(function(data){
            $("#contAdmin").html(data);
        });
        
    });
</script>
<?php
switch ($op) {
    default :
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->alternate("grid_claro", "grid_escuro")
                ->caption("NCMs Cadastrados")
                ->col("id")->hidden()
                ->col("ncm")->title("NCM")
                ->col("aliqIi")->title("II")
                ->col("aliqIpi")->title("IPI")
                ->col("aliqPis")->title("PIS")
                ->col("aliqCofins")->title("COFINS")
                ->col("aliqIcmsSt")->title("ICMS ST")
                ->col("unidadeMedida")->conditions('unidadeMedida', $unidadesMedida)
                ->col("modified")->title("Atualizado em")->date("d/m/Y H:i:s")
                ->col("who")->title("Por")
                ->col("acao")->title("")->cell("editar.png", "javascript:AbreJanela('/admin/ncm/cadastrar/{id}', 300, 300, 'Editar NCM {ncm}', null, true);")
                ->col("acaoDeletar")->title("")->cell("deletar.png", "javascript:delAjax('/admin/ncm/deletar/{id}','contAdmin', '/admin/ncm/grid/');")
        ;
        break;
    case "cadastrar":
        echo $html->openTag("fieldset");
        if (empty($dadosForm)) {
            $titulo = "Cadastrar Novo NCM";
        } else {
            $titulo = "Editar NCM " . $dadosForm["ncm"];
        }
        echo $html->tag("legend", $titulo);
        echo $form->create("", array("id" => "cadNcm", "class"=>"formee"));
        echo $form->input("ncm", array("value" => $dadosForm["ncm"], "alt" => "ncm", "label" => "NCM", "div" => "grid-12-12"));
        echo $form->input("aliqIi", array("value" => $dadosForm["aliqIi"], "alt" => "porcentagem", "label" => "II", "div" => "grid-3-12"));
        echo $form->input("aliqIpi", array("value" => $dadosForm["aliqIpi"], "alt" => "porcentagem", "label" => "IPI", "div" => "grid-3-12"));
        echo $form->input("aliqPis", array("value" => $dadosForm["aliqPis"], "alt" => "porcentagem", "label" => "PIS", "div" => "grid-3-12"));
        echo $form->input("aliqCofins", array("value" => $dadosForm["aliqCofins"], "alt" => "porcentagem", "label" => "COFINS", "div" => "grid-3-12"));
        echo $form->input("aliqIcmsSt", array("value" => $dadosForm["aliqIcmsSt"], "alt" => "porcentagem", "label" => "ICMS ST", "div" => "grid-4-12"));
        echo $form->input("unidadeMedida", array("type" => "select", "value" => $dadosForm["unidadeMedida"], "label" => "Unidade de Medida", "div" => "grid-8-12", "options" => $unidadesMedida));
        
        echo $form->close("Salvar", array("class" => "formee-button"));
        echo $html->closeTag("fieldset");
        break;

    case "buscar":
        echo $form->create("/admin/ncm/grid/",array("class"=>"formee","id"=>"buscaNcm"));
        echo $form->input("ncm",array("class"=>"grid-12-12","alt"=>"ncm","label"=>"NCM"));
        echo $form->close("Buscar", array("class" => "botao grid-12-12"));
        break;
}
?>
