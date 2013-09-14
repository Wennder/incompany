<div id="slideAniversariantes">
    <h3>Aniversariantes do Mês</h3>
    <ul class="holderAniversariantes">
        <?php
        foreach ($aniversariantes as $aniversariante) {
            if(substr_count($aniversariante["foto"]["file"], "images")>0){
                $foto = $aniversariante["foto"]["file"];
            }else{
                $foto = $assistec->getPhoto($aniversariante["foto"]);
                $foto = "/images".$foto["url"];
            }
            echo $html->openTag("li",array("style"=>"background-size:cover;background-position:center;background-repeat:no-repeat;background-image:url({$foto});"));
            $nome = explode(" ",$aniversariante["nome"]);
            echo $html->div($aniversariante["dia"]." - ".$nome[0], array("class" => "nome"));
            echo $html->closeTag("li");
        }
        ?>
    </ul>
</div>