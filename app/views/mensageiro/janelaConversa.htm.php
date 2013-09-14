<?php
$idJanela = "conversa".$conversa;
$idForm = $assistec->criaSenha();
$idMsg = $assistec->criaSenha();
?>
<div id="<?php echo $idJanela ?>" class="borda" style=" height:250px; overflow:scroll ;">

</div>
<script type="text/javascript">
    $("button,.botao, input:submit, input:button, button", "html").button();
     $(document).ready(function() {
                $("#<?php echo $idJanela ?>").load("/mensageiro/mensagensConversa/<?php echo $conversa ?>");
        });  
</script>


<div class="borda" style="margin-top: 10px;"  >

    <script type="text/javascript">
        $(document).ready(function() {
            // bind 'myForm' and provide a simple callback function
            $('#<?php echo $idForm ?>').ajaxForm(function() {
            $("#<?php echo $idJanela ?>").load("/mensageiro/mensagensConversa/<?php echo $conversa ?>");
            $('#<?php echo $idMsg ?>').val("");
            });
            $('#<?php echo $idMsg ?>').bind('keypress', function(e) {
                    if(e.keyCode==13){
                            $('#<?php echo $idForm ?>').trigger('submit');
                    }
            });

        });
        setInterval(
                                function ()
                                {
                                    $("#<?php echo $idJanela ?>").load("/mensageiro/mensagensConversa/<?php echo $conversa ?>");
                                }, 5000);
    </script>

    <?php
    echo $form->create("/mensageiro/gravarMensagem/" . $conversa, array("id" => $idForm));
    echo $form->input("msg", array("id"=>$idMsg,"type" => "textarea","style"=>"resize:none; float:left;", "cols" => "45", "rows" => "3","label" => false));
    echo $form->close("Enviar", array("style" => "height:50px;"));
    ?>
    <br clear="all">
</div>  