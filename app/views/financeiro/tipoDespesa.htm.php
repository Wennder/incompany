<?php
$this->pageTitle = "Financeiro :: Tipos de Despesa";
 echo $form->create("");
 echo $form->input("nome", array("type"=>"text","div"=>"ladoalado", "label"=>"Nome", "class"=>"Form1Bloco"));
 echo $form->close("Inserir");
?>
<br />
<div class="borda ui-corner-all">
    <?php
    echo $xgrid->start($dadosTipos)
        ->caption('Tipos de Despesa')
        ->col('nome')->title('Nome')
        ->col('id')->hidden()
            ->col("ativo")->conditions("ativo",$bool)
        ->col('created')->hidden()
        ->col('Ação')->conditions('id', array(
     '<= 7' => array('label'=>"deletar.png","href"=>"javascript:deletar('/financeiro/delTipo/{id}');","border"=>"0"),
     '> 7' => array('label'=>"deletar.png","href"=>"javascript:deletar('/financeiro/delTipo/{id}');","border"=>"0")
  ))
        ->noData('Nenhum registro encontrado')
        ->alternate("grid_claro","grid_escuro");
    ?>
</div>