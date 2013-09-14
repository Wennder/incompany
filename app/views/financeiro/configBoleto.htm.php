<script type="text/javascript">
    $("button,.botao, input:submit, input:button, button", "html").button();
    $("input:text").setMask();
</script>
<?php
$this->pageTitle = "Financeiro :: Configurar Boletos";
switch ($op) {
    case "novo":
       
        echo $form->create();
        echo $form->input("id_empresa", array("type" => "select","options"=>$empresas, "label" => "Empresa", "class" => "Form2Blocos", "value" => $dadosForm['id_empresa']));
        echo $form->input("cod_banco", array("type" => "select","options"=>$bancos, "label" => "Banco", "class" => "Form2Blocos", "value" =>  $dadosForm['cod_banco']));
        echo $form->input("localPagamento", array("type" => "text", "label" => "Local Pgto.", "class" => "Form2Blocos", "value" => $dadosForm['localPagamento']));
        echo $form->input("agencia", array("type" => "text", "label" => "Agência", "class" => "FormMeioBloco", "div" => "ladoalado" , "value" =>$dadosForm['agencia']));
        echo $form->input("conta", array("type" => "text", "label" => "Conta", "class" => "Form1Bloco","value" =>$dadosForm['conta']));
        echo $form->input("cod_cedente", array("type" => "text", "label" => "Cod. Convênio - Cod. Cedente", "class" => "Form1Bloco","div"=>"ladoalado", "value" =>$dadosForm['cod_cedente']));
        echo $form->input("nDocInicial", array("type" => "text", "label" => "Nº Doc. Inicial", "class" => "Form1Bloco", "value" =>$dadosForm['nDocInicial']));
        echo $form->input("taxaBoleto", array("type" => "text","alt"=>"moeda", "label" => "Taxa do Boleto", "class" => "Form1Bloco","div"=>"ladoalado", "value" =>$dadosForm['taxaBoleto']));
        echo $form->input("especieDoc", array("type" => "text", "label" => "Especie do Doc.", "class" => "Form1Bloco", "value" =>$dadosForm['especieDoc']));
        echo $form->input("instrucoes1",array("type"=>"text","label"=>"Instrução linha 1","class"=>"Form2Blocos","value"=>$dadosForm['instrucoes1']));
        echo $form->input("instrucoes2",array("type"=>"text","label"=>"Instrução linha 2","class"=>"Form2Blocos","value"=>$dadosForm['instrucoes2']));
        echo $form->input("instrucoes3",array("type"=>"text","label"=>"Instrução linha 3","class"=>"Form2Blocos","value"=>$dadosForm['instrucoes3']));
        echo $form->close("Salvar"); 
        break;
    case "grid":
      
        echo $xgrid->start($dadosGrid)
                ->caption("Lista de Config. de Boletos")
                ->noData("Não possui registro até o momento")
                ->hidden(array("instrucoes1","instrucoes2","instrucoes3","id","especieDoc","taxaBoleto","nDocInicial","cod_cedente","localPagamento","id_empresa","cod_banco","created","modified"))
                ->col("empresa")->title("Empresa")->cellArray("nomeFantasia")->position(1)
                ->col("banco")->title("Banco")->cellArray("nome")->position(2)
                ->col("agencia")->position(3)
                ->col("conta")->position(4)
                ->col("editar")->title("")->conditions("id", array(">=1" => array("label" => "editar.png", "href" => "javascript:popIn('janelaModal','/financeiro/configBoleto/novo/{id}');", "border" => "0")))
                ->col('excluir')->title("")->conditions('id', array(
                    ">=1" => array("label" => "deletar.png", "href" => "javascript:deletar('/financeiro/configBoleto/deletar/{id}','gridConfBoleto','/financeiro/configBoleto/')", "border" => "0")
                ))
               ->alternate("grid_claro", "grid_escuro");

echo $html->link("Novo","javascript:popIn('janelaModal','/financeiro/configBoleto/novo/{id}');",array("class"=>"botao"));
        break;

}
?> 