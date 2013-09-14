<script>
    
    $(function(){
        $("button,.botao, inputsubmit, inputbutton, button", "html").button();
        $("input:text").setMask();
    
        $("a.deletarGrid").click(function() {
            var objeto = $(this).parent("td").parent("tr");
            if(confirm("Tem certeza que deseja excluir esse Registro?")){
                $.get($(this).attr("href"),function(data){
                    if(data == "OK"){
                        objeto.remove();
                    }
                });
            }
            return false;
            
        });
        $("input[alt=date]").datepicker({"dateFormat":"dd-mm-yy"});
        $("#FormComportamentoMercado").ajaxForm(function(data){
            alert(data);
        });
        
    });
    function sendForm(object, responseObject){
        $(object).ajaxSubmit(function(data){
            $(responseObject).html(data);
        });
    }
</script>
<?php
switch ($op) {
    default:
    case "grid":
        echo $form->create("/comercial/comportamentoMercado/grafico", array("class" => "formee", "id" => "formGrafico"));
        echo $form->input("estoqueCategoria1", array("type" => "select", "options" => $dadosCat1, "label" => "Grupo", "div" => "grid-4-12", "onChange" => "populaCombo('/integracao/options/estoque_catprodutos/nome/-1/pai/'+this.value, '#FormEstoquecategoria2', 'options'); sendForm('#formGrafico','#resultForm');"));
        echo $form->input("estoqueCategoria2", array("type" => "select", "label" => "Tipo", "div" => "grid-4-12"));
        echo $form->input("dataInicio", array("label" => "Inicio", "alt" => "date", "div" => "grid-2-12", "onChange" => "sendForm('#formGrafico','#resultForm');"));
        echo $form->input("dataFim", array("label" => "Término", "alt" => "date", "div" => "grid-2-12", "onChange" => "sendForm('#formGrafico','#resultForm');"));
        echo $form->close(null);
        echo $html->tag("hr", "", array(), true);
        echo $html->tag("div", "", array("id" => "resultForm"));
        break;
    case "grafico":
        echo $html->script("/grafico/highcharts");
        echo $html->script("/grafico/exporting");
        ?>
        <script>
            $(function () {
                $('#comercialHome').highcharts({
                    chart: {
                        type: 'spline',
                        height:200
                    },
                    title: {
                        text: 'Acompanhamento de Valores de Mercado'
                    },
                    xAxis: {
                        type: 'datetime',
                        dateTimeLabelFormats: { // don't display the dummy year
                            month: '%e. %b',
                            year: '%b'
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Preço Praticado'
                        },
                        min: 0
                    },
                    tooltip: {
                        formatter: function() {
                            return '<b>'+ this.series.name +'</b><br/>'+
                                '<b>'+Highcharts.dateFormat('%d/%b/%Y', this.x) +'</b>: '+ Highcharts.numberFormat(this.y,3,',','.') +'';
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -10,
                        y: 100,
                        borderWidth: 0
                    },
                                                                    
                                                                            
                    series: [
        <?php
        $Serie = 0;
        foreach ($dadosGrid as $titulo => $dadoGrafico) {
            if ($Serie > 0) {
                echo ",";
            }
            $categoria = 0;
            echo "{";
            echo "name:'{$titulo}',";
            echo "data:[";
            foreach ($dadoGrafico as $mes) {
                if ($categoria > 0) {
                    echo ",";
                }
                echo $mes;
                $categoria++;
            }
            echo "]}";
            $Serie++;
        }
        ?>
                    ]
                });
            });
                                                                    

        </script>
        <?php
        echo $html->tag("div", "", array("id" => "comercialHome"));
        foreach ($dadosGrid2 as $titulo => $dados) {

            $grid = $xgrid->start($dados)
                            ->caption($titulo)
                            ->alternate("grid_claro", "grid_escuro")
                            ->col("id")->hidden()
                            ->col("data")->date("d/m/Y")->title("Data")
                            ->col("preco")->title("Preço")->currency()
                            ->col("deletar")->title("")->cell("deletar.png", "/comercial/comportamentoMercado/deletar/{id}", array("class" => "deletarGrid"));
            echo $html->tag("div", $grid, array("class" => "grid-6-12"));

            ;
        }
        break;
    case "cadastrar":
        echo $form->create("", array("class" => "formee", "id" => "FormComportamentoMercado"));
        //echo $form->input("concorrente", array("type"=>"select","options"=>array("..."),"div" => "grid-4-12"));
        echo $form->input("data", array("div" => "grid-6-12", "alt" => "date"));
        echo $form->input("preco", array("label" => "Preço", "div" => "grid-6-12", "alt" => "moedaProduto"));

        echo $form->input("estoqueCategoria1", array("type" => "select", "label" => "Grupo", "div" => "grid-6-12", "onChange" => "populaCombo('/integracao/options/estoque_catprodutos/nome/-1/pai/'+this.value, '#FormEstoquecategoria2', 'options');", "options" => $dadosCat1));
        echo $form->input("estoqueCategoria2", array("type" => "select", "div" => "grid-6-12", "label" => "Tipo", "onChange" => "populaCombo('/integracao/options/estoque_catprodutos/nome/-1/pai/'+this.value, '#FormEstoquecategoria3', 'options');"));
        echo $form->input("estoqueCategoria3", array("type" => "select", "div" => "grid-6-12", "label" => "Aplicação", "onChange" => "populaCombo('/integracao/options/estoque_catprodutos/nome/-1/pai/'+this.value, '#FormEstoquecategoria4', 'options');"));
        echo $form->input("estoqueCategoria4", array("type" => "select", "label" => "Produto Final", "div" => "grid-6-12"));

        echo $html->tag("br", "", array("clear" => "all"));
        echo $form->input("atualizarConsumo", array("type" => "checkbox", "label" => "Atualizar Consumo das Fichas Comerciais"));
        echo $form->input("ignorarData", array("type" => "checkbox", "label" => "Ignorar Comparação de Datas"));
        echo $form->close("Salvar", array("class" => "botao formee-button grid-12-12"));
        break;
}
?>