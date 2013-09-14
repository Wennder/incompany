<script>
    $("button,.botao, input:submit, input:button, button", "html").button();
    $("#mapa").hide();
    function showMap(){
        $("#dadosFunc").hide("2000");
        $("#mapa").show("2000");
        
    }
    function hideMap(){
        $("#mapa").hide("2000");
            $("#dadosFunc").show("2000");
    }
</script>
<div id="dadosFunc">
<?php
if (empty($dadoFunc["nome"])){
    echo "<br><br><center>Funcionário não definido</center>";
}else{

     $foto = $assistec->getPhoto($dadoFunc["foto"]["file"]);
      echo $html->image($foto["url"], array("class"=>"ladoalado","width"=>"120","style"=>"padding-right:15px;", "bd" => $foto["bd"]), true);

    if ($loggedUser["permissao"]==4){
        echo "<b>Nome: </b>".$dadoFunc["nome"]."<br>";        
        echo "<b>Tel.: </b>".$dadoFunc["tel"];
        echo "&nbsp&nbsp&nbsp&nbsp<b>Cel.: </b>".$dadoFunc["cel"]."<br><br>";
        echo "<b>E-mail: </b>".$dadoFunc["username"];
    }else{
        echo "<b>Nome: </b>".$dadoFunc["nome"]."<br><br>";
        $endereco = "<b>End.: </b>".$dadoFunc["endereco"]."<br>";
        $endereco .= "<b>Cidade.: </b>".$dadoFunc["cidade"]." / ".$optionsEstados[$dadoFunc["estado"]]."<br><br>";
        echo $html->link($endereco,"javascript:showMap();");
        echo "<b>Tel.: </b>".$dadoFunc["tel"];
        echo "&nbsp&nbsp&nbsp&nbsp<b>Cel.: </b>".$dadoFunc["cel"]."<br><br>";
        echo "<b>E-mail: </b>".$dadoFunc["username"];
    }
   
}

?>
</div>
<div id="mapa">
    <?php
        echo $html->link($html->apiMaps($endereco,520,220),"javascript:hideMap();");
    ?>
</div>