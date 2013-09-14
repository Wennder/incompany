<style>
.FormMMeioBloco{
	width: 75px;
}
</style>
<script>
$(function(){
    $("button,.botao, input:submit, input:button, button", "html").button();
    $("input:text").setMask();
    $("#tabIntervencao").tabs();
    

    
    $(".save").button({  
    icons: {  
         primary: "ui-icon-disk"  
    },  
    text:false  
}); 
    <?php
    	if($readOnly){ 
    	?>
    	    $("input, select").attr("disabled", "true");
    	    $("input[type='submit'],button[type='submit']").attr("disabled", "true");
        <?php
    	}
    ?>
});
    function saveForm(){
    	$('#formIntervencao').submit();
    }
</script>
<?php
$this->pageTitle = "Ferramentas :: Intervenção Fiscal";

switch($op){
    case "formBusca":
    	echo $form->create("/ferramentas/intervencaoFiscal/grid");
    	echo $form->input("id_formulario",array("alt"=>"int","label"=>"Nº Intervenção"));
    	echo $form->input("id_cliente",array("type"=>"select","class"=>"Form2Blocos","options"=>$listClientes,"label"=>"Cliente"));
    	echo $form->close("Buscar",array("class"=>"botao"));
    break;
    
    case "form":
    	echo $form->create("",array("id"=>"formIntervencao"));
    	echo $html->openTag("div",array("id"=>"tabIntervencao"));
		
		echo $html->openTag("ul");
		echo $html->tag("li","<a href='#userEquip' >Cliente e Equipameto</a>",array(),false);
		echo $html->tag("li","<a href='#totalizadores'>Totalizadores</a>",array(),false);
		echo $html->tag("li","<a href='#seguranca'>Segurança</a>",array(),false);
		echo $html->tag("li","<a href='#final'>Final</a>",array(),false);
		echo $html->link("","javascript:saveForm();",array("class"=>"save","style"=>"float:right; height:30px;"));
		echo $html->closeTag("ul");
		
		echo $html->openTag("div",array("id"=>"userEquip"));	        
		        echo $form->input("nFormulario",array("label"=>"Nº Formulário","class"=>"FormMeioBloco","value"=>$dadosForm["nFormulario"]));
		        echo $form->input("id_cliente",array("label"=>"Cliente","type"=>"select","options"=>$listClientes,"class"=>"Form12Blocos","value"=>$dadosForm["id_cliente"]));
		        echo $form->input("marcaEcf",array("label"=>"Marca","class"=>"FormMeioBloco","div"=>"ladoalado","value"=>$dadosForm["marcaEcf"]));
		        echo $form->input("modeloEcf",array("label"=>"Modelo","class"=>"FormMeioBloco","div"=>"ladoalado","value"=>$dadosForm["modeloEcf"]));
		        echo $form->input("nOrdem",array("label"=>"Nº Ordem","class"=>"FormMeioBloco","value"=>$dadosForm["nOrdem"]));
		        echo $form->input("nFabricacao",array("label"=>"Nº Fabricacao","class"=>"FormMeioBloco","div"=>"ladoalado","value"=>$dadosForm["nFabricacao"]));
		        echo $form->input("versaoA",array("label"=>"V. Encontrada","class"=>"FormMeioBloco","div"=>"ladoalado","value"=>$dadosForm["versaoA"]));
		        echo $form->input("versaoD",array("label"=>"V. Atual","class"=>"FormMeioBloco","value"=>$dadosForm["versaoD"]));
		        echo $form->input("inicioIntervencao",array("style"=>"width:153px","label"=>"Inicio Intervenção","alt"=>"date","div"=>"ladoalado","value"=>$dadosForm["inicioIntervencao"]));
		        echo $form->input("fimIntervencao",array("style"=>"width:153px","label"=>"Término Intervenção","alt"=>"date","value"=>$dadosForm["fimIntervencao"]));
		        echo $form->input("mfdA",array("style"=>"width:153px","label"=>"MFD Retirada","div"=>"ladoalado","value"=>$dadosForm["mfdA"]));
		        echo $form->input("mfdD",array("style"=>"width:153px","label"=>"MFD Colocada","value"=>$dadosForm["mfdD"]));
	        echo $html->closeTag("div");
	        
	        echo $html->openTag("div",array("id"=>"totalizadores"));
	            echo $html->openTag("div",array("style"=>"height:340px;overflow-y:auto;overflow-x:hidden;float:left; width: 40%; border:1px solid #DDDDDD;"));
	        	echo $form->input("vGeralA",array("value"=>$dadosForm["vGeralA"],"alt"=>"moeda","label"=>"Geral Antes","class"=>"FormMeioBloco","div"=>"ladoalado"));
	        	echo $form->input("vGeralD",array("value"=>$dadosForm["vGeralD"],"alt"=>"moeda","label"=>"Geral Depois","class"=>"FormMeioBloco"));
	        	echo $form->input("brutaA",array("value"=>$dadosForm["brutaA"],"alt"=>"moeda","label"=>"V. Bruta Antes","class"=>"FormMeioBloco","div"=>"ladoalado"));
	        	echo $form->input("bruraD",array("value"=>$dadosForm["brutaD"],"alt"=>"moeda","label"=>"V. Bruta Depois","class"=>"FormMeioBloco"));
	        	echo $form->input("liquidaA",array("value"=>$dadosForm["liquidaA"],"alt"=>"moeda","label"=>"Liquida Antes","class"=>"FormMeioBloco","div"=>"ladoalado"));
	        	echo $form->input("liquidaD",array("value"=>$dadosForm["liquidaD"],"alt"=>"moeda","label"=>"Liquida Depois","class"=>"FormMeioBloco"));
	        	echo $form->input("cancelamentoA",array("value"=>$dadosForm["cancelamentoA"],"alt"=>"moeda","label"=>"Cancel. Antes","class"=>"FormMeioBloco","div"=>"ladoalado"));
	        	echo $form->input("cancelamentoD",array("value"=>$dadosForm["cancelamentoD"],"alt"=>"moeda","label"=>"Cancel. Depois","class"=>"FormMeioBloco"));
	        	echo $form->input("descontoA",array("value"=>$dadosForm["descontoA"],"alt"=>"moeda","label"=>"Desc. Antes","class"=>"FormMeioBloco","div"=>"ladoalado"));
	        	echo $form->input("descontoD",array("value"=>$dadosForm["descontoD"],"alt"=>"moeda","label"=>"Desc. Depois","class"=>"FormMeioBloco"));
	        	echo $form->input("stA",array("value"=>$dadosForm["stA"],"alt"=>"moeda","label"=>"S.T. Antes","class"=>"FormMeioBloco","div"=>"ladoalado"));
	        	echo $form->input("stD",array("value"=>$dadosForm["stD"],"alt"=>"moeda","label"=>"S.T. Depois","class"=>"FormMeioBloco"));
	        	echo $form->input("isentasA",array("value"=>$dadosForm["isentasA"],"alt"=>"moeda","label"=>"Isentas Antes","class"=>"FormMeioBloco","div"=>"ladoalado"));
	        	echo $form->input("isentasD",array("value"=>$dadosForm["vGeralD"],"alt"=>"moeda","label"=>"Isentas Depois","class"=>"FormMeioBloco"));
	        	echo $form->input("naoIncidenciaA",array("value"=>$dadosForm["naoIncidenciaA"],"alt"=>"moeda","label"=>"N. Inci. Antes","class"=>"FormMeioBloco","div"=>"ladoalado"));
	        	echo $form->input("naoIncidenciaD",array("value"=>$dadosForm["naoIncidenciaD"],"alt"=>"moeda","label"=>"N. Inci. Depois","class"=>"FormMeioBloco"));
	        	echo $form->input("acrescimoA",array("value"=>$dadosForm["acrescimoA"],"alt"=>"moeda","label"=>"Acrescimo Antes","class"=>"FormMeioBloco","div"=>"ladoalado"));
	        	echo $form->input("acrescimoD",array("value"=>$dadosForm["acrescimoD"],"alt"=>"moeda","label"=>"Acrescimo Depois","class"=>"FormMeioBloco"));
	        	echo "<br />";
	            echo $html->closeTag("div");
	            
	             echo $html->openTag("div",array("style"=>"height:340px;overflow-y:auto;overflow-x:hidden;float:right; width: 58%; border:1px solid #DDDDDD;"));
	             	
	             	echo $form->input("tributado1",array("value"=>$dadosForm["tributado1"],"alt"=>"moeda","label"=>"Tributado %","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoTipo1",array("value"=>$dadosForm["tributadoTipo1"],"type"=>"select","options"=>array("","ICMS","ISS"),"label"=>"Imposto","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoA1",array("value"=>$dadosForm["tributadoA1"],"alt"=>"moeda","label"=>"Antes","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoD1",array("value"=>$dadosForm["tributadoD1"],"alt"=>"moeda","label"=>"Depois","class"=>"FormMMeioBloco"));
	             	
	             	echo $form->input("tributado2",array("value"=>$dadosForm["tributado2"],"alt"=>"moeda","label"=>"Tributado %","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoTipo2",array("value"=>$dadosForm["tributadoTipo2"],"type"=>"select","options"=>array("","ICMS","ISS"),"label"=>"Imposto","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoA2",array("value"=>$dadosForm["tributadoA2"],"alt"=>"moeda","label"=>"Antes","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoD2",array("value"=>$dadosForm["tributadoD2"],"alt"=>"moeda","label"=>"Depois","class"=>"FormMMeioBloco"));
	             	
	             	echo $form->input("tributado3",array("value"=>$dadosForm["tributado3"],"alt"=>"moeda","label"=>"Tributado %","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoTipo3",array("value"=>$dadosForm["tributadoTipo3"],"type"=>"select","options"=>array("","ICMS","ISS"),"label"=>"Imposto","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoA3",array("value"=>$dadosForm["tributadoA3"],"alt"=>"moeda","label"=>"Antes","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoD3",array("value"=>$dadosForm["tributadoD3"],"alt"=>"moeda","label"=>"Depois","class"=>"FormMMeioBloco"));
	             	
	             	echo $form->input("tributado4",array("value"=>$dadosForm["tributado4"],"alt"=>"moeda","label"=>"Tributado %","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoTipo4",array("value"=>$dadosForm["tributadoTipo4"],"type"=>"select","options"=>array("","ICMS","ISS"),"label"=>"Imposto","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoA4",array("value"=>$dadosForm["tributadoA4"],"alt"=>"moeda","label"=>"Antes","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoD4",array("value"=>$dadosForm["tributadoD4"],"alt"=>"moeda","label"=>"Depois","class"=>"FormMMeioBloco"));
	             	
	             	echo $form->input("tributado5",array("value"=>$dadosForm["tributado5"],"alt"=>"moeda","label"=>"Tributado %","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoTipo5",array("value"=>$dadosForm["tributadoTipo5"],"type"=>"select","options"=>array("","ICMS","ISS"),"label"=>"Imposto","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoA5",array("value"=>$dadosForm["tributadoA5"],"alt"=>"moeda","label"=>"Antes","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoD5",array("value"=>$dadosForm["tributadoD5"],"alt"=>"moeda","label"=>"Depois","class"=>"FormMMeioBloco"));
	             	
	             	echo $form->input("tributado6",array("value"=>$dadosForm["tributado6"],"alt"=>"moeda","label"=>"Tributado %","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoTipo6",array("value"=>$dadosForm["tributadoTipo6"],"type"=>"select","options"=>array("","ICMS","ISS"),"label"=>"Imposto","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoA6",array("value"=>$dadosForm["tributadoA6"],"alt"=>"moeda","label"=>"Antes","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoD6",array("value"=>$dadosForm["tributadoD6"],"alt"=>"moeda","label"=>"Depois","class"=>"FormMMeioBloco"));
	             	
	             	echo $form->input("tributado7",array("value"=>$dadosForm["tributado7"],"alt"=>"moeda","label"=>"Tributado %","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoTipo7",array("value"=>$dadosForm["tributadoTipo7"],"type"=>"select","options"=>array("","ICMS","ISS"),"label"=>"Imposto","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoA7",array("value"=>$dadosForm["tributadoA7"],"alt"=>"moeda","label"=>"Antes","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoD7",array("value"=>$dadosForm["tributadoD7"],"alt"=>"moeda","label"=>"Depois","class"=>"FormMMeioBloco"));
	             	
	             	echo $form->input("tributado8",array("value"=>$dadosForm["tributado8"],"alt"=>"moeda","label"=>"Tributado %","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoTipo8",array("value"=>$dadosForm["tributadoTipo8"],"type"=>"select","options"=>array("","ICMS","ISS"),"label"=>"Imposto","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoA8",array("value"=>$dadosForm["tributadoA8"],"alt"=>"moeda","label"=>"Antes","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	             	echo $form->input("tributadoD8",array("value"=>$dadosForm["tributadoD8"],"alt"=>"moeda","label"=>"Depois","class"=>"FormMMeioBloco"));
	             	
	             	
	             echo $html->closeTag("div");
	             
	            echo "<br clear='all' />";
	            
	            echo $html->openTag("div",array("style"=>"float: left;width:32%;height:74px;margin-top: 10px;overflow-y:auto;overflow-x:hidden;border:1px solid #DDDDDD;"));
	            
	            echo $form->input("ordemOperacaoA",array("alt"=>"int","label"=>"Or. Op. Antes","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	            echo $form->input("ordemOperacaoD",array("alt"=>"int","label"=>"Or. Op. Depois","class"=>"FormMMeioBloco"));
	            
	            echo $form->input("contadorReducoesA",array("alt"=>"int","label"=>"Red. Antes","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	            echo $form->input("contadorReducoesD",array("alt"=>"int","label"=>"Red. Depois","class"=>"FormMMeioBloco"));
	            
	            echo $html->closeTag("div");
	            
	            echo $html->openTag("div",array("style"=>"margin-left:1%;float: left;width:32%;height:74px;margin-top: 10px;overflow-y:auto;overflow-x:hidden;border:1px solid #DDDDDD;"));
	            
	            echo $form->input("ordensFiscaisA",array("alt"=>"int","label"=>"Doc. Fiscais A","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	            echo $form->input("ordensFiscaisD",array("alt"=>"int","label"=>"Doc. Fiscais D","class"=>"FormMMeioBloco"));
	            
	            echo $form->input("documentosCanceladosA",array("alt"=>"int","label"=>"Cancel. Antes","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	            echo $form->input("documentosCanceladosD",array("alt"=>"int","label"=>"Cancel. Depois","class"=>"FormMMeioBloco"));
	            
	            echo $html->closeTag("div");
	            
	            echo $html->openTag("div",array("style"=>"float: right;width:33%;height:74px;margin-top: 10px;overflow-y:auto;overflow-x:hidden;border:1px solid #DDDDDD;"));
	            
	            echo $form->input("reinicioOperacaoA",array("alt"=>"int","label"=>"Reinicio Antes","div"=>"ladoalado","class"=>"FormMMeioBloco"));
	            echo $form->input("reinicioOperacaoD",array("alt"=>"int","label"=>"Reinicio Depois","class"=>"FormMMeioBloco"));
	            
	            echo $html->closeTag("div");
	            echo "<br clear='all' />";
	            
	        echo $html->closeTag("div");
	        
	        echo $html->openTag("div",array("id"=>"seguranca"));
	        
	        echo $html->closeTag("div");
	        
	        echo $html->openTag("div",array("id"=>"final"));
	        
	        echo $html->closeTag("div");
	        
	echo $html->closeTag("div");
	echo $form->close();
    break;
    
    case "grid":
    	echo $xgrid->start($dadosGrid)
    	->caption("Ultimas Intervenções")
    	->noData("Nenhum Regisro Encontrado")
    	->alternate("grid_claro","grid_escuro")
    	->hidden(array("id","id_cliente","funcionario_id"))
    	->col("nFormulario")->title("Nº")
    	->col("comercial_clientes")->cellArray("razaoSocial")->title("Cliente")
    	->col("rh_funcionarios")->cellArray("nome")->title("Interventor")
    	->col("editar")->title("")->cell("mais.png","javascript:AbreJanela('/ferramentas/intervencaoFiscal/form/s/{id}',730,560,'Visualização de Intervenção Fiscal');");
    break;
    
    case "imprimirMatricial":
        //aqui
    break;
}
?>