<script>
    $(function(){
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        
        
        $("#formTerminais").ajaxForm(function() {
            loadDiv("#contImportacoes","/importacoes/config_terminais/");
        });
        
        
        $("#FormLocal").autocomplete({
            source: function(request, response){
                $.ajax({
                    url: "http://ws.geonames.org/searchJSON",
                    dataType : "jsonp",
                    data: {
                        featureClass: "P",
                        style: "full",
                        maxRows: 4,
                        name_startsWith: request.term
                    },
                    success: function( data ){
                        response( $.map( data.geonames, function (item){
                            return {
                                label: item.name + (item.adminName1 ? ", " + item.adminName1 : "") + ", " + item.countryName,
                                value: item.name + (item.adminName1 ? ", " + item.adminName1 : "") + ", " + item.countryName
                            }
                        }));
                    }
                });
            },
            minLength: 2
        });
    });
</script>
<?php
switch ($op) {
    default :
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->caption("Terminais Disponíveis")
                ->alternate("grid_claro", "grid_escuro")
                ->hidden(array("id", "created", "modified","conf_custos"))
                ->col("editar")->title("")->cell("editar.gif", "javascript:loadDiv('#contImportacoes','/importacoes/config_terminais/cadastrar/{id}');")
                ->col("deletar")->title("")->cell("deletar.png", "javascript:delAjax('/importacoes/config_terminais/deletar/{id}','contImportacoes','/importacoes/config_terminais/grid');");
        echo $html->link("Novo", "javascript:loadDiv('#contImportacoes','/importacoes/config_terminais/cadastrar');", array("class" => "botao"));
        break;
    case "grid_externo":
         echo $xgrid->start($dadosGrid)
                ->caption("Terminais Disponíveis")
                ->alternate("grid_claro", "grid_escuro")
                ->hidden(array("id", "local","created", "modified","conf_custos"))
                ->col("editar")->title("")->cell("editar.png","javascript:loadDiv('#contImportacoes','/importacoes/config_custosTerminais/grid/{id}');");
        break;
    case "cadastrar":
        echo $form->create("", array("id" => "formTerminais"));
        echo $form->input("nome", array("div" => "Form50por FormLeft", "value" => $dadosForm["nome"]));
        echo $form->input("local", array("label" => "Localização", "div" => "Form50por FormRight", "value" => $dadosForm["local"]));
        echo $form->close("Salvar", array("class" => "botao", "id" => "salvaTerminal"));
        break;
}
?>
