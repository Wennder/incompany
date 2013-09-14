<?php
$this->pageTitle = "Comercial :: Acompanhamento de Contratos";
echo $html->script("/grafico/highcharts");
echo $html->script("/grafico/themes/gray");
echo $html->script("/grafico/exporting");
echo $html->script("/grafico/scripts");
echo $this->element("/gadgets/comercialHome");
?>
<div class="CoDashContent">
    <div class="CoDashSup">
        <div class="CodashSupDir">
            <?php
            echo $xgrid->start($ativos)
                    ->caption("Meus Contratos Ativos")
                    ->noData('Nehum registro encontrado!')
                    ->hidden(array("id", "prestadora", "periodicidadePgto", "created", "modified", "inicio", "vencimento", "tipo", "gerente", "tipo_contrato"))
                    ->col("id_cliente")->hidden()
                    ->col("id_gerente")->hidden()
                    ->col("id_tipo")->hidden()
                    ->col("status")->hidden()
                    ->col("descricao")->hidden()
                    ->col("empresa")->hidden()
                    ->col("id")->title("Cd.")
                    ->col("cliente")->title("Cliente")->cellArray("nomeFantasia")->position(2)
                    ->col("valor")->currency()
                    ->col("vencimento")->title("Vencimento")->date("d/m/Y")
                    ->footer('valor')->sumReal()
                    ->alternate("grid_claro", "grid_escuro");
            ?>
        </div>
        <div class="CodashSupEsq">
            <?php
            echo $xgrid->start($aVencer)
                    ->caption("Contratos Proximos a Vencer")
                    ->noData('Nehum registro encontrado!')
                    ->hidden(array("id", "prestadora", "periodicidadePgto", "created", "modified", "inicio", "vencimento", "tipo", "gerente", "tipo_contrato"))
                    ->col("id_cliente")->hidden()
                    ->col("id_gerente")->hidden()
                    ->col("id_tipo")->hidden()
                    ->col("status")->hidden()
                    ->col("descricao")->hidden()
                    ->col("empresa")->hidden()
                    ->col("id")->title("Cd.")
                    ->col("cliente")->title("Cliente")->cellArray("nomeFantasia")->position(2)
                    ->col("valor")->currency()
                    ->col("vencimento")->title("Vencimento")->date("d/m/Y")
                    ->footer('valor')->sumReal()
                    ->alternate("grid_claro", "grid_escuro");
            ?>

        </div>
    </div>

    <div class="CoDashInf">
        <div class="CodashInfDir">
            <?php
            echo $xgrid->start($inativos)
                    ->caption("Meus Contratos Inativos/Cancelados")
                    ->noData('Nehum registro encontrado!')
                    ->hidden(array("id", "prestadora", "periodicidadePgto", "created", "modified", "inicio", "vencimento", "tipo", "gerente", "tipo_contrato"))
                    ->col("id_cliente")->hidden()
                    ->col("id_gerente")->hidden()
                    ->col("id_tipo")->hidden()
                    ->col("status")->hidden()
                    ->col("descricao")->hidden()
                    ->col("empresa")->hidden()
                    ->col("id")->title("Cd.")
                    ->col("cliente")->title("Cliente")->cellArray("nomeFantasia")->position(2)
                    ->col("valor")->currency()
                    ->col("vencimento")->title("Vencimento")->date("d/m/Y")
                    ->footer('valor')->sumReal()
                    ->alternate("grid_claro", "grid_escuro");
            ?>
        </div>
        <div class="CodashInfEsq">
            <?php
            echo $xgrid->start($clienteContrato)
                    ->caption("Clientes X Nº de Contratos")
                    ->noData('Nehum registro encontrado!')
                    ->hidden(array("id", "prestadora", "periodicidadePgto", "created", "modified", "inicio", "vencimento", "tipo", "gerente", "tipo_contrato"))
                    ->col("id_cliente")->title("Cd.Cliente")->position(1)
                    ->col("id_gerente")->hidden()
                    ->col("id_tipo")->hidden()
                    ->col("status")->hidden()
                    ->col("descricao")->hidden()
                    ->col("empresa")->hidden()
                    ->col("cliente")->title("Cliente")->cellArray("nomeFantasia")->position(2)
                    ->col("qtd")->title("Qtd.")->position(3)
                    ->alternate("grid_claro", "grid_escuro");
            ?>
        </div>
    </div>
</div>
<br clear="all">
<br clear="all">
