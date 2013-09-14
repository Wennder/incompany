<script>
    $(function(){
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input[alt=date]").datepicker({"dateFormat":"dd-mm-yy"});
        $("input:text").setMask();
        $("#documento").ajaxForm(function(data){
            loadDiv("#gridAnexos","/importacoes/uploadDocumento/grid/<?php echo $processo; ?>/");
            alert(data);
        });
    });
</script>
<?php
$visibilidade = array("Restrito", "Cliente");
$docs = array(
    "Selecione",
    "1"=>"Fatura Comercial",
    "2"=>"Fatura Proforma",
    "7"=>"Certificado de Origem",
    "8"=>"Certificado de Análise",
    "9"=>"Packing List",
    "3"=>"LI",
    "4"=>"DI",
    "5"=>"CI",
    "6"=>"NF-e",
    "99"=>"Outro"
);
switch ($op) {
    default :
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->alternate("grid_claro", "grid_escuro")
                ->hidden(array("id", "arquivo", "processo"))
                ->col("doc")->position(1)->conditions($docs)
                ->col("nro")->position(2)
                ->col("data")->date("d/m/Y")
                ->col("visibilidade")->conditions("visibilidade", $visibilidade)->position(9)
                ->col("descricao")->title("Descrição")
                ->col("created")->title("Envio")->date("d/m/Y H:i:s")
                ->col("who")->title("Enviado por")
                ->col("editar")->title("")->cell("editar.png", "javascript:AbreJanela('/importacoes/uploadDocumento/cadastrar/{processo}/{id}',440,275,'Documentos - Anexos',0,true);")
                ->col("deletar")->title("")->cell("deletar.png", "javascript:delAjax('/importacoes/uploadDocumento/deletar/{processo}/{id}','gridAnexos', '/importacoes/uploadDocumento/grid/{processo}/');");
        break;
    case "cadastrar":
        echo $form->create("", array("id" => "documento", "class" => "formee", "enctype" => "multipart/form-data"));
        echo (empty($dadosForm)) ? $form->input("file", array("type" => "file", "label" => "Arquivo", "div" => "grid-12-12")) : ((!empty($dadosForm["arquivo"]))?$html->link("Ver Arquivo", $dadosForm["arquivo"], array("class" => "botao grid-12-12", "target" => "_blank")):"");
        echo $form->input("doc", array("type" => "select", "label" => "Documento", "div" => "grid-4-12", "options" => $docs, "value" => $dadosForm["doc"]));
        echo $form->input("nro", array("label" => "Número", "div" => "grid-4-12", "value" => $dadosForm["nro"]));
        echo $form->input("data", array("label" => "Data", "alt" => "date", "div" => "grid-4-12", "value" => $date->format("d-m-Y", $dadosForm["data"])));
        echo $form->input("descricao", array("label" => "Descrição", "div" => "grid-8-12", "value" => $dadosForm["descricao"]));
        echo $form->input("visibilidade", array("type" => "select", "div" => "grid-4-12", "options" => $visibilidade, "value" => $dadosForm["visibilidade"]));
        echo $form->close("Enviar", array("class" => "botao grid-3-12"));
        break;
}
?>
