<?php
if ($op == "cad"){
?>
<div id="cadDoc" class="borda">
<script>
    $(function() {
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        $("#cadDocumento").ajaxForm(function() {
                alert("Documento cadastrado com Sucesso!!!");
            });
    });
</script>
    <?php
    if (!empty($donoDoc) && $donoDoc != 0) {
        echo $form->create("", array("enctype" => "multipart/form-data", "id" => "cadDocumento"));
        echo $form->input("users_id", array("type" => "hidden", "value" => $donoDoc));
        echo $form->input("file", array("type" => "file","size"=>"10", "label" => "Arquivo"));
        echo "<br>";
        echo $form->input("tipoDoc", array("type" => "select", "label" => "Tipo", "options" => $listaDoc, "class" => "Form1Bloco"));
        echo $form->input("desc", array("type" => "text", "label" => "Nº / Descrição", "class" => "Form1Bloco"));
        echo $form->close("Inserir", array("class" => "Form1Bloco botao"));
    } else {
        echo "<center>";
        echo "<div class='ui-widget-header'>Salve os dados para preencher essa etapa</div>";
        echo "</center>";
    }
    ?>
</div>
<?php
}else{
?>
<div id="gridCadastrados" class="borda">
<?php
    echo $xgrid->start($docsIn)
            ->caption("Documentos")
            ->col('id')->hidden()
            ->col('tipoDoc')->title('Documento')->conditions('tipoDoc', $listaDoc)->position(1)
            ->col("number")->title("Descrição/Número")
            ->col("file")->hidden()
            ->col("users_id")->hidden()
            ->col("created")->title("Envio")->date("d/m/Y h:i:s")
            ->col("Ver")->title('')->conditions('id', array(
                ">=1" => array("label" => "mais.png", "href" => "{file}", "border" => "0")
            ))
            ->col('Deletar')->title('')->conditions('id', array(
                ">=1" => array("label" => "deletar.png", "href" => "javascript:delAjax('/rh/delDocumento/{id}','gridDocumentos','/rh/cadDocumento/$donoDoc')", "border" => "0")
            ))
            ->noData('Nenhum Documento Cadastrado')
            ->alternate("grid_claro", "grid_escuro");
?>
</div>
<?php
}
?>