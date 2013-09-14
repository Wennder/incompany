<script>
    $(function(){
                
                $("button,.botao, input:submit, input:button, button", "html").button();
                $("input:text").setMask();
    });
</script>
<?php
$this->pageTitle = "Importações :: Config";

switch ($op) {
    default :
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->caption("Formulas de Operações")
                ->alternate("grid_claro", "grid_escuro")
                ->noData("Nenhum Resultado Encontrado")
                ->hidden(array("aliqsEntrada","aliqsSaida"))
                ->col("id")->hidden()
                ->col("nomeOperacao")->title("Operação")
                ->col("modified")->title("Ultima Modificação")->date("d/m/Y h:i:s")
                ->col("editar")->title("")->cell("editar.gif", "javascript:loadDiv('#contImportacoes','/importacoes/configOperacoes/cadastrar/{id}');");
        echo $html->link("Novo","javascript:loadDiv('#contImportacoes','/importacoes/configOperacoes/cadastrar');",array("class"=>"botao"));
        break;
    case "cadastrar":
        echo $html->openTag("h3");
        echo "Formulas de Operações";
        echo $html->closeTag("h3");
        echo $form->create();
        echo $form->input("nomeOperacao",array("type" => "text", "label" => "Nome da Operação", "div" => "Form100por", "value" => $dadosFormulario['nomeOperacao']));
        
        echo $form->input("cfopEntrada",array("type" => "text", "label" => "CFOP de Entrada","maxLength"=>"4", "div" => "Form50por FormLeft", "value" => $dadosFormulario['cfopEntrada']));
        echo $form->input("cfopSaida",array("type" => "text", "label" => "CFOP de Saída","maxLength"=>"4", "div" => "Form50por FormRight", "value" => $dadosFormulario['cfopSaida']));
        
        
        echo $form->input("II", array("type" => "textarea", "label" => "II", "div" => "Form50por FormLeft", "value" => $dadosFormulario['II']));
        echo $form->input("IPIEntrada", array("type" => "textarea", "label" => "IPI Entrada", "div" => "Form50por FormRight", "value" => $dadosFormulario['IPIEntrada']));
        echo $html->tag("br","",array("clear"=>"all"),true);
        echo $form->input("PIS", array("type" => "textarea", "label" => "PIS", "div" => "Form50por FormLeft", "value" => $dadosFormulario['PIS']));
        echo $form->input("COFINS", array("type" => "textarea", "label" => "COFINS", "div" => "Form50por FormRight", "value" => $dadosFormulario['COFINS']));
        echo $html->tag("br","",array("clear"=>"all"),true);
        echo $form->input("ICMSEntrada", array("type" => "textarea", "label" => "ICMS Entrada","rows"=>"5", "div" => "Form50por FormLeft", "value" => $dadosFormulario['ICMSEntrada']));
        echo $form->input("ICMSST", array("type" => "textarea", "label" => "ICMSST","rows"=>"5", "div" => "Form50por FormRight", "value" => $dadosFormulario['ICMSST']));
        echo $html->tag("br","",array("clear"=>"all"),true);
        echo $html->tag("hr","",array(),true);
        echo $form->input("IPISaida", array("type" => "textarea", "label" => "IPI Saída","rows"=>"5", "div" => "Form50por FormLeft", "value" => $dadosFormulario['IPISaida']));
        echo $form->input("ICMSSaida", array("type" => "textarea", "label" => "ICMS Saída","rows"=>"5", "div" => "Form50por FormRight", "value" => $dadosFormulario['ICMSSaida']));
        echo $form->close("Salvar", array("class" => "botao"));
        break;
}
?>