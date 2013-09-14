<script type="text/javascript">
    $(document).ready(function() {
    $("button,.botao, input:submit, input:button, button", "html").button();
    $("input:text").setMask();
    
        $("#aviso").validate({
            rules: {
                titulo: {
                    required:true
                },
                mensagem: {
                    required:true
                }
            },
            messages: {
                titulo: {
                    required:"Adicione um Título em sua mensagem."
                },
                mensagem: {
                    required:"Escreva uma mensagem."
                }
            }
        });
        
    });
</script>
    <?php
    echo $form->create("", array("id" => "aviso", "class"=>"formee"));
    echo $form->input("rh_setor_id", array("type" => "select", "label" => "Depto", "div" => "grid-4-12", "options" => $listDepartamentos));
    echo $form->input("titulo", array("type" => "text", "label" => "Título", "div" => "grid-8-12"));
    echo $form->input("mensagem", array("type" => "textarea", "label" => "Mensagem", "div" => "grid-12-12"));
    echo $form->close("Enviar",array("class"=>"botao"));
    ?>