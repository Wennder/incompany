<?php
echo $form->input("anexo", array("div" => "bgUpload", "type" => "file", "id" => "file-original", "label" => false, "onchange" => "document.getElementById('file-falso').value = this.value;"));
echo $form->input("file-falso", array("type" => "text", "id" => "file-falso", "label" => false));
echo $form->close("Salvar");
?>
