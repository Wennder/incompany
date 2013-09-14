<div class="borda">
    <?php
    $avisoM = str_replace("\r\n", "<br/>", $aviso["mensagem"]);
    echo "<b style='font-size:1.2em;'>" . $aviso['titulo'] . "</b> <br><br>";
    echo $avisoM . "<br><br>";
    echo "<b>Enviado em " . $date->format("d/m/Y", $aviso["created"]) . " as " . $date->format("H:i", $aviso["created"]) . "</b>";
    ?>
</div>