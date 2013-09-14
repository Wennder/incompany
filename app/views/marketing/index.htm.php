<?php
switch ($op) {
    case "dashboard":
        break;
    default:
        echo $html->tag("script","loadDiv('#contMarketing','/marketing/index/dashboard/');");
        echo $html->tag("div", "&nbsp;", array("id" => "auxMarketing", "class" => "grid_4"));
        echo $html->tag("div", "&nbsp;", array("id" => "contMarketing", "class" => "grid_12"));
        break;
        
}
?>