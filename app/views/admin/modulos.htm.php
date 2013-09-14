<script>
    $(function(){
        $("#formModulos").ajaxForm(function(data){
            alert(data);
            loadDiv("#contAdmin","/admin/modulos");
        });
    });
</script>
<?php
switch ($op) {
    case "cadastrar":
        echo $form->create("", array("class" => "formee", "id" => "formModulos"));
        echo $form->input("nome", array("div" => "grid-12-12", "value" => $dadosForm["nome"]));
        echo $form->input("url", array("label" => "URL", "div" => "grid-12-12", "value" => $dadosForm["url"]));
        echo $form->input("ativo", array("type" => "select", "options" => $bool, "div" => "grid-6-12","value"=>$dadosForm["ativo"]));
        echo $form->input("menuPrincipal", array("label"=>"Menu Principal","type" => "select", "options" => $bool, "div" => "grid-6-12","value"=>$dadosForm["menuPrincipal"]));
        echo $form->close("Salvar", array("class" => "formee-button"));
        break;
    default:
    case "grid":
        echo $html->printWarning("ALERTA: Área de EXTREMO IMPACTO em caso de modificações.","error");
        echo $xgrid->start($dadosGrid)
                ->caption("Módulos do Sistema")
                ->alternate("grid_claro", "grid_escuro")
                ->hidden(array("id_modulo", "created"))
                ->col("url")->title("URL")
                ->col("ativo")->conditions($bool)
                ->col("menuPrincipal")->title("Menu")->conditions($bool)
                ->col("modified")->title("Ult. Modificação")->date("d/m/Y H:i:s")
                ->col("who")->title("Modificado Por")
                ->col("editar")->title("")->cell("editar.png","javascript:AbreJanela('/admin/modulos/cadastrar/{id_modulo}',400,240,'Editar Módulo {nome}',null,true);");
        echo $html->link("Novo", "javascript:AbreJanela('/admin/modulos/cadastrar',400,240,'Cadastrar Módulo',null,true);");
        break;
}
?>
