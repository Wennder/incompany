<div class="newsInfo">
    <div class="tituloInfo">Notícias</div>
<?php
$feed = file_get_contents('http://rss.tecnologia.uol.com.br/ultnot/index.xml');
$rss = new SimpleXmlElement($feed);
$conta = 0;
foreach($rss->channel->item as $entrada) {
echo '<p><a href="' . $entrada->link . '" title="' . $entrada->title . '" target=\'_blank\'>' . $entrada->title . '</a></p>';
$conta ++;
    if($conta == 6){
        break;
    }
}
?>
    <div style="float:right;">Fonte: Uol Tecnologia</div>
</div>
<br clear="all" />