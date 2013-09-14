<script>
$("button,.botao, input:submit, input:button, button", "html").button();
    $("input:text").setMask();
</script>
<?php
        echo $form->create('/solicitacoes/geradas/');
        echo $form->input('gerente', array("type" => "select", "label" => "Funcionário / Gerente", "class" => "Form2Blocos", "options" => $gerentes));
        echo $form->input('dataInicio', array("label" => "Data Inicial", "div" => "ladoalado", "class" => "Form1Bloco", "alt" => "date", "value" => date("d/m/Y", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")))));
        echo $form->input('dataFim', array("label" => "Data Final", "class" => "Form1Bloco", "alt" => "date", "value" => date("d/m/Y")));
        echo $form->input("status", array("type" => "select", "label" => "Status", "class" => "Form1Bloco", "options" => $statusDespesa));
        echo "<br />";
        echo "<center>";
        echo $form->close("Filtrar", array("class" => "Form1Bloco"));
        echo "</center>";
?>