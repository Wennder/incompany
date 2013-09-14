<script type="text/javascript">
 $(document).ready(function() {
	$("#cadBanco").validate({
            errorContainer: "#errConteiner",
		rules: {
			nome: {
                               required:true
			},
                        cod: {
                               selectRequerido:0
			}
		},
		messages: {
                      nome: {
                               required:"Digite o nome."
			},
                        cod: {
                               selectRequerido:"Digite o código do banco"
			}
		}
	});
});
</script>


<?php
$this->pageTitle = "Financeiro :: Bancos";
 echo $form->create("",array("id"=>"cadBanco"));
 echo $form->input("cod", array("type"=>"text","div"=>"ladoalado", "label"=>"Código", "class"=>"Form1Bloco","alt"=>"intsemponto"));
 echo $form->input("nome", array("type"=>"text","div"=>"ladoalado", "label"=>"Nome", "class"=>"Form2Blocos"));
 echo $form->close("Inserir");
?>
<br />
<div class="borda ui-corner-all">
    <?php
    echo $xgrid->start($dadosBancos)
        ->caption('Bancos Cadastrados')
        ->col('cod')->title('Código')
        ->col('nome')->title('Nome')
        ->col('id')->hidden()
        ->col('created')->hidden()
        ->col('Ação')->conditions('id', array(
     '<= 7' => array('label'=>"deletar.png","href"=>"javascript:deletar('/financeiro/delBanco/{id}');","border"=>"0"),
     '> 7' => array('label'=>"deletar.png","href"=>"javascript:deletar('/financeiro/delBanco/{id}');","border"=>"0")
  ))
        ->noData('Nenhum registro encontrado')
        ->alternate("grid_claro","grid_escuro");
    ?>
</div>