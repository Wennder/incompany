<script type="text/javascript" language="javascript">
    $(function(){
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
         $("#FormDoc").ajaxForm(function() {
            alert("Documento cadastrado com Sucesso!!!");
            $("#cadDocumento").dialog('close');
            return false;
        });
    });
</script>
<?php
switch ($op){
    case "novo":
        echo $form->create("",array("id"=>"FormDoc"));
echo $form->input("nome",array("type"=>"text","label"=>"Nome do Arquivo","class"=>"Form2Blocos","","value"=>$dadosUpload['nome']));
echo $form->input("descricao",array("type"=>"Descrição","label"=>"Descrição","class"=>"Form2Blocos","","value"=>$dadosUpload['descricao']));
echo $form->input("anexo", array("div" => "bgUpload", "type" => "file", "id" => "file-original", "label" => false, "onchange" => "document.getElementById('file-falso').value = this.value;"));
echo $form->close("Salvar");
break;

case "grid":
   // pr($gridDoc);
    echo $xgrid->start($gridDoc)
            ->caption("Documentos")
            ->col('id')->hidden()
            ->col('contrato_id')->hidden()
            ->col('nome')->title("Nome")
            ->col("descricao")->title("Descrição/Número")
            ->col("anexo")->hidden()
            ->col("created")->title("Envio")->date("d/m/Y")
            ->col("modified")->hidden()
            ->col("ver")->cell('mais.png','/{anexo}',array("target"=>"_blank"))
             ->col('Deletar')->conditions('id', array(
                ">=1" => array("label" => "deletar.png", "href" => "javascript:delAjax('/comercial/docsContrato/{contrato_id}/deletar/{id}/','gridDocumentos','/comercial/docsContrato/{contrato_id}/grid/')", "border" => "0")
                   ))
            ->noData('Nenhum Documento Cadastrado')
            ->alternate("grid_claro", "grid_escuro");
    break;
}
?>
