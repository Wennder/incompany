<script>
    $(function() {
		$("button,.botao, input:submit, input:button, button", "html").button();
                $("#formSolicitacao").ajaxForm(function(){
                    alert("Status Atualizado com Sucesso!");
                });

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
    echo "<b>Beneficiário: </b>".$Aocorrencia["rh_funcionarios"]["nome"]."<br/><br/>";
    echo "<b>Tipo de despesa: </b>".$Aocorrencia["tipodespesa"]["nome"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo " <b> Motivo: </b>".$Aocorrencia["financeiro_motivodespesa"]["nome"]."<br/><br/>";
    echo "<b>Km: </b>".$km."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "<b>OS: </b>".$os."<br><br>";
    echo "<b>Valor: </b><font color='red'>R$ ".$Aocorrencia["valor"]."</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "<b>Nota: </b>".$Aocorrencia["nota"]."<br/>";
    echo "<b>Status: </b>".$statusDespesa[$Aocorrencia["status_id"]]." dia ".$date->format("d/m/Y",$Aocorrencia["modified"])."<br/><br/>";
    echo "<fieldset>
            <legend><b>Observação do Técnico</b></legend>
            ".$descricao."
          </fieldset><br/>";
    
    if($Aocorrencia["rh_funcionarios"]["gerente_id"] == $loggedUser["id"]){
    echo $form->create("",array("id"=>"formSolicitacao"));
    echo $form->input("id",array("type"=>"hidden","value"=>$Aocorrencia["id"]));
    echo $form->input("status_id",array("type"=>"select","label"=>"Atualizar Status","class"=>"Form1Bloco","options"=>$statusGerente,"value"=>$Aocorrencia["status_id"]));
    echo $form->input("obsGerente",array("type"=>"textarea","class"=>"Form2Blocos","label"=>"Observação do Gerente","value"=>$Aocorrencia["obsGerente"]));
    echo $form->close("Atualizar",array("class"=>"Form1Bloco botao"));
    }
    echo "</div>";
    
}else{
    echo "<center>Pedido de reembolso não encontrado</center>";
}
?>