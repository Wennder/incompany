<script>
    function updateAgenda(){
        $(".wc-today").click();
    }
</script>
<?php
    echo $form->input("donoAgenda",array("id"=>"donoAgenda","type"=>"select","div"=>"ladoalado","label"=>false,"onChange"=>"javascript:updateAgenda();","options"=>$funcionarios,"value"=>$loggedUser["id"]));
?>