<script>
    $(function(){
                
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        
        $("#FormCidade").load("/integracao/options/sys_municipios/nome/<?php echo $dadosFormulario["cidade"] . "/uf/" . $dadosFormulario["estado_id"]; ?>");
                
        $("#FormEstadoId").change(function(){
            $("#FormCidade").load("/integracao/options/sys_municipios/nome/<?php echo "0" . "/uf/" ?>"+$("#FormEstadoId").val());
        });
        
        $.validator.setDefaults({
            submitHandler: function(){ 
                $("#novaEmpresa").ajaxSubmit(function(){
                    loadDiv("#contEstoque","/estoque/transportadoras");
                });
            }
        });
            
        $("#novaEmpresa").validate({
            rules: {
                tipoTransporte:{
                    required:true
                },
                razaoSocial: {
                    required: true

                },
                nomeFantasia: {
                    required: true

                },
                cidade: {
                    required: "Informe a Cidade!"

                },
                estado_id: {
                    required: "Informe o Estado!"

                }

            },
            messages: {
                tipoTransporte:{
                    required: "Informe o Tipo de Transporte"
                },
                razaoSocial: {
                    required:"Informe a Razão Social!"

                },
                nomeFantasia: {
                    required: "Informe o Nome Fantasia!"

                },
                cidade: {
                    required: "Informe a Cidade!"

                },
                estado_id: {
                    required: "Informe o Estado!"

                }
            }

        });
    });
</script>

<?php
switch ($op) {
    default:
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->caption("Transportadoras")
                ->alternate("grid_claro", "grid_escuro")
                ->noData("Nenhum registro encontrado")
                ->col("id")->hidden()
                ->col("cidade")->hidden()
                ->col("estado_id")->title("UF")->conditions($optionsEstados)->position(4)
                ->col("municipio")->title("Cidade")->cellArray("nome")->position(3)
                ->col("razaoSocial")->title("Razão Social")
                ->col("editar")->title("")->cell("editar.gif", "javascript:loadDiv('#contEstoque','/estoque/transportadoras/cadastrar/{id}');");
        break;

    case "cadastrar":
        echo $html->tag("h3", "Transportadora {$dadosFormulario["razaoSocial"]}", array("class" => "title"));
        echo $form->create("", array("id" => "novaEmpresa", "class" => "formee"));
        echo $html->openTag("fieldset", array("class" => "grid-3-12"));
        echo $html->tag("legend", "Categoria");
        echo $html->closeTag("legend");

        $rodoviario = strpos($dadosFormulario["tipotransporte"], "1");
        $maritimo = strpos($dadosFormulario["tipotransporte"], "2");
        $aereo = strpos($dadosFormulario["tipotransporte"], "3");
        $ferroviario = strpos($dadosFormulario["tipotransporte"], "4");

        if ($rodoviario > 0) {
            $rodoviario = true;
        }
        if ($maritimo > 0) {
            $maritimo = true;
        }
        if ($aereo > 0) {
            $aereo = true;
        }
        if ($ferroviario > 0) {
            $ferroviario = true;
        }

        echo $form->input("tipoTransporte[]", array("type" => "checkbox", "label" => "Rodoviário", "value" => "1", "checked" => $rodoviario));
        echo $form->input("tipoTransporte[]", array("type" => "checkbox", "label" => "Marítimo", "value" => "2", "checked" => $maritimo));
        echo $form->input("tipoTransporte[]", array("type" => "checkbox", "label" => "Aéreo", "value" => "3", "checked" => $aereo));
        echo $form->input("tipoTransporte[]", array("type" => "checkbox", "label" => "Ferroviário", "value" => "4", "checked" => $ferroviario));

        echo $html->closeTag("fieldset");

        echo $html->openTag("div", array("class" => "grid-9-12"));
        echo $form->input("razaoSocial", array("type" => "text", "label" => "Razão Social:", "div" => "grid-12-12", "value" => $dadosFormulario["razaoSocial"]));
        echo $form->input("nomeFantasia", array("type" => "text", "label" => "Nome Fantasia:", "div" => "grid-12-12", "value" => $dadosFormulario["nomeFantasia"]));
        echo $form->input("cnpj", array("type" => "text", "alt" => "cnpj", "label" => "CNPJ:", "div" => "grid-4-12", "value" => $dadosFormulario["cnpj"]));
        echo $form->input("ie", array("type" => "text", "label" => "IE:", "div" => "grid-4-12", "value" => $dadosFormulario["ie"]));
        echo $form->input("im", array("type" => "text", "label" => "Inscrição Municipal:", "div" => "grid-4-12", "value" => $dadosFormulario["im"]));
        echo $form->input("endereco", array("type" => "text", "label" => "Endereço", "div" => "grid-10-12", "value" => $dadosFormulario["endereco"]));
        echo $form->input("nro", array("type" => "text", "label" => "Número", "div" => "grid-2-12", "value" => $dadosFormulario["nro"]));
        echo $form->input("complemento", array("type" => "text", "label" => "Complemento:", "div" => "grid-5-12", "value" => $dadosFormulario["complemento"]));
        echo $form->input("cep", array("type" => "text", "label" => "Cep:", "alt" => "cep", "div" => "grid-3-12", "value" => $dadosFormulario["cep"]));
        echo $form->input("bairro", array("type" => "text", "label" => "Bairro", "div" => "grid-4-12", "value" => $dadosFormulario["bairro"]));
        echo $form->input("estado_id", array("type" => "select", "label" => "Estado", "options" => $optionsEstados, "div" => "grid-2-12", "value" => $dadosFormulario["estado_id"]));
        echo $form->input("cidade", array("type" => "select", "label" => "Cidade", "div" => "grid-6-12", "options" => array("Selecione o Estado"), "value" => $dadosFormulario["cidade"]));
        echo $form->input("pais", array("type" => "text", "label" => "Pais", "div" => "grid-4-12", "value" => $dadosFormulario["pais"]));
        echo $form->input("tel", array("type" => "text", "alt" => "telefone", "label" => "Telefone", "div" => "grid-3-12", "value" => $dadosFormulario["tel"]));
        echo $form->input("cel", array("type" => "text", "alt" => "telefone", "label" => "Fax", "div" => "grid-3-12", "value" => $dadosFormulario["cel"]));
        echo $form->input("email", array("type" => "text", "label" => "E-mail", "div" => "grid-6-12", "value" => $dadosFormulario["email"]));
        echo $form->input("site", array("type" => "text", "label" => "Site", "div" => "grid-12-12", "value" => $dadosFormulario["site"]));
        echo $form->input("integracao", array("type" => "text", "label" => "Integração", "div" => "grid-12-12", "value" => $dadosFormulario["integracao"]));
        echo $form->close("Salvar", array("class" => "botao grid-3-12"));
        echo $html->closeTag("div");

        break;
}
?>