<script>
	$(function(){
		$("#contIntervencoes").load("/ferramentas/intervencaoFiscal/grid");
	});
</script>

<?php
$this->pageTitle = "Ferramentas :: Home";

echo $html->openTag("h3");
echo "Ferramentas do Sistema";
echo $html->closeTag("h3");

echo $html->link("Agenda de Compromissos","/agenda",array("class"=>"botao"));
echo $html->link("Equipe","/ferramentas/equipe",array("class"=>"botao"));

echo "<br /> <br />";
if ($loggedUser["interventor"]==1){ //Verifica se é interventor
echo $html->openTag("div", array("style" => "width:41%; float:left;"));
echo $html->openTag("h3");
echo "Intervenção Fiscal";
echo $html->closeTag("h3");

echo $html->link("Nova","javascript:AbreJanela('/ferramentas/intervencaoFiscal/form/n',700,560,'Visualização de Intervenção Fiscal');",array("class"=>"botao"));
echo $html->link("Buscar","javascript:AbreJanela('/ferramentas/intervencaoFiscal/formBusca/n',470,200,'Busca de Intervenções Fiscais');",array("class"=>"botao"));
echo $html->closeTag("div");

echo $html->openTag("div", array("style" => "width:58%; float:right;","id"=>"contIntervencoes"));

echo $html->closeTag("div");
}
?>