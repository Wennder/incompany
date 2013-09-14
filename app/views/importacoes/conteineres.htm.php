<script>
    $(function(){
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        
        $("#formConteineres").ajaxForm(function(){
            alert("Adicionado com sucesso");
            loadDiv("#gridConteineres","/importacoes/conteineres/grid/<?php echo $processo; ?>/");
        });
        
        $("#importConteiner").ajaxForm(function(data){
            $("#ctrs").html(data);
        });
        
        $("#dadosCtr").ajaxForm(function(data){
            alert(data);
            loadDiv("#gridConteineres","/importacoes/conteineres/grid/<?php echo $processo; ?>/");
        });
    });
</script>
<?php
$optContainer = array("Selecione...", "Normal 20'", "Normal 40'", "Normal 40 HC", "Reefer 20'", "Reefer 40'", "Reefer 40 HC", "20' Insulado", "40' Insulado", "Flat Pack 20'", "Flat Rack 40'", "Graneleiro - Dry 201 - HC", "Tanque de 20'");
switch ($op) {
    default :
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->alternate("grid_claro", "grid_escuro")
                ->hidden(array("id", "owner", "processo","transportadora_id", "agenteCarga", "modificacaoFinal", "created", "modified"))
                ->col("tipoConteiner")->conditions("tipoConteiner", $optContainer)->title("Tipo")
                ->col("transportadora")->cellArray("nomeFantasia")->title("Armador")
                ->col("editar")->title("")->cell("editar.png", "javascript:AbreJanela('/importacoes/conteineres/cadastrar/{processo}/{id}',440,210,'Editar Contêiner',0,true);")
                ->col("deletar")->title("")->cell("deletar.png", "javascript:delAjax('/importacoes/conteineres/deletar/{processo}/{id}','gridConteineres', '/importacoes/conteineres/grid/{processo}/');");
        break;
    case "cadastrar":
        echo $form->create("", array("id" => "formConteineres", "class" => "formee"));
        echo $form->input("transportadora_id", array("id" => "optAgentes", "label" => "Armador", "type" => "select", "options" => $optTransportadoras, "div" => "grid-12-12", "value" => $dadosForm["transportadora_id"]));
        echo $form->input("numero", array("label" => "Número", "div" => "grid-6-12", "value" => $dadosForm["numero"]));
        echo $form->input("lacre", array("label" => "Lacre", "div" => "grid-6-12", "value" => $dadosForm["lacre"]));
        echo $form->input("tipoConteiner", array("label" => "Tipo", "type" => "select", "options" => $optContainer, "value" => $dadosForm["tipoConteiner"], "div" => "grid-12-12"));
        echo $form->close("Salvar", array("class" => "botao grid-3-12"));
        break;
    case "importar":
        echo $html->openTag("div",array("id"=>"ctrs"));
        if(!empty($optDocumentos)){
        $documentos = array(
            $optDocumentos["nMaster"] => "Master - {$optDocumentos["nMaster"]}",
            $optDocumentos["nHouse"] => "House - {$optDocumentos["nHouse"]}",
            $optDocumentos["codRastreio"] => "Booking - {$optDocumentos["codRastreio"]}",
        );
        }else{
            $documentos = array(
                ""=>"Nenhum Numero de Documento Encontrado"
            );
        }
        echo $form->create("", array("class" => "formee","id"=>"importConteiner"));

        echo $form->input("armador", array("type" => "select","options"=>$optTransportadoras, "div" => "grid-4-12", "label" => "Armador", "id" => "optAgentes"));
        echo $form->input("documento", array("type" => "select", "options" => $documentos, "div" => "grid-4-12", "label" => "Número do Documento"));

        echo $form->close("Buscar Conteineres");
        echo $html->tag("hr", "", array(), true);
        if (count($dadosGrid) > 0) {
            echo $form->create("", array("class" => "formee", "id"=>"dadosCtr"));
            $i = 0;
            foreach ($dadosGrid as $dadosForm) {
                echo $form->input("transportadora_id[$i]", array("type" => "hidden", "value" => $armador));
                echo $form->input("processo[$i]", array("type" => "hidden", "value" => $processo));
                echo $form->input("numero[$i]", array("label" => "Número", "div" => "grid-3-12", "value" => $dadosForm["container"]));
                echo $form->input("lacre[$i]", array("label" => "Lacre", "div" => "grid-4-12", "value" => $dadosForm["lacre"]));
                echo $form->input("tipoConteiner[$i]", array("label" => "Tipo", "type" => "select", "options" => $optContainer, "div" => "grid-4-12"));
                $i++;
            }
            echo $form->close("Salvar");
        } else {
            echo $html->printWarning("Nenhum Conteiner Encontrado, Verifique os Dados");
        }
        echo $html->closeTag("div");
        break;
}
?>
