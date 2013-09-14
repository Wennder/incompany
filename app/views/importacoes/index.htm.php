<script>
    $(function(){
       loadDiv("#contImportacoes","/importacoes/dashboard/index");
       loadDiv("#auxImportacoes","/importacoes/dashboard/buscaProcesso");
    });
</script>

<?php

echo $html->tag("div", "&nbsp;",array("class" => "grid_4","id"=>"auxImportacoes"));

echo $html->tag("div", "&nbsp;",array("class" => "grid_12","id"=>"contImportacoes"));
?>
