<script>
    $(function(){
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
    });
</script>
<?php
$status = array("Encerrado","Em aberto");
$processos = array("Orçamento","Pedido");
switch ($op) {
    default :
    case "grid":
        echo $xgrid->start($dadosGrid)
            ->caption("Status de Processos")
            ->alternate("grid_claro","grid_escruro")
            ->hidden(array("id","corDiv","corTexto","created","modified"))
            ->col("status")->conditions($status)
            ->col("tipoPedido")->title("Processo")->conditions($processos)
            ->col("dashboard")->conditions($bool)
            ->col("editar")->title("")->cell("editar.gif", "javascript:loadDiv('#contImportacoes','/importacoes/configStatus/cadastrar/{id}');")
            ->col("deletar")->title("")->cell("deletar.png", "javascript:delAjax('/importacoes/configStatus/deletar/{id}','contImportacoes','/importacoes/configStatus/grid');");
        echo $html->link("Novo","javascript:loadDiv('#contImportacoes','/importacoes/configStatus/cadastrar');",array("class"=>"botao"));
        break;
    
    case "cadastrar":
        echo $form->create();
        echo $form->input("nome",array("div"=>"Form100por","value"=>$dadosForm["nome"]));
        echo $form->input("corTexto",array("label"=>"Cor do Texto","div"=>"Form50por FormLeft","value"=>$dadosForm["corTexto"]));
        echo $form->input("corDiv",array("label"=>"Cor da Caixa","div"=>"Form50por FormRight","value"=>$dadosForm["corDiv"]));
        echo $html->tag("br","",array(),false,true);
        echo $form->input("tipoPedido",array("type"=>"select","options"=>$processos,"label"=>"Tipo de Processo","div"=>"Form50por FormLeft","value"=>$dadosForm["tipoPedido"]));
        echo $form->input("dashboard",array("type"=>"select","options"=>$bool,"label"=>"Exibe no Dashboard","div"=>"Form50por FormRight","value"=>$dadosForm["dashboard"]));
        echo $html->tag("br","",array(),false,true);
        echo $form->input("status",array("type"=>"select","options"=>$status,"label"=>"Status do Processo","div"=>"Form100por","value"=>$dadosForm["status"]));
        echo $html->tag("br","",array(),false,true);
        
        echo $form->close("Salvar",array("class"=>"botao"));
        break;
}
?>
