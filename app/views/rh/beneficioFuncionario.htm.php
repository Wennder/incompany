<?php
switch ($op){
    case "novo":
        echo $form->create();
        echo $form->input("beneficio_id",array("type"=>"select","options"=>$comboBeneficio,"label"=>"Beneficio","class"=>"Form4Blocos","value"=>$dadosBeneficio['beneficio_id']));
        echo $form->input("descricaoBeneficio",array("type"=>"","label"=>"","class"=>"","div"=>"","value"=>$dadosBeneficio['descricaoBeneficio']));
        echo $form->input("valorBeneficio",array("type"=>"","label"=>"","class"=>"","div"=>"","value"=>$dadosBeneficio['valorBeneficio']));
        echo $form->input("descontoBeneficio",array("type"=>"","label"=>"","class"=>"","div"=>"","value"=>$dadosBeneficio['descontoBeneficio']));
        echo $form->close("Salvar");
        break;
    case "grid":
        echo $xgrid->start()
            ->caption("Beneficios")
            ->noData("Você nao possui nenhum beneficio")
            ->col("beneficio_id")
            ->col("valorBeneficio")
            ->col("descontoBeneficio")
            ->col("created")->title("")
            ->col("modified")->title("Modificado")
            ->alternate('grid_clado','grid_escruro');
        break;

}
?>
