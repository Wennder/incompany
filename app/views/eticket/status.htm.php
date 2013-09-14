<script>
$(function(){
	$("button,.botao, input:submit, input:button, button", "html").button();
	$("input:text").setMask();
});
</script>
<?php
switch ($op) {
    case "novo":
?>
<?php
echo $form->create();
echo $form->input("nome",array("type"=>"text","label"=>"Nome","class"=>"Form2Blocos","value" => $dados["nome"]));
echo $form->input("emAberto",array("type"=>"select","options"=>array("0"=>"Selecione","1"=>"Em Aberto","2"=>"Encerrado"),"label"=>"Status","class"=>"Form2Blocos","value" => $dados["emAberto"]));
echo $form->close("Salvar",array("class"=>"botao"));
break;
case "grid":
           echo $xgrid->start($statuGrid)
                ->caption("Status Interno")
                ->noData('Nehum registro encontrado!')
                ->col("nome")->title("Nome")
                ->col("emAberto")->title("Status")->conditions("emAberto",array('1'=>'Em Aberto','2'=>'Encerrado'))
                ->col("Editar")->title("")->cell("mais.png", "javascript:AbreJanela('/eticket/status/novo/{id}',450,200,'Editar Status de Chamado Departamental');")
                ->col("id")->hidden()
                ->alternate("grid_claro", "grid_escuro");
    break;
}
?>