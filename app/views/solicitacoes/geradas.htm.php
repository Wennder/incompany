<script type="text/javascript">
    $(function(){
        $("#filtro").dialog({
            autoOpen: false,
            modal:true,
            height:250,
            width:475
        });
    });
</script>
        <?php
        $this->pageTitle = "Solicitações :: Buscar Reembolsos";
       // pr($ocorrencias);
       echo $xgrid->start($ocorrencias)
                ->caption("Seus Reembolsos")
                ->col('usuario_id')->hidden()
                ->col('funcionario')->hidden()
                ->col("funcionario")->hidden()
                ->col('tipodespesa_id')->hidden()
                ->col("obsGerente")->hidden()
                ->col("financeiro_pago")->hidden()
                ->col("pagoPor")->hidden()
                ->col('gerente')->hidden()
                ->col('tipodespesa')->hidden()
                ->col('motivodespesa_id')->hidden()
                ->col('os')->hidden()
                ->col('km')->hidden()
                ->col('observacao')->hidden()
                ->col('nota')->hidden()
                ->col('ativo')->hidden()                
                ->col('status_id')->hidden()
                ->col('status')->hidden()
                ->col("id")->title("#")
                ->col("financeiro_motivodespesa")->title("Motivo de despesa")->cellArray("nome")
                ->col("rh_funcionarios")->hidden()
                ->col("created")->position(9)
                ->col('beneficiario')->hidden()
                ->col('valor')->currency('R$', 2, ',', '.')
                ->col('created')->date("d/m/Y")->title("Data")
                ->col('modified')->date("d/m/Y")->title("Ult. Modificação")
                ->col('Estado')->conditions('status_id', $statusDespesa)
                ->col('Ver')->title('')->cell("mais.png", "javascript:AbreJanela('/solicitacoes/verReembolso/{id}',450,450,'Pedido de Reembolso nº {id}');")
                ->footer('valor')->sumReal() //Função desenvolvida com a finalide de fazer a soma de valores reais.
                ->noData('Nenhum Pedido Encontrado')
                ->alternate("grid_claro", "grid_escuro");
                
        echo $html->link("Nova Busca","javascript:AbreJanela('/solicitacoes/formBuscaReembolso',510,200,'Buscar Reembolso');",array("class"=>"botao"));
        ?>