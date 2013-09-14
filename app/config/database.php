<?php
/**
 * Aqui você deve definir suas configurações de banco de dados, todas de acordo
 * com um determinado ambiente de desenvolvimento. Você pode definir quantos
 * ambientes forem necessários.
 * 
 */

Config::write("database", array(
    "development" => array(
        "driver" => "mysql",
        "host" => "localhost",
        "user" => "root",
        "password" => "",
        "database" => "syntex5",
        "prefix" => ""
    ),
    "production" => array(
        "driver" => "mysql",
        "host" => "localhost",
        "user" => "assistec_scr",
        "password" => "3n73r4l6@77@",
        "database" => "assistec_scr",
        "prefix" => ""
    )
));

?>