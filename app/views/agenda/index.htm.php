<?php
$this->pageTitle = "Agenda de Compromissos";
echo $html->stylesheet("jquery.weekcalendar.css");
echo $html->script("jquery.weekcalendar.js");
echo $html->script("agenda.js");
?>
<div id="agenda"></div>
<div id="editarCompromisso">
    <form>
        <?php
        echo $form->input("titulo", array("type" => "text", "class" => "Form2Blocos", "label" => "Título"));
        echo $form->input("inicio", array("type" => "select", "class" => "Form1Bloco","div"=>"ladoalado", "label" => "Início"));
        echo $form->input("termino", array("type" => "select", "class" => "Form1Bloco", "label" => "Término"));
        echo $form->input("observacao", array("type" => "textarea", "class" => "Form2Blocos", "label" => "Observação"));
        ?>
    </form>
</div>