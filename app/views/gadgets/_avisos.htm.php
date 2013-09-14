<script>
    jQuery(document).ready(function() {
        jQuery('#slideTopo').jCarouselLite({
            vertical: true,
            scroll: 1,
            auto:5000,  
            speed:1000,
            height:98,
            visible:1
            
        });
    });
</script>

<?php
echo $html->openTag("div",array("id"=>"slideTopo"));
echo $html->openTag("ul", array("style" => "margin:0;list-style:none; margin-bottom:5px;"));
foreach ($assistec->avisosUsuario($setor) as $aviso) {
    echo $html->openTag("li");
    echo "<strong>" . $date->format("d/m/Y", $aviso["created"]) . "</strong>";
    echo $html->openTag("p").$assistec->cortaTexto("40", "... &nbsp;&nbsp;&nbsp;" . $html->link("[Leia +]", "javascript:popIn('janelaModal','/home/lerMensagem/{$aviso["id"]}');"), $aviso["mensagem"]).$html->closeTag("p");
    echo $html->closeTag("li");
}
echo $html->closeTag("ul");
echo $html->closeTag("div");
?>


