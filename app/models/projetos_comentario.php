<?php

    class projetos_comentario extends AppModel
    {
        public $hasOne = array("atividade" => array("className"=>"projetos_atividades","primaryKey"=>"projetos_atividades_id",
            "foreignKey"=>"id"));
    }

?>
