<?php
	$this->pageTitle = "Eticket :: DashBoard";
?>
<div class="EdashContent">
    <div class="EdashAbertos">


       <center> <div class='dashtitulo'> Tickets em Aberto</div></center>

             <?php
        if(!empty ($chamadosEticket)){
        $i = 0;
        //pr($chamadosEticket);

       echo "<div class='dashScroll'>";
        foreach($chamadosEticket as $chamados){
        if(($i%2)==0){
        $cor="#fcf5dd";
        }else{
        $cor="#ffffff";
        }
        echo "<div style=' background-color:$cor; width: 99%;  min-height: 50px; border: 1px solid #E8E8E8; margin-bottom: 3px; margin-left:1px;'>";
        echo "<b>Departamento:</b> ".$chamados['rh_setor']['nome']."<br/>";
        echo "<b>Solicitante:</b> ".$funcionarios[$chamados['users_id']]."<br/>";
        echo "<b>Descrição:</b> ".$assistec->cortaTexto("100","...",$chamados['descricao'])."<br/>";
        echo "<b>Aberto:</b> ".$date->format("d/m/Y h:i", $chamados['created'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo $html->link("Atender", "/eticket/Tickets/ver/{$chamados['id']}", array("class" => "Botao"));
        echo "</div>";
        $i++;
        
        }
        echo "</div>";
        }else{

        echo "Não há ticket aberto ou encaminhado a você!";
        }
        ?>
    </div>

    <div class="EdashDireito">
        <div class="EdashPrevisao">
            <center> <div class='dashtitulo'> Proximos a Previsão</div></center>
            <?php
        //pr($chamadosPrevisao);
       if(!empty ($chamadosPrevisao)){
       $i=0;
           foreach($chamadosPrevisao as $previsao){
             if(($i%2)==0){
        $cor="#fcf5dd";
        }else{
        $cor="#ffffff";
        }
        if($previsao['previsao']<=date("Y-m-d")){
               $cor = "#F7BCBC";
        }
     
            echo "<div style=' background-color:$cor; width: 99%;  min-height: 50px; border: 1px solid #E8E8E8; margin-bottom: 3px; margin-left:1px;'>";
        echo "<b>Departamento:</b> ".$previsao['rh_setor']['nome']."<br/>";
        echo "<b>Solicitante:</b> ".$funcionarios[$previsao['users_id']]."<br/>";
        echo "<b>Descrição:</b> ".$assistec->cortaTexto("100","...",$previsao['descricao'])."<br/>";
        echo "<b>Previsão:</b> ".$date->format("d/m/Y",$previsao['previsao'])."<br/>";
        echo "<b>Aberto:</b> ".$date->format("d/m/Y h:i",$previsao['created'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "</div>";
        $i++;
           }
       }else{
           echo "Não há Tickets proximos do vencimento";
       }
       ?>


        </div>
        <div class="EdashOutro">
            <center> <div class='dashtitulo'>Acompanhamento 3 meses</div></center>
        </div>
    </div>
</div>