<script type="text/javascript">
    $(function(){
       $("#editarPedido").dialog({
            autoOpen: false,
            modal:true,
            height:450,
            width:465
        });
             
    });
</script>
<?php
//pr($ocorrenciasAguardo);
        echo $xgrid->start($ocorrenciasAguardo)
                ->caption("Reembolsos Aguardando sua Aprovação")
                ->noData('Nenhum Pedido Encontrado')
                ->alternate("grid_claro", "grid_escuro")
                ->hidden(array("id","usuario_id","pagoPor","financeiro_pago","obsGerente","beneficiario","modified","tipodespesa","financeiro_motivodespesa","gerente","nota","tipodespesa_id","motivodespesa_id","os","km","observacao"))
                ->col('rh_funcionarios')->position(2)->cellArray("nome")->title("Beneficiário")
                ->col('valor')->currency('R$', 2, ',', '.')->position(3)
                ->col('created')->date("d/m/Y")->title("Data Solicitação")->position(1)
                ->col('status_id')->conditions('status_id', $statusDespesa)->title("Estado")
                ->col('Ver')->cell("mais.png", "javascript:popIn('editarPedido','/solicitacoes/verReembolso/{id}');")
                ->footer('valor')->sumReal()//Função desenvolvida com a finalide de fazer a soma de valores reais.
                ;
?>
<div id="editarPedido" title="Meus pedidos de reembolso"></div>