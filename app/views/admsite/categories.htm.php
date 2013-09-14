<script>
    $(function(){
       $("button,.botao, input:submit, input:button, button", "html").button();
       $("input:text").setMask(); 
    });
</script>
<?php

switch ($op) {
    
    case "add":
        echo $form->create();
        echo $form->input("nome",array("class"=>"Form2Blocos", "maxlength"=>"45", "value"=>$dadosForm["nome"]));
        echo $form->input("tags",array("class"=>"Form2Blocos", "maxlength"=>"45","value"=>$dadosForm["tags"]));
        echo $form->close("Salvar",array("class"=>"botao"));
        
        break;
    default:
    case "grid":
        echo $xgrid->start($dadosGrid);
        break;
}
?>
