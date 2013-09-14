<script>
    $(function() {
    $("#Fich").dialog({
                height: 280,
                width:550,
                modal: true,
                autoOpen:false,
                beforeClose:function(){
                    $("#Fich").html("");
                }
        });
    });
</script>
<div class="borda">
    <div class="titulo">Buscar</div>
    <?php
    echo $form->create();
    echo $form->input("nome",array("type"=>"text","class"=>"Form2Blocos","label"=>"Digite o Nome / Sobrenome ou parte dele"));
    echo $form->close("Buscar");
    ?>

</div>
<br><br>
<div class="borda">
    <?php
    //pr($dadosFuncionario);
    echo $xgrid->start($dadosFuncionario)
            ->caption("Resultados da busca")
            ->hidden(array('grupo_empresa','empresa','financeiro_bancos','gerente_funcionario','rh_setor','foto'))
            ->col('id')->hidden()
            ->col('username')->hidden()
            ->col('nome')->title('Nome')
            ->col('nome')->slice(50)
            ->col('rh_setor_id')->hidden()
            ->col(' ')->conditions('id', array(
                  ">=1" => array("label"=>"mais.png","href"=>"javascript:popIn('Fich','/rh/fichaFuncionario/{id}');","border"=>"0")
            ))            
            ->noData('Aguardando busca...')
            ->alternate("grid_claro","grid_escuro");
    ?>
</div>
<div id="Fich" title="Agenda"></div>