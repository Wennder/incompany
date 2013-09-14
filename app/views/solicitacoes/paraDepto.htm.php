<script>
    $(function(){
        $("#nHoraExtra").dialog({
          height: 280,
          width:470,
          modal: true,
          autoOpen:false
        });

        $("#abreHora").click(function(){
            $("#nHoraExtra").dialog('open');
        });
        
    });

    $(document).ready(function() {
	$("#novasolicitacao").validate({
            errorContainer: "#errConteiner",
		rules: {
			rh_setor_id: {
                               selectRequerido:0
			},
                       assunto: {
                               required:true
			},
                       descricao: {
                               required:true
			}
		},
		messages: {
                      rh_setor_id: {
                               selectRequerido: "Selecione um departamento."
			},
                       assunto: {
                               required:"Digite qual é o assunto."
			},
                       descricao: {
                               required:"Digite a descrição."
			}
		}
	});
});
   
    
</script>

<div class="borda">
    <div class="titulo"> Minhas Solicitações</div>
    <?php
        echo $xgrid->start($pedidosHora)
            ->col('usuario')->hidden()
            ->col('funcionario')->position(7)
            ->col("funcionario")->conditions('beneficiario',$funcionariosCad)
            ->col('status')->hidden()
            ->col("id")->title('ID')
            ->col("created")->position(9)
            ->col('beneficiario')->hidden()
            ->col('created')->hidden()
            ->col('horaInicio')->date("d/m/Y h:i")
            ->col('horaFim')->date("d/m/Y h:i")
            ->col('Estado')->conditions('status_id', $statusDespesa)
            ->footer('valor')->sumReal() //Função desenvolvida com a finalide de fazer a soma de valores reais.
            ->noData('Nenhum Pedido Encontrado')
            ->alternate("grid_claro","grid_escuro"); 
    ?>
    <a class="botao" id="abreHora">Novo</a>
</div>

<div id="nHoraExtra" title="Nova Solicitação para Departamento">
    <?php
        echo $form->create("",array("id"=>"novasolicitacao"));
        echo $form->input("user_id",array("type"=>"hidden","value"=>$loggedUser["id"]));
        echo $form->input("rh_setor_id",array("type"=>"select","label"=>"Departamento","options"=>$departamentos,"class"=>"Form2Blocos"));
        echo $form->input("assunto",array("type"=>"text","label"=>"Assunto","class"=>"Form2Blocos"));
        echo $form->input("descricao",array("type"=>"textarea","label"=>"Descrição","class"=>"Form2Blocos"));
        echo "<center>";
        echo $form->close("Salvar",array("class"=>"Form1Bloco"));
        echo "</center>";
    ?>

</div>
