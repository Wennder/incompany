<div class="content_conteudo">
<?php
    echo $conteudo["conteudo"];
    echo "<br clear='all' />";
    echo "Ultima Alteração: ".$date->format("d/m/Y H:i:s", $conteudo["modified"]);
?>
</div>