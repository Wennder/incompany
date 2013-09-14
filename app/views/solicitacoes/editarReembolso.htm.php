<script>
    $(function() {
		$("button,.botao, input:submit, input:button, button", "html").button();

	});
</script>
<?php
if (!empty($Aocorrencia)){
    $descricao = str_replace("\r\n", "<br/>", $Aocorrencia["observacao"]);
    if (empty($Aocorrencia["km"])){
        $km = "--- ";
    }else{
        $km = $Aocorrencia["km"];
    }
    if (empty($Aocorrencia["os"])){
        $os = "--- ";
    }else{
        $os = $Aocorrencia["os"];
    }
    echo "<div class='borda'><div class='titulo'><center>Pedido de Reembolso #".$Aocorrencia["id"]."</center></div>";
    echo "<b>Beneficiário: </b>".$Aocorrencia["rh_funcionarios"]["nome"]."<br><br>";
    echo "<b>Tipo de despesa: </b>".$Aocorrencia["tipodespesa"]["nome"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo " <b> Motivo: </b>".$motivosDespesas[$Aocorrencia["motivodespesa_id"]]."<br><br>";
    echo "<b>Km: </b>".$km."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "<b>OS: </b>".$os."<br><br>";
    echo "<b>Valor: </b><font color='red'>R$ ".$Aocorrencia["valor"]."</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "<b>Nota: </b>".$Aocorrencia["nota"]."<br>";
    echo "<b>Status: </b>".$statusDespesa[$Aocorrencia["status_id"]]." dia ".$date->format("d/m/Y",$Aocorrencia["modified"])."<br/><br/>";
    echo "<fieldset>
            <legend><b>Observação</b></legend>
            ".$descricao."
          </fieldset><br><br>";
    if($Aocorrencia["rh_funcionarios"]["gerente_id"] == $loggedUser["id"]){

    echo $form->create();
    echo $form->input("id",array("type"=>"hidden","value"=>$Aocorrencia["id"]));
    echo $form->input("status_id",array("type"=>"select","label"=>"Atualizar Status","class"=>"Form1Bloco","options"=>$statusGerente,"value"=>$Aocorrencia["status_id"]));
    echo $form->close("Atualizar",array("class"=>"Form1Bloco"));
    }
    echo "</div>";
    
}else{
    echo "<center>Pedido de reembolso não encontrado</center>";
}
?>