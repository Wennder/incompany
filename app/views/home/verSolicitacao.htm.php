<script type="text/javascript">
    $(document).ready(function() {
        $("#versolicitacao").validate({
            rules: {
                descricao:{
                    required:true
                }
            },
            messages: {
                  descricao:{
                    required:"Escreva uma resposta."
                 }
            }
        });
    });
</script>
<div class="titulo">Acompanhamento de Solicitação</div>
<?php
if (!empty($solicitacao["id"])){
echo "<div class='FormMeioBloco ladoalado'><b>Protocolo:</b> </div><div class='Form1Bloco ladoalado'>#".$solicitacao["id"]."</div>";
echo "<div class='FormMeioBloco ladoalado'><b>Data de criação:</b> </div><div class='FormMeioBloco ladoalado'>".$date->format("d/m/Y",$solicitacao["created"])."</div><br/>";
echo "<div class='FormMeioBloco ladoalado'><b>Dpto.:</b> </div><div class='Form1Bloco ladoalado'>".$deptoAtendimento[$solicitacao["rh_setor_id"]]."</div>";
echo "<div class='FormMeioBloco ladoalado'><b>Status:</b> </div>".$statusAtendimento[$solicitacao["status_id"]]."<br/>";
echo "<div class='FormMeioBloco ladoalado'><b>Assunto:</b> </div>".$solicitacao["assunto"]."<br/>";
?>
<fieldset>
    <legend><b>Solicitação</b></legend>
    <?php
    echo $solicitacao["descricao"];
    ?>
</fieldset>
<br/>
<div class="titulo">Atendimentos</div>
<?php
$count = count($respostas);
if($count > 0){
//Foreach
?>
<div class="tituloChamado"></div>
<div class="descricao"></div>
<?php
}else{
    echo "<b>Ainda não há nenhuma resposta para sua solicitação</b>";
}
?>
<br/>
<br/>
<?php
echo $form -> create("", array("id" => "versolicitacao"));
echo $form -> input("descricao",array("type"=>"textarea","rows"=>"4","label"=>"Responder","class"=>"Form2Blocos"));
echo $html->link("Cancelar","/home/minhasSolicitacoes",array("class"=>"botao"));
echo $form -> close("Enviar",array("div"=>"ladoalado"));
}else{
    echo "<b>Essa solicitação não existe, ou você não tem permissão para vê-la</b>";
}
?>
