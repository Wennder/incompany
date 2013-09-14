
<?php
switch ($op){
    case "novo":
        echo $form->create("",array("id"=>"FormTipoBeneficio"));
        echo $form->input("nome",array("type"=>"text","label"=>"Nome","class"=>"Form2Blocos","values"=>$dadostipoBeneficio['nome']));
        echo $form->input("formaCalculo",array("type"=>"select","options"=>$comboFormaCalculo,"label"=>"Forma de Calculo","class"=>"Form2Blocos","values"=>$dadostipoBeneficio['formaCalculo']));
        echo $form->input("formaDesconto",array("type"=>"select","options"=>$comboFormaDesconto,"label"=>"Forma de Desconto","class"=>"Form2Blocos","values"=>$dadostipoBeneficio['formaDesconto']));
        echo $form->input("tipoDesconto",array("type"=>"select","options"=>$tipoDesconto,"label"=>"Tipo de Desconto","class"=>"Form2Blocos","values"=>$dadostipoBeneficio['tipoDesconto']));
        echo $form->input("valorDesconto",array("type"=>"text","label"=>"Valor de Desconto","class"=>"Form2Blocos","values"=>$dadostipoBeneficio['valorDesconto']));
        echo "</form>";
break;
    case "grid":
        echo $xgrid->start($dadosGrid)
            ->caption("Tipos de beneficios")
            ->col("id")->hidden()
            ->col("nome")
            ->col("formaCalculo")
            ->col("formaDesconto")
            ->col("tipoDesconto")
            ->col("valorDesconto")
            ->col("created")->date("d/m/Y")->title("Criado")
             ->noData("Nenhum tipo de beneficio cadastrado")
           ->alternate("grid_claro","grid_escuro");
        break;

    default :
echo "<div class='titulo'>Cadastro de Tipos de Beneficios</div>";
       ?>
<script type="text/javascript">
    $(function(){
        $("#cadBeneficio").dialog({
                    autoOpen: false,
                    modal:true,
                    height:400,
                    width:500,
                    buttons:{
                        "Salvar":function(){
                            $("#FormTipoBeneficio").trigger("submit");
                        }
                    }
                });
                $("#gridBeneficio").load("/rh/tiposBeneficio/grid");

    });
</script>
<a href="javascript:popIn('cadBeneficio','/rh/tiposBeneficio/novo/<?php echo $dadostipoBeneficio['id']?>')" class="botao">*Novo</a>
        <div id="cadBeneficio"></div>
        <div id="gridBeneficio"></div>
<?php
       break;
}
?>
