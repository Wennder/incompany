<script>
    $(function(){
        $("button,.botao, inputsubmit, inputbutton, button", "html").button();
        $("input:text").setMask();
        
        $("a.deletarGrid").click(function() {
            var objeto = $(this).parent("td").parent("tr");
            if(confirm("Tem certeza que deseja excluir esse Registro?")){
                $.get($(this).attr("href"),function(data){
                    if(data == "OK"){
                        objeto.remove();
                    }
                });
            }
            return false;
            
        });
        
        $("#FormEstado").change(function(){
                $("#FormMunicipioId").load("/integracao/options/sys_municipios/nome/<?php echo "0" . "/uf/" ?>"+$(this).val());
            });
        
        $("#FormMunicipioId").load("/integracao/options/sys_municipios/nome/<?php echo (empty($dadosForm["municipio_id"])) ? "0" : $dadosForm["municipio_id"] . "/uf/" . $dadosForm["estado"]; ?>");
        
        $("#cadAgente").ajaxForm(function(data){
            loadDiv('#contImportacoes','/importacoes/agentesCarga');
            $("#FormAgentecarga").load("/integracao/agenteCarga/");
            alert(data);
        });
    });
</script>

<?php
switch ($op) {
    case "cadastrar":
        echo $form->create("", array("class" => "formee", "id" => "cadAgente"));
        echo $form->input("razaoSocial", array("type" => "text", "label" => "Razão Social", "div" => "grid-12-12", "value" => $dadosForm["razaoSocial"]));
        echo $form->input("nomeFantasia", array("type" => "text", "label" => "Nome Fantasia", "div" => "grid-12-12", "value" => $dadosForm["nomeFantasia"]));
        echo $form->input("pais", array("type" => "text", "label" => "Pais", "div" => "grid-4-12", "value" => $dadosForm["pais"]));
        echo $form->input("estado", array("type" => "select", "label" => "Estado", "options" => $optionsEstados, "div" => "grid-2-12", "value" => $dadosForm["estado"]));
        echo $form->input("municipio_id", array("type" => "select", "label" => "Cidade", "div" => "grid-6-12", "options" => array("Selecione o Estado"), "value" => $dadosForm["municipio_id"]));
        echo $form->input("tel", array("type" => "text", "alt" => "telefone", "label" => "Telefone", "div" => "grid-3-12", "value" => $dadosForm["tel"]));
        echo $form->input("fax", array("type" => "text", "alt" => "telefone", "label" => "Fax", "div" => "grid-3-12", "value" => $dadosForm["fax"]));
        echo $form->input("email", array("type" => "text", "label" => "E-mail", "div" => "grid-6-12", "value" => $dadosForm["email"]));
        echo $form->input("site", array("type" => "text", "label" => "Site", "div" => "grid-12-12", "value" => $dadosForm["site"]));
        echo $form->close("Salvar", array("class" => "botao grid-3-12"));
        break;

    default:
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->caption("Agentes de Carga")
                ->alternate("grid_claro", "grid_escuro")
                ->hidden(array("id"))
                ->col("razaoSocial")->title("Nome")
                ->col("editar")->title("")->cell("editar.png", "javascript:AbreJanela('/importacoes/agentesCarga/cadastrar/{id}', 500, 400, 'Cadastro de Agentes de Carga', null, true);")
                ->col("deletar")->title("")->cell("deletar.png", "/importacoes/agentesCarga/deletar/{id}", array("class" => "deletarGrid"));
        echo $html->link("Novo", "javascript:AbreJanela('/importacoes/agentesCarga/cadastrar', 500, 400, 'Cadastro de Agentes de Carga', null, true);", array("class" => "botao"));
        break;
}
?>
