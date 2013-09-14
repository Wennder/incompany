<?php
if(!empty($protocolo)){
     echo "<div class='titulo'><center> Seu protocolo é: #$protocolo </center></div>";
       }else{
?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#novosolicitacao").validate({
            rules: {
                rh_setor_id: {
                    selectRequerido:0
                },
                assunto: {
                    required:true
                },
                descricao:{
                    required:true
                }
            },
            messages: {
                rh_setor_id: {
                    selectRequerido:"Selecione um departamento."
                },
                assunto: {
                    required:"Escreva qual é o assunto."
                },
                descricao:{
                    required:"Escreva a Solicitação."
                 }
            }
        });
    });
</script>

    <div class="titulo">Nova Solicitação</div>
<?php
echo $form -> create("", array("id" => "novosolicitacao"));
echo $form -> input("rh_setor_id",array("type"=>"select","options"=>array("selecione","RH","outro"),"label"=>"Setor","class"=>"Form2Blocos"));
echo $form -> input("assunto",array("type"=>"text","label"=>"Assunto","class"=>"Form2Blocos"));
echo $form -> input("descricao",array("type"=>"textarea","rows"=>"4","label"=>"Solicitação","class"=>"Form2Blocos"));
echo $form -> close("Salvar");

    }
?>