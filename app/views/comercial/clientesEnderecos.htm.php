<script>
    $(function(){
        $("button,.botao, inputsubmit, inputbutton, button", "html").button();
        $("input:text").setMask();
        $("#estadoEndereco").change(function(){
                $("#FormCidade").load("/integracao/options/sys_municipios/nome/<?php echo "0" . "/uf/" ?>"+$("#estadoEndereco").val());
            });
        $("#cepEndereco").change(function(){
            cep = $("#cepEndereco").val().replace("-", "");
            $.getJSON("/integracao/cep/"+cep, function(consulta){
                if(consulta.resultado == 0){
                    alert("CEP Não Encontrado!");
                }else{
                    $("#logradouroEndereco").val(consulta.tipo_logradouro+" "+consulta.logradouro);
                    $("#bairroEndereco").val(consulta.bairro);
                }
            });
        });
        $("#formEnderecos").ajaxForm(function(data){
            alert(data);
            loadDiv("#gridEnderecos","/comercial/clientesEnderecos/grid/<?php echo $idCliente."/" ?>");
        });
        $("#FormCidade").load("/integracao/options/sys_municipios/nome/<?php echo (empty($dadosForm["cidade"])) ? "0" : $dadosForm["cidade"] . "/uf/" . $dadosForm["estado_id"]; ?>");
 
    });
</script>

<?php
$optTiposEndereco = array(
    "-1" => "Selecione",
    "1" => "Principal",
    "2" => "Cobrança",
    "3" => "Entrega",
    "9" => "Outro - Detralhar"
);
switch ($op) {
    default:
    case "grid":
        echo $xgrid->start($dadosGrid)
            ->caption("Endereços")
            ->alternate("grid_claro","grid_escuro")
            ->hidden(array("id","cliente_id","created","modified","cep","pais","complemento","bairro","cidade","nro"))
            ->col("logradouro")->cell("{logradouro},{nro} - {complemento} - {bairro} - {cep}")->title("Endereço")
            ->col("tipoEndereco")->title("Tipo")->conditions($optTiposEndereco)
            ->col("obsEndereco")->title("Obs")
            ->col("municipio")->cellArray("nome")
            ->col("estado_id")->conditions($optionsEstados)->title("UF")
            ->col("editar")->title("")->cell("editar.png","javascript:AbreJanela('/comercial/clientesEnderecos/cadastrar/{cliente_id}/{id}', 500, 350, 'Cadastrar Endereço', null, true);")
        ->col('deletar')->title("")->cell("deletar.png", "javascript:delAjax('/comercial/clientesEnderecos/deletar/{cliente_id}/{id}','gridEnderecos','/comercial/clientesEnderecos/grid/{cliente_id}')");
            ;
        break;
    case "cadastrar":
        echo $form->create("", array("id"=>"formEnderecos","class" => "formee"));
        echo $form->input("tipoEndereco", array("type" => "select", "label" => "Tipo", "options" => $optTiposEndereco, "value" => $dadosForm["tipoEndereco"], "div" => "grid-4-12"));
        echo $form->input("obsEndereco", array("label" => "Obs", "value" => $dadosForm["obsEndereco"], "div" => "grid-8-12"));
        echo $form->input("cep", array("label" => "CEP","id"=>"cepEndereco", "value" => $dadosForm["cep"], "alt" => "cep", "div" => "grid-3-12"));
        echo $form->input("logradouro", array("div" => "grid-9-12","id"=>"logradouroEndereco", "value" => $dadosForm["logradouro"]));
        echo $form->input("nro", array("div" => "grid-2-12", "value" => $dadosForm["nro"]));
        echo $form->input("complemento", array("div" => "grid-7-12", "value" => $dadosForm["complemento"]));
        echo $form->input("bairro", array("div" => "grid-3-12","id"=>"bairroEndereco", "value" => $dadosForm["bairro"]));
        echo $form->input("estado_id", array("id"=>"estadoEndereco","type" => "select", "label" => "Estado", "options" => $optionsEstados, "div" => "grid-2-12", "value" => $dadosForm["estado_id"]));
        echo $form->input("cidade", array("type" => "select", "label" => "Cidade", "div" => "grid-10-12", "options" => array("Selecione o Estado"), "value" => $dadosForm["cidade"]));
        echo $form->close("Salvar", array("class" => "botao formee-button"));

        break;
}
?>