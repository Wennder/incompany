<script>
	$(function(){
		$("#contSite").load("/admsite/Pages/grid");
	});
</script>
<?php
$this->pageTitle = "Administração do Site :: Home";

////Título
//echo $html->openTag("h3");
//echo "Categorias";
//echo $html->closeTag("h3");
////Botões
//echo $html->link("Nova Categoria", "javascript:popIn('janelaModal','/admsite/categories/add');",array("class"=>"botao"));
//echo $html->link("Listar Categorias", "/admsite/categories/grid",array("class"=>"botao"));
//echo "<br />";
//echo "<br />";

//Título
echo $html->openTag("div",array("style"=>"width:49%; float:left;"));
echo $html->openTag("h3");
echo "Controle";
echo $html->closeTag("h3");
//Botões
echo $html->link("Nova Página", "/admsite/Pages/add",array("class"=>"botao"));
echo $html->closeTag("div");

echo $html->openTag("div",array("id"=>"contSite","style"=>"width:50%; float:right;"));
echo $html->closeTag("div");
echo "<br />";
echo "<br />";
?>