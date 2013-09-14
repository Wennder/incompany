<?php
switch ($op) {
    case "novo":
        echo $form->create();

        echo $form->input("inicioVigencia",array("alt"=>"date","label"=>"Inicio Vigência","class"=>"Form1Bloco","div"=>"ladoalado","value"=>$dadosForm["inicioVigencia"]));
        echo $form->input("fimVigencia",array("alt"=>"date","label"=>"Fim Vigência","class"=>"Form1Bloco","value"=>$dadosForm["fimVigencia"]));

        echo "<fieldset><legend>INSS</legend>";
        echo $form->input("INSS_de1",array("alt"=>"moeda","label"=>"De","class"=>"FormMeioBloco","div"=>"ladoalado","value"=>$dadosForm["INSS_de1"]));
        echo $form->input("INSS_ate1",array("alt"=>"moeda","label"=>"Até","class"=>"FormMeioBloco","div"=>"ladoalado","value"=>$dadosForm["INSS_ate1"]));
        echo $form->input("INSS_value1",array("alt"=>"porcentagem","label"=>"%","class"=>"FormMeioBloco","value"=>$dadosForm["INSS_value1"]));

        echo $form->input("INSS_de2",array("alt"=>"moeda","label"=>"De","class"=>"FormMeioBloco","div"=>"ladoalado","value"=>$dadosForm["INSS_de2"]));
        echo $form->input("INSS_ate2",array("alt"=>"moeda","label"=>"Até","class"=>"FormMeioBloco","div"=>"ladoalado","value"=>$dadosForm["INSS_ate2"]));
        echo $form->input("INSS_value2",array("alt"=>"porcentagem","label"=>"%","class"=>"FormMeioBloco","value"=>$dadosForm["INSS_value2"]));

        echo $form->input("INSS_de3",array("alt"=>"moeda","label"=>"De","class"=>"FormMeioBloco","div"=>"ladoalado","value"=>$dadosForm["INSS_de3"]));
        echo $form->input("INSS_ate3",array("alt"=>"moeda","label"=>"Até","class"=>"FormMeioBloco","div"=>"ladoalado","value"=>$dadosForm["INSS_ate3"]));
        echo $form->input("INSS_value3",array("alt"=>"porcentagem","label"=>"%","class"=>"FormMeioBloco","value"=>$dadosForm["INSS_value3"]));

        echo $form->input("INSS_de4",array("alt"=>"moeda","label"=>"De","class"=>"FormMeioBloco","div"=>"ladoalado","value"=>$dadosForm["INSS_de4"]));
        echo $form->input("INSS_ate4",array("alt"=>"moeda","label"=>"Até","class"=>"FormMeioBloco","div"=>"ladoalado","value"=>$dadosForm["INSS_ate4"]));
        echo $form->input("INSS_value4",array("alt"=>"porcentagem","label"=>"%","class"=>"FormMeioBloco","value"=>$dadosForm["INSS_value4"]));
        echo "</fieldset>";

        echo $form->input("IR_isento",array("alt"=>"moeda","label"=>"Isento","class"=>"Form2Blocos","value"=>$dadosForm["IR_isento"]));

        echo $form->input("IR_paramInicio",array("alt"=>"moeda","label"=>"Inicio","class"=>"Form2Blocos","value"=>$dadosForm["IR_isento"]));
        
        echo $form->close("Salvar");
        break;

    case "grid":
        
        echo $xgrid->start($dadosGrid)
            ->caption("Tabela de INSS e Imposto de Renda")
            ->noData("Não há dados")
            ->alternate("grid_claro","grid_escuro");
        break;
    default:
        break;
}

?>