<script>
    $(function(){
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
    });

</script>

<?php
switch ($op) {
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->alternate("grid_claro", "grid_escuro")
                ->col("id")->hidden()
                ->col("1")->title("")->cell("right_seta.png", "javascript:loadDiv('#contImportacoes','/importacoes/dashboard/processos/{id}');");
        ;
        echo $html->link("Nova Home", "javascript:loadDiv('#contImportacoes','/importacoes/dashboard/index');", array("class" => "botao"));
        break;
    case "processos":
        echo $xgrid->start($dadosGrid)
                ->alternate("grid_claro", "grid_escuro")
                ->hidden(array("id", "terminal", "cliente_id", "operacao", "contato", "moeda"))
                ->col("processo")->cell("{processo}", "/importacoes/processo/{processo}")
                ->col("who")->title("Modificado por")
                ->col("cliente")->cellArray("nomeFantasia")->position(2)
                ->col("modified")->title("Ult. Modificação")->date("d/m/Y H:i:s")
                ->col("created")->title("Aberto")->date("d/m/Y H:i:s");
        break;
    case "index":
        //Define lista dos orçamentos a ser exibidos
        foreach ($processos["orcamentos"] as $orcamento) {
            $contentTag = $html->tag("div", "&nbsp;", array("class" => "status neutral"));
            $spanTag = $html->tag("span", "Cliente: {$orcamento["cliente"]["nomeFantasia"]}<br/>FOB: {$importacoes->fob($orcamento["processo"], null, null, "processo", true, true)}<br/>Abertura: {$date->format("d/m/Y", $orcamento["created"])}<br/>");
            $contentTag .= $html->link("{$orcamento["processo"]} - {$html->slice(15, "...", $orcamento["cliente"]["nomeFantasia"])} {$spanTag}", "/importacoes/orcamento/{$orcamento["processo"]}", array("class" => "tooltip"));
            $echoOrcamentos .= $html->tag("div", $contentTag, array("class" => "grid_4", "style" => "margin-top:5px;"));
        }

        //Define Lista dos Pedidos Em Processamento
        if (!empty($processos["emProcessamento"])){
        foreach ($processos["emProcessamento"] as $processamento) {
            $contentTag = $html->tag("div", "&nbsp;", array("class" => "status neutral"));
            $spanTag = $html->tag("span", "Cliente: {$processamento["cliente"]["nomeFantasia"]}<br/>FOB: {$importacoes->fob($processamento["processo"], null, null, "processo", true, true)}<br/>Abertura: {$date->format("d/m/Y", $processamento["created"])}<br/>");
            $contentTag .= $html->link("{$processamento["processo"]} - {$html->slice(15, "...", $processamento["cliente"]["nomeFantasia"])} {$spanTag}", "/importacoes/processo/{$processamento["processo"]}", array("class" => "tooltip"));
            $echoProcessamento .= $html->tag("div", $contentTag, array("class" => "grid_8", "style" => "margin-top:5px;"));
        }}else{
            $echoProcessamento = $html->printWarning("Nenhum Processo Encontrado");
        }
        
        //Define Lista dos Pedidos Aguardando Atracação
        if (!empty($processos["agAtracacao"])){
        foreach ($processos["agAtracacao"] as $processamento) {
            $prazoEta = $date->diffDate($processamento["eta"],date("Y-m-d"),"D");
            if($processamento["avisoAtracacao"]==1){
                $corStatus = "green";
            }elseif($processamento["avisoAtracacao"]==0 && $prazoEta > -7){
                $corStatus = "red";
            }else{
                $corStatus = "yellow";
            }
            if($prazoEta < 0){
                $prazoEta = $prazoEta*-1;
            }else{
                $prazoEta = "0";
            }
            $contentTag = $html->tag("div", "&nbsp;", array("class" => "status $corStatus"));
            $spanTag = $html->tag("span", "Cliente: {$processamento["cliente"]["nomeFantasia"]}<br/>FOB: {$importacoes->fob($processamento["processo"], null, null, "processo", true, true)}<br/>Abertura: {$date->format("d/m/Y", $processamento["created"])}<br/>ETA: {$date->format("d/m/Y", $processamento["eta"])} ($prazoEta D)<br/>");
            $contentTag .= $html->link("{$processamento["processo"]} - {$html->slice(15, "...", $processamento["cliente"]["nomeFantasia"])} {$spanTag}", "/importacoes/processo/{$processamento["processo"]}", array("class" => "tooltip"));
            $echoAtracacao .= $html->tag("div", $contentTag, array("class" => "grid_8", "style" => "margin-top:5px;"));
        }}else{
            $echoAtracacao = $html->printWarning("Nenhum Processo Encontrado");
        }
        
        //Define Lista dos Pedidos Aguardando Desembaraço
        if (!empty($processos["agDesembaraco"])){
        foreach ($processos["agDesembaraco"] as $processamento) {
            $contentTag = $html->tag("div", "&nbsp;", array("class" => "status neutral"));
            $spanTag = $html->tag("span", "Cliente: {$processamento["nomeFantasia"]}<br/>FOB: {$importacoes->fob($processamento["processo"], null, null, "processo", true, true)}<br/>ETA: {$date->format("d/m/Y", $processamento["eta"])}<br/>Abertura: {$date->format("d/m/Y", $processamento["created"])}<br/>");
            $contentTag .= $html->link("{$processamento["processo"]} - {$html->slice(15, "...", $processamento["nomeFantasia"])} {$spanTag}", "javascript:void(0);", array("class" => "tooltip"));
            $echoDesembaraco .= $html->tag("div", $contentTag, array("class" => "grid_8", "style" => "margin-top:5px;"));
        }}else{
            $echoDesembaraco = $html->printWarning("Nenhum Processo Encontrado");
        }
        
        //Define Lista dos Pedidos com Mercadoria Liberada
        if (!empty($processos["mercadoriaLiberada"])){
        foreach ($processos["mercadoriaLiberada"] as $processamento) {
            $prazoEta = $date->diffDate(date("Y-m-d"),$processamento["eta"],"D");
            $contentTag = $html->tag("div", "&nbsp;", array("class" => "status neutral"));
            $spanTag = $html->tag("span", "Cliente: {$processamento["nomeFantasia"]}<br/>FOB: {$importacoes->fob($processamento["processo"], null, null, "processo", true, true)}<br/>ETA: {$date->format("d/m/Y", $processamento["eta"])}<br/>Abertura: {$date->format("d/m/Y", $processamento["created"])}<br/>");
            $contentTag .= $html->link("{$processamento["processo"]} - {$html->slice(15, "...", $processamento["cliente"]["nomeFantasia"])} {$spanTag}", "javascript:void(0);", array("class" => "tooltip"));
            $echoLiberada .= $html->tag("div", $contentTag, array("class" => "grid_8", "style" => "margin-top:5px;"));
        }}else{
            $echoLiberada = $html->printWarning("Nenhum Processo Encontrado");
        }
        
        echo $html->boxDashboard("Orçamentos", $echoOrcamentos, "grid_16 container_16");
        echo $html->boxDashboard("Em Processamento", $echoProcessamento, "grid_8");
        echo $html->boxDashboard("Aguardanto Atracação", $echoAtracacao, "grid_8");
        echo $html->boxDashboard("Aguardando Desembaraço", $echoDesembaraco, "grid_6");
        echo $html->boxDashboard("Mercadoria Liberada", $echoLiberada, "grid_5");
        echo $html->boxDashboard("Pendencia Financeira", $echoLiberada, "grid_5");
        break;

    case "buscaProcesso":
        echo $html->tag("h3","Busca de Processos",array("class"=>"title"));
        echo $form->create("",array("class"=>"formee"));
        echo $form->input("processo",array("alt"=>"","div"=>"grid-6-12"));
        echo $form->input("termo",array("alt"=>"","div"=>"grid-6-12"));
        echo $form->input("cliente",array("alt"=>"","div"=>"grid-12-12"));
        echo $form->close("Buscar", array("class"=>"botao grid-12-12"));
        break;
}
?>
