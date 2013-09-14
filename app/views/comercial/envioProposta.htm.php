<script>
    $(function(){
        $("button,.botao, inputsubmit, inputbutton, button", "html").button();
        $("input:text").setMask();
        
        $("#salvaOferta").click(function(){
            CKUpdate();
            $("#formEnvioProposta").ajaxSubmit(function(data){
                if(data=='OK'){
                    alert("Salvo com Sucesso!");
                }else{
                    alert('Ocorreu um erro, verifique com o Administrador.');
                }
            }); 
        });
        $("#enviaOferta").click(function(){
            CKUpdate();
            $("#formEnvioProposta").ajaxSubmit(function(data){
                if(data=="OK"){
                    if(confirm("Confirma Envio?")){
                        AbreJanela('/comercial/envioProposta/enviar/<?php echo $id ?>',500,250,'Enviar Email Proposta <?php echo $id ?>',null, true);
                    }
                }else{
                    alert('Ocorreu um erro, verifique com o Administrador.');
                }
                
            });
            
        });
        
        $("#addDestinatario").ajaxForm(function(){
            loadDiv('#auxComercial','/comercial/envioProposta/listaDestinatarios/<?php echo $id; ?>');
        });
        
        
        
    });
</script>
<?php
switch ($op) {
    default:
    case "grid":
        echo $html->tag("h3", "Envios Efetuados", array("class" => "title"));
        if (empty($dadosGrid)) {
            echo $html->openTag("div", array("class" => "grid-12-12"));
            echo $html->openTag("div", array("class" => "caixa"));
            echo $html->tag("div", $html->tag("h3", $html->slice(28, "...", "Ops")), array("class" => "title"));
            echo $html->tag("div", $html->tag("p", "Nenhum Envio Encontrado"), array("class" => "borda"));
            echo $html->closeTag("div");
            echo $html->closeTag("div");
        } else {
            foreach ($dadosGrid as $registro) {
                echo $html->openTag("div", array("class" => "grid-4-12"));
                echo $html->openTag("div", array("class" => "caixa"));
                if ($registro["sended"] == 0) {
                    $link = $html->imageLink("editar.png", "javascript:loadDiv('#contComercial','/comercial/envioProposta/editor/{$registro["id"]}');", array("style" => "margin-top:1px;"));
                } else {
                    $link = "";
                }
                echo $html->tag("div", $html->link($html->tag("h3", "#{$registro["id"]} - " . $html->slice(25, "...", $registro["assunto"]), array("title" => $registro["assunto"])), "javascript:loadDiv('#contComercial','/comercial/envioProposta/verCampanha/{$registro["id"]}');") . $link, array("class" => "title"));
                echo $html->tag("div", $html->tag("p", $html->tag("strong", "Data de Envio: ") . $date->format("d/m/Y H:i", $registro["created"]) . "<br />") . $html->tag("p", $html->tag("strong", "Destinatários: ") . $registro["countDestinatarios"] . "<br />") . $html->tag("p", $html->tag("strong", "Enviados: ") . $registro["countSended"] . "<br />") . $html->tag("p", $html->tag("strong", "Lidos: ") . $registro["readed"] . "<br />"), array("class" => "borda"));
                echo $html->closeTag("div");
                echo $html->closeTag("div");
            }
        }
        break;
    case "verCampanha":
        echo $html->script("/grafico/highcharts");
        echo $html->script("/grafico/modules/exporting");
        ?>
        <script>
            $(function(){
                $('#graph').highcharts({
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false
                    },
                    title: {
                        text: 'Resultado dos Envios'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage}%</b>',
                        percentageDecimals: 1
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend:true
                        }
                    },
                    series: [{
                            type: 'pie',
                            name: 'Resultado dos Envios',
                            data: [
                                ['Lidos',   <?php echo $statusCampanha[0]["readed"]; ?>],
                                ['Não Lidos',       <?php echo (($statusCampanha[0]["countSended"] - $statusCampanha[0]["error"]) - $statusCampanha[0]["readed"]); ?>],
                                ['Erros',       <?php echo $statusCampanha[0]["errors"]; ?>]
                            ]
                        }]
                }); 
            });
        </script>
        <?php
        echo $html->tag("h3", "#{$statusCampanha[0]["id"]} - {$statusCampanha[0]["assunto"]}", array("class" => "title"));
        echo $html->tag("div", "", array("class" => "grid-6-12", "id" => "graph"));

        $status = $html->tag("div", $html->tag("h3", "Data de Envio: " . $date->format("d/m/Y H:i", $statusCampanha[0]["created"])), array("class" => "formee-msg-info"));
        $status .= $html->tag("div", $html->tag("h3", "Enviado por: {$statusCampanha[0]["who"]}"), array("class" => "formee-msg-info"));
        $status .= $html->tag("div", $html->tag("h3", "Destinatários: {$statusCampanha[0]["countDestinatarios"]}"), array("class" => "formee-msg-info"));
        $status .= $html->tag("div", $html->tag("h3", "Enviados: {$statusCampanha[0]["countSended"]}"), array("class" => "formee-msg-info"));
        $status .= $html->tag("div", $html->tag("h3", "Lidos: {$statusCampanha[0]["readed"]}"), array("class" => "formee-msg-info"));
        if ($statusCampanha[0]["errors"] == 0) {
            $classErro = "formee-msg-info";
        } else {
            $classErro = "formee-msg-error";
        }
        $status .= $html->tag("div", $html->tag("h3", "Erros: {$statusCampanha[0]["errors"]}"), array("class" => $classErro));

        echo $html->tag("div", $status, array("class" => "grid-6-12"));
        echo $html->tag("br", "", array("clear" => "all"), true);
        $grid = $xgrid->start($dadosGrid["contato"])
                        ->alternate("grid_claro", "grid_escuro")
                        ->hidden(array("id", "tipo", "error", "id_oferta", "id_contato", "id_cliente", "modified"))
                        ->col("name")->title("Email")->cell("{name} ({error})")
                        ->col("sended")->title("Enviado")->conditions("sended", array("0" => array("label" => "red_flag.gif"), "1" => array("label" => "green_flag.gif")))
                        ->col("readed")->title("Lido")->conditions("readed", array("0" => array("label" => "red_flag.gif"), "1" => array("label" => "green_flag.gif")));
        echo $html->tag("div", $html->tag("h3", "Destinatários", array("class" => "title")) . $grid);
        echo $html->tag("br", "", array("clear" => "all"), true);
        echo $html->tag("div", $html->tag("h3", "Corpo do Email", array("class" => "title")) . $html->tag("center", $dadosGrid["texto"]));
        break;
    case "editor":
        echo $html->tag("script", "CKEDITOR.replace('FormTexto',{toolbar:'Email',height:400});");
        echo $html->tag("h3", "Conteúdo", array("class" => "title"));
        echo $form->create("", array("class" => "formee", "id" => "formEnvioProposta"));
        echo $form->input("assunto", array("div" => "grid-8-12", "value" => $dadosForm["assunto"]));
        //echo $form->input("ccRepresentante", array("type"=>"select","options"=>$bool,"div" => "grid-6-12","label"=>"Cópia para o Representante", "value" => $dadosForm["ccRepresentante"]));
        echo $form->input("obsCliente", array("div" => "grid-4-12", "label" => "Observação Histórico", "value" => $dadosForm["obsCliente"]));
        echo $form->input("texto", array("type" => "textarea", "label" => false, "class" => "ckeditor", "div" => "grid-12-12", "value" => $dadosForm["texto"]));
        echo $form->close(null);
        echo $html->tag("script", "loadDiv('#auxComercial','/comercial/envioProposta/listaDestinatarios/{$id}');");

        break;

    case "listaDestinatarios":
        echo $html->tag("h3", "Ações", array("class" => "title"));
        echo $html->link("Salvar", "javascript:void(0);", array("id" => "salvaOferta", "class" => "botao grid-6-12"));
        echo $html->link("Enviar", "javascript:void(0);", array("id" => "enviaOferta", "class" => "botao grid-6-12"));
        echo $html->tag("br", "", array("clear" => "all"), true);
        echo $html->tag("br", "", array("clear" => "all"), true);
        echo $html->tag("h3", "Destinatários", array("class" => "title"));
        echo $html->openTag("ul", array("class" => "token-input-list"));
        if (count($dadosGrid) == 0) {
            echo $html->tag("li", $html->tag("p", "Nenhum Contato Selecionado"), array("class" => "token-input-token"));
        }
        foreach ($dadosGrid as $contato) {
            echo $html->tag("li", $html->tag("p", (empty($contato["to"]["nome"])) ? $contato["name"] : $contato["to"]["nome"]) . $html->tag("span", $html->link("x", "javascript:delAjax('/comercial/envioProposta/delDestinatario/{$contato["id"]}','auxComercial', '/comercial/envioProposta/listaDestinatarios/{$id}');"), array("class" => "token-input-delete-token")), array("class" => "token-input-token"));
        }
        echo $form->create("", array("id" => "addDestinatario"));
        echo $html->tag("li", $form->input("name", array("label" => false, "placeholder" => "Digite o Email", "div" => false, "style" => "outline: none; width: 170px; float:left;")) . $form->input("", array("type" => "image", "src" => "/images/addContato.png", "div" => false, "value" => "submit", "style" => "width:29px;height:26px; float:right; padding:0;")), array("class" => "token-input-input-token token-input-highlighted-token"));
        echo $form->close(null);
        echo $html->closeTag("ul");
        break;

    case "enviar":
        echo $xgrid->start($dadosGrid)
                ->caption("Resultado do Envio")
                ->alternate("grid_claro", "grid_escuro")
                ->hidden(array("id", "error", "tipo"))
                ->col("name")->title("Email")
                ->col("sended")->title("")->conditions("sended", array("0" => array("label" => "red_flag.gif"), "1" => array("label" => "green_flag.gif")));
        break;
}
?>