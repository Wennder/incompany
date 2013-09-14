<?php
foreach($mensageiro->mensagens($conversa) as  $mensagem){
    $texto = str_replace("\r\n", "<br/>", $mensagem["msg"]);
    $smiles = array(
        "=)"=>"<img src='/images/smiles/smile.gif'/>",
        "..l.."=>"<img src='/images/smiles/dedo.jpg'/>",
        "=$"=>"<img src='/images/smiles/msp_blushing.gif'/>",
        "Oo"=>"<img src='/images/smiles/msp_blink.gif'/>",
        "¬¬'"=>"<img src='/images/smiles/msp_glare.gif'/>",
        "=P"=>"<img src='/images/smiles/msp_razz.gif'/>",
        "OMG"=>"<img src='/images/smiles/msp_ohmy.gif'/>",
        "=("=>"<img src='/images/smiles/msp_sad.gif'/>",
        "okok"=>"<img src='/images/smiles/msp_thumbsup.gif'/>",
        "=,("=>"<img src='/images/smiles/msp_crying.gif'/>",
        "=|"=>"<img src='/images/smiles/msp_mellow.gif'/>",
        "tuto"=>"<img src='/images/smiles/tuto.jpg'/>",
        "tatata"=>"<img src='/images/smiles/tatata.gif'/>",
       

        
    );
    foreach ($smiles as $txt=>$icon){
        $texto = str_replace($txt,$icon,$texto);
    }
    if($mensagem["lido"]==0 && $mensagem["destinatario"]==$loggedUser["id"]){
        $mensageiro->setLido($mensagem["id"]);
    }
    echo $texto;
} 
//pr($mensageiro->mensagens($conversa));
?>