<?php
$cont =0;
foreach ($compromissos as $compromisso){
$email->IsSMTP(); // mandar via SMTP
$email->ClearAddresses();
$email->AddAddress($compromisso["rh_funcionarios"]["username"],$compromisso["rh_funcionarios"]["nome"]);
$email->WordWrap = 50; // set word wrap
$email->IsHTML(true); // send as HTML
$email->Subject = "Agenda de Compromissos";
$email->Body = "<strong>Lembrete do Compromisso:</strong>"
        .$compromisso["titulo"]."<br/>"
        ."<strong>Início:</strong>".$date->format("d/m/Y H:i",$compromisso["inicio"])
        ."<br/><strong>Descriçao do Compromisso</strong>:<br/>"
        .$compromisso["observacao"];

$email->AltBody = "Lembrete do Compromisso: "
        .$compromisso["titulo"]
        .chr(13)
        ."Início:".$date->format("d/m/Y H:i",$compromisso["inicio"])
        .chr(13)
        ."Descrição:"
        .chr(13)
        .$compromisso["observacao"];

if(!$email->Send())
{
echo "A mensagem não pode ser enviada

";
echo "Erro: " . $email->ErrorInfo;
exit;
}else{    
    $cont++;
}
}

echo "Foram enviados ".$cont." compromissos por email.";
?>