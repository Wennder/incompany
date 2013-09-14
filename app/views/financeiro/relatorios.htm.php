<?php
switch ($op) {
    case "movimentoReembolso":
        echo $html->script("/grafico/highcharts");
        echo $html->script("/grafico/gray");
        echo $html->script("/grafico/exporting");
        echo $html->script("/grafico/scripts");
        ?>
        <script>
            jQuery(document).ready(function() {
                //Gráfico de barras principal (gastos no ano e como)
                var chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'linhaAno',
                        defaultSeriesType: 'column'
                    },
                    title: {
                        text: 'Valores Pagos em Reembolsos'
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        categories: [
        <?php
        $i = 0;
        foreach ($dadosGrafico as $dado) {
            echo "'" . $date->month($dado["mes"]) . "/" . $dado["ano"] . "'";
            if ($i < count($dadosGrafico)) {
                echo ",";
            }
            $i++;
        }
        ?>
                                    ]
                                },
                                yAxis: {
                                    min: 0,
                                    title: {
                                        text: 'Valores Pagos (R$)'
                                    }
                                },
                                legend: {
                                    layout: 'vertical',
                                    backgroundColor: Highcharts.theme.legendBackgroundColor || '#FFFFFF',
                                    align: 'left',
                                    verticalAlign: 'top',
                                    x: 100,
                                    y: 70,
                                    floating: true,
                                    shadow: false
                                },
                                tooltip: {
                                    formatter: function() {
                                        return ''+
                                            this.x +': R$ '+ this.y;
                                    }
                                },
                                plotOptions: {
                                    column: {
                                        pointPadding: 0.2,
                                        borderWidth: 0
                                    }
                                },
                                series: [
        <?php
        $i = 0;
        foreach ($dadosPorMotivo as $dado) {
            echo "{";
            echo "name: '" . $dado["financeiro_motivodespesa"]["nome"] . "',";
            echo "data:[";
            $valores = $assistec->custosReembolsoMes($dado["motivodespesa_id"]);
            echo implode(",", $valores);
            echo "]";
            if ($i < count($dadosPorMotivo)) {
                echo "},";
            } else {
                echo "}";
            }
            $i++;
        }
        ?>
                                    ]
                                });

                                //Gráfico de Tipos mais Utilizados
                                chart = new Highcharts.Chart({
                                    chart: {
                                        renderTo: 'pieMotivos',
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false
                                    },
                                    title: {
                                        text: 'Motivos Utilizados'
                                    },
                                    tooltip: {
                                        formatter: function() {
                                            return '<b>'+ this.point.name +'</b>: R$ '+ this.y;
                                        }
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: false
                                            },
                                            showInLegend: true
                                        }
                                    },
                                    series: [{
                                            type: 'pie',
                                            name: 'Browser share',
                                            data: [
        <?php
        $i = 0;
        foreach ($dadosPorMotivo as $dado) {
            echo "['{$dado["financeiro_motivodespesa"]["nome"]}', " . number_format($dado["valor"], 2, ".", "") . "]";
            if ($i < count($dadosPorMotivo)) {
                echo ",";
            }
            $i++;
        }
        ?>
                                ]
                            }]
                    });
                    //Gráfico de Motivos mais utilizados
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'pieTipos',
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false
                        },
                        title: {
                            text: 'Tipos Utilizados'
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b>'+ this.point.name +'</b>: R$'+ this.y;
                            }
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                showInLegend: true
                            }
                        },
                        series: [{
                                type: 'pie',
                                name: 'Browser share',
                                data: [
        <?php
        $i = 0;
        foreach ($dadosPorTipo as $dado) {
            echo "['{$dado["tipodespesa"]["nome"]}', " . number_format($dado["valor"], 2, ".", "") . "]";
            if ($i < count($dadosPorTipo)) {
                echo ",";
            }
            $i++;
        }
        ?>
                                ]
                            }]
                    });

                    //Gráfico de Motivos mais utilizados
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'pieGerente',
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false
                        },
                        title: {
                            text: 'Valores Aprovados por Gerente'
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b>'+ this.point.name +'</b>: R$'+ this.y;
                            }
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                showInLegend: true
                            }
                        },
                        series: [{
                                type: 'pie',
                                name: 'Browser share',
                                data: [
        <?php
        $i = 0;
        foreach ($dadosPorGerente as $dado) {
            echo "['{$funcionarios[$dado["gerente"]]}', " . number_format($dado["valor"], 2, ".", "") . "]";
            if ($i < count($dadosPorTipo)) {
                echo ",";
            }
            $i++;
        }
        ?>
                                ]
                            }]
                    });

                });
        </script>
        <div id="linhaAno" style="width: 100%;"></div>
        <div id="pieTipos" style="width: 100%; margin-top:10px;"></div>
        <div id="pieMotivos" style="width: 100%; margin-top:10px;"></div>
        <div id="pieGerente" style="width: 100%; margin-top:10px;"></div>

        <?php
        break;
    case "selecionaDataLoteReembolso":
        ?>
        <script>
            $(function() {
                $("#FormData").datepicker({"dateFormat":"yy-mm-dd"});
                $("button,.botao, input:submit, input:button, button", "html").button();
            });
        </script>
        <?php
        echo $form->create("");
        echo $html->openTag("center");
        echo $form->input("data", array());
        echo "<br/>";
        
        echo $form->close("Gerar");
        echo $html->closeTag("center");
        break;
    case "impressaoLoteReembolso":
        echo $html->div("Lote de pagamento", array("class" => "titulo"));
        foreach ($dadosRelatorio as $relatorio) {
            $conteudoPessoal = "<b>Nome: </b>" . $relatorio["rh_funcionarios"]["nome"] . "<br/>";
            $conteudoPessoal.= "<b>Endereco: </b>" . $relatorio["rh_funcionarios"]["endereco"];
            $conteudoPessoal.= "<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            $conteudoPessoal.= $relatorio["rh_funcionarios"]["cep"] . " - " . $relatorio["rh_funcionarios"]["cidade"] . "/" . $optionsEstados[$relatorio["rh_funcionarios"]["estado"]];
            $conteudoPessoal.= "<br/>";
            $conteudoPessoal.= "<b>RG: </b>";
            $conteudoPessoal.= (!empty($relatorio["rh_funcionarios"]["rg"])) ? $relatorio["rh_funcionarios"]["rg"] : "Não Informado";
            $conteudoPessoal.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            $conteudoPessoal.= "<b>CPF: </b>";
            $conteudoPessoal.= (!empty($relatorio["rh_funcionarios"]["cpf"])) ? $relatorio["rh_funcionarios"]["cpf"] : "Não Informado";

            echo $html->div($conteudoPessoal, array("style" => "width:49%; float:left;"));

            $conteudoFinanceiro = "<b>Valor:</b>";
            $conteudoFinanceiro.= "R$ " . number_format($relatorio["valorTotal"], 2, ",", ".");
            $conteudoFinanceiro.= "<br/>";
            $conteudoFinanceiro.= "<b>Aut. Pgmto. por: </b>{$relatorio["financeiro_pago"]["nome"]}";
            $conteudoFinanceiro.= "<br/>";
            $conteudoFinanceiro.= "<b>Banco: </b>";
            $conteudoFinanceiro.= (!empty($relatorio["rh_funcionarios"]["financeiro_bancos"]["nome"])) ? $relatorio["rh_funcionarios"]["financeiro_bancos"]["nome"] : "Não Informado";
            $conteudoFinanceiro.= "<br/>";
            $conteudoFinanceiro.= "<b>Agência: </b>";
            $conteudoFinanceiro.= (!empty($relatorio["rh_funcionarios"]["agenciaPagamento"])) ? $relatorio["rh_funcionarios"]["agenciaPagamento"] : "Não Informado";
            $conteudoFinanceiro.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            $conteudoFinanceiro.= "<b>Conta: </b>";
            $conteudoFinanceiro.= (!empty($relatorio["rh_funcionarios"]["contaPagamento"])) ? $relatorio["rh_funcionarios"]["contaPagamento"] : "Não Informado";
            echo $html->div($conteudoFinanceiro, array("style" => "width:49%; float:right;padding-left:10px; border-left: 1px dashed #000000;"));
            echo $html->div("&nbsp", array("style" => "width:100%;padding-left:10px; border-bottom: 1px dashed #000000;"));
            echo "<br clear='all'>";
            echo "<br clear='all'>";
        }
        break;
}
?>