<?php

switch ($op) {
    default :
    case "fob":
        $print["fob"] = $importacoes->fob($processo, null, null, "processo");
        echo "[ ".json_encode($print)." ]";
        break;
    case "cadastrar":

        break;
}
?>
