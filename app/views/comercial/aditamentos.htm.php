<script type="text/javascript">
    $(function() {
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        $("#FormAditamento").ajaxForm(function() {
            alert("Aditamento cadastrado com Sucesso!!!");
            $("#cadAditamento").dialog('close');
            return false;
        });

        });
</script>
<?php
switch ($op) {
    case "novo":
        ?>
        <script type="text/javascript">
    $(function() {
               $('textarea.editor').ckeditor();
    });
</script>
            <?php
        echo $form->create("", array("id" => "FormAditamento"));
        echo $form->input("titulo", array("type" => "text", "label" => "Titulo do Aditamento", "class" => "Form2Blocos", "value" => $dadosAditamento['titulo']));
        echo $form->input("descricao", array("type" => "text", "label" => "Descricao", "class" => "Form2Blocos", "value" => $dadosAditamento['descricao']));
        echo $form->input("minuta", array("type" => "textarea", "label" => "Minuta", "class" =>"Form2Blocos editor", "value" => $dadosAditamento['minuta']));
        echo $form->input("valor", array("type" => "text","alt"=>"moeda", "label" => "Valor", "class" => "Form1Bloco", "div" => "ladoalado", "value" => $dadosAditamento['valor']));
        echo $form->input("inicioVigencia", array("type" => "text","alt"=>"date", "label" => "Vigência", "class" => "Form1Bloco", "value" => $dadosAditamento['inicioVigencia']));
        echo $form->close("Salvar");
        break;
    case "grid":
        echo $xgrid->start($gridAditamento)
                ->caption("Aditamentos")
                ->noData("Não nenhum registro")
                ->col('id')->hidden()
                ->col('contrato_id')->hidden()
                ->col('modified')->hidden()
                ->col('minuta')->hidden()
                ->col('titulo')->title("Titulo")
                ->col('descricao')->title("Descrição")->slice(20)
                ->col('valor')->title("Valor")
                ->col('inicioVigencia')->title('Vigência')->date('d/m/Y', 'inicioVigencia')
                ->col('created')->title("Cadastrado")->date('d/m/Y', 'created')
                ->col("editar")->title("")->conditions("id", array(">=1" => array("label" => "editar.gif", "href" => "javascript:popIn('cadAditamento','/comercial/aditamentos/{contrato_id}/novo/{id}');", "border" => "0")))
                ->col("imprime")->title("")->conditions("id", array(">=1" => array("label" => "icone_imprimir.gif", "href" => "/comercial/aditamentos/{contrato_id}/ver/{id}", "border" => "0")))
               ->col('excluir')->title("")->conditions('id', array(
                    ">=1" => array("label" => "deletar.png", "href" => "javascript:delAjax('/comercial/aditamentos/{contrato_id}/deletar/{id}','gridAditamento','/comercial/aditamentos/{contrato_id}/grid')", "border" => "0")
                ))
                ->alternate("grid_claro", "grid_escuro");
        break;
    case "ver":
        //pr($dadosAditamento);

        ?>
<div id></div>
                <table border="1">
                <tr>
                    <td><center><h2><?php echo $dadosAditamento['titulo'];?></h2></center></td>
                </tr>
                <tr>
                    <td><?php echo $dadosAditamento['minuta'];?></td>
                </tr>
               
        </table>


<?php
        break;
}
?>
