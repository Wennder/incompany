<script>
$(function(){
$("button,.botao, input:submit, input:button, button", "html").button();
    $("input:text").setMask();
    
    $("#btnNovo").click(function(){
        $("#cadDpto").dialog('open');
    });
    
    $("#cadPerfil").ajaxForm(function(){
        alert("Salvo com sucesso!");
        loadDiv("#contAdmin","/admin/permissoes/grid");
    });
});
   
</script>
<style>
input[type='checkbox']{
float:left;
clear: left;
}
</style>
<?php
switch ($op){
case "grid":
	echo $xgrid->start($gridPermissoes)
	    ->caption('Perfis Cadastrados')
	    ->col('nome')->title('Nome')
	    ->col('id')->hidden()
	    ->col('paginas')->hidden()
	    ->col('created')->hidden()
	    ->col("modified")->hidden()
	    ->col("editar")->title()->cell("editar.png","javascript:AbreJanela('/admin/permissoes/novo/{id}', 500, 500, 'Editar Perfil {nome}', null, true);")
	    ->col('deletar')->title()->cell("deletar.png","javascript:delAjax('/admin/permissoes/deletar/{id}','contAdmin','/admin/permissoes/');")
	  
	    ->noData('Nenhum registro encontrado')
	    ->alternate("grid_claro","grid_escuro");
break;
case "novo":
	?>
	<div id="cadDpto" title="Cadastrar Departamento">
    <?php
    
    echo $form->create("",array("id"=>"cadPerfil"));
    echo $html->openTag("div",array("style"=>"width:49%; float:left;"));
    echo $form->input("nome", array("type"=>"text", "label"=>"Perfil", "class"=>"Form1Bloco","value"=>$dadosForm["nome"]));
    echo $html->closeTag("div");
    
    echo $html->openTag("div",array("style"=>"width:49%; float:right; border-left:1px solid #f0f0f0;"));
    
    foreach($paginas as $cod=>$pagina){
   
   	$checado = substr_count($dadosForm["paginas"],$cod);
   	$paramField = array("type"=>"checkbox","label"=>$pagina[0],"value"=>$cod);
   	if($checado==1){
   	$paramField["checked"]="true";
   	}
    	echo $form->input("pagina[]",$paramField);
    	
    	unset($checado);
    	unset($paramField);
    
    }
    echo $html->closeTag("div");
    echo "<br clear='all' />";
    if (!isset($idDepto)){
        echo $form->close("Inserir",array("class"=>"botao","style"=>"float:right;"));
    }else{
        echo $form->close("Salvar",array("class"=>"botao","style"=>"float:right;"));
    }
    ?>
</div>
	<?php
break;
}
    ?>