<?php

class email_destinatarios extends AppModel{
    public $hasOne = array(
        "mensagem" => array(
            "className" => "email_mensagens",
            "primaryKey" => "id_mensagem",
            "foreignKey" => "id_mensagem"
        ),
        "contato" => array(
            "className" => "comercial_contatos",
            "primaryKey"=> "id",
            "foreignKey"=>"id_contato"
        )
    );
}
?>
