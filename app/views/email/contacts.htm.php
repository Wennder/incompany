<script>
    $(function(){
        $("#addDestinatario").ajaxForm(function(data){
            alert(data);
            $("").load("/email/contacts/list/<?php echo $mensagem; ?>");
        });
    });
    
</script>

<?php
echo $html->openTag("ul", array("class" => "token-input-list"));
if (count($dadosGrid) == 0) {
    echo $html->tag("li", $html->tag("p", "Nenhum Contato Selecionado"), array("class" => "token-input-token"));
}
foreach ($dadosGrid as $contato) {
    echo $html->tag("li", $html->tag("p", (empty($contato["contato"]["nome"])) ? $contato["email"] : $contato["contato"]["nome"]) . $html->tag("span", $html->link("x", "javascript:delAjax('/email/contacts/deletar/{$contato["id_destinatario"]}','auxEmail', '/email/contacts/list/{$mensagem}');"), array("class" => "token-input-delete-token")), array("class" => "token-input-token"));
}
echo $form->create("/email/contacts/add/$mensagem", array("id" => "addDestinatario"));
echo $html->tag("li", $form->input("email", array("label" => false, "placeholder" => "Digite o Email", "div" => false, "style" => "outline: none; width: 170px; float:left;")) . $form->input("", array("type" => "image", "src" => "/images/addContato.png", "div" => false, "value" => "submit", "style" => "width:29px;height:26px; float:right; padding:0;")), array("class" => "token-input-input-token token-input-highlighted-token"));
echo $form->close(null);
echo $html->closeTag("ul");
?>
