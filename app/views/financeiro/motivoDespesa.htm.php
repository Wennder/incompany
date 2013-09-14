<script type="text/javascript">

    $(document).ready(function() {

        $("#motivodes").validate({
            rules: {
                nome: {
                  required: true
          
                }


            },
            messages: {
                nome: {
                    required:"Digite o Nome."
                

                }
            }

        });
    });
</script>

    <?php
    $this->pageTitle = "Financeiro :: Motivos de Despesa";
    echo $form->create("", array("id" => "motivodes"));
    echo $form->input("nome", array("type" => "text","div"=>"ladoalado", "label" => "Nome", "class" => "Form1Bloco", "div" => "ladoalado"));
  
    echo $form->close("Salvar");
    ?>
<br />
<div class="borda ui-corner-all">
    <?php
    echo $xgrid->start($dadosMotivos)
        ->caption('Motivos de Despesas')
        ->col('nome')->title('Nome')
        ->col('id')->hidden()
            ->col("ativo")->conditions("ativo",$bool)
        ->col('created')->hidden()
        ->col('Ação')->conditions('id', array(
     '<= 6' => array('label'=>"deletar.png","href"=>"javascript:deletar('/financeiro/delMotivo/{id}');","border"=>"0"),
     '> 6' => array('label'=>"deletar.png","href"=>"javascript:deletar('/financeiro/delMotivo/{id}');","border"=>"0")
  ))
        ->noData('Nenhum registro encontrado')
        ->alternate("grid_claro","grid_escuro");
    ?>
</div>