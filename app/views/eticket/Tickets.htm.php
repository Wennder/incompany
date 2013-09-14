<script>
    $("button,.botao, input:submit, input:button, button", "html").button();
    $("input:text").setMask();
</script>
<style>
	.titulo{
		float:left;
		weight:bold;
		font-family: Helvetica,Arial,sans-serif;
		font-size: 14px;
		color: #444444;
		font-weight:bold; 
	}
	.informacao{
		float:right;
		clear:right;
		font-size: 12px;
	}
</style>
<?php
switch ($op) {
    case "novo":
        if (!empty($protocolo)) {
            echo "<div class='titulo'><center> Seu protocolo é: #$protocolo </center></div>";
        } else {
            ?>
            <script type="text/javascript">
                $(document).ready(function() {
                    $("#novosolicitacao").validate({
                        rules: {
                            rh_setor_id: {
                                selectRequerido:0
                            },
                            assunto: {
                                required:true
                            },
                            descricao:{
                                required:true
                            }
                        },
                        messages: {
                            rh_setor_id: {
                                selectRequerido:"Selecione um departamento."
                            },
                            assunto: {
                                required:"Escreva qual é o assunto."
                            },
                            descricao:{
                                required:"Escreva a Solicitação."
                            }
                        }
                    });
                });
            </script>

            <?php
            echo $form->create("", array("id" => "novosolicitacao"));
            echo $form->input("rh_setor_id", array("type" => "select", "options" => $listaDpto, "label" => "Setor", "class" => "Form2Blocos"));
            echo $form->input("assunto", array("type" => "text", "label" => "Assunto", "class" => "Form2Blocos"));
            echo $form->input("descricao", array("type" => "textarea", "rows" => "4", "label" => "Solicitação", "class" => "Form2Blocos"));
            echo $form->close("Abrir", array("class" => "botao"));
        }
        break;
    case "buscar":
        echo $form->create("/eticket/Tickets/grid");
        echo $form->input("field", array("type" => "select", "div" => "ladoalado", "label" => "Campo", "options" => array("Protocolo", "Assunto")));
        echo $form->input("value", array("label" => "Valor", "class" => "Form2Blocos"));
        echo "<br clear='all' />";
        echo $form->close("Buscar", array("class" => "botao"));
        break;
    case"grid":
        $this->pageTitle = "Etickets :: Minhas Solicitações Departamentais";

        echo $xgrid->start($solicitacoes)
                ->caption("Minhas Solicitações")
                ->noData('Nehum registro encontrado!')
                ->col("id")->cell("{id}")->position(0)->title("#")
                ->col("assunto")->title("Assunto")->slice(20)
                ->col("eticket_respostas")->hidden()
                ->col("rh_setor")->title("Departamento")->cellArray("nome")
                ->col("rh_setor_id")->hidden()
                ->col("status_id")->hidden()
                ->col("created")->hidden()
                ->col("acompanhar")->title("")->cell("mais.png", "javascript:AbreJanela('/eticket/Tickets/ver/{id}',700,500, 'Acompanhamento de Chamado #{id}');")
                ->col("eticket_status")->title("Status")->cellArray("nome")
                ->alternate("grid_claro", "grid_escuro");
        //echo $html->link("Nova Solicitação", "/eticket/Tickets/novo", array("class" => "botao"));
        break;

    case "encaminhadas":
        $this->pageTitle = "Etickets :: Minhas Solicitações Departamentais";

        echo $xgrid->start($chamadosEticket)
                ->caption("Solicitações Encaminhadas")
                ->noData('Nehum registro encontrado!')
                ->col("id")->cell("{id}")->position(0)->title("#")
                ->col("assunto")->title("Assunto")->slice(20)
                ->col("eticket_respostas")->hidden()
                ->col("notaAtendimento")->hidden()
                ->col("users_id")->hidden()
                ->col("responsavel")->hidden()
                ->col("previsao")->date("d/m/Y")->title("P")
                ->col("rh_setor")->hidden()
                ->col("descricao")->hidden()
                ->col("rh_setor_id")->hidden()
                ->col("status_id")->hidden()
                ->col("created")->title("D.A.")->date("d/m/Y")
                ->col("modified")->title("U.M.")->date("d/m/Y")
                ->col("acompanhar")->title("")->cell("mais.png", "javascript:AbreJanela('/eticket/Tickets/ver/{id}',700,500, 'Acompanhamento de Chamado #{id}');")
                ->col("eticket_status")->title("Status")->cellArray("nome")
                ->alternate("grid_claro", "grid_escuro");
        //echo $html->link("Nova Solicitação", "/eticket/Tickets/novo", array("class" => "botao"));
        break;

    case "ver":
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#versolicitacao").validate({
                    rules: {
                        descricao:{
                            required:true
                        }
                    },
                    messages: {
                        descricao: {
                            required:"Escreva uma resposta."
                        }
                    }
                });
            });
        </script>
        <?php
        $this->pageTitle = "Etickets :: Ver Solicitação ( #{$solicitacao[id]} )";
        if ($solicitacao["users_id"] == $loggedUser["id"] || (substr_count($emailSetor, $loggedUser["username"]) > 0) || $solicitacao["responsavel"] == $loggedUser["id"]) {
	    pr($topoRespostas);
            echo "<div id='content' style='width:100%; height:400px;'>";
            echo "<div class='dados' style='float:left; width:33%; height:310px; border:1px solid #DDDDDD;'>";
            echo "<div><div class='titulo'>Protocolo:</div> <div class='informacao'>{$solicitacao["id"]}</div></div><br clear='all'/>";
            echo "<div class='titulo'>Abertura: </div> <div class='informacao'>" . $date->format("d/m/Y H:i", $solicitacao["created"]) . "</div><br clear='all'/>";
            echo "<div class='titulo'>Departamento:</div> <div class='informacao'>{$solicitacao["rh_setor"]["nome"]}</div><br clear='all'/>";
            echo "<div class='titulo'>Status Atual:</div> <div class='informacao'>{$solicitacao["eticket_status"]["nome"]}</div><br clear='all'/>";
            echo "<div class='titulo'>Previsão:</div> <div class='informacao'>" . $date->format("d/m/Y", $topoRespostas["previsao"]) . "</div><br clear='all'/>";
            echo "<div class='titulo'>Assunto:</div> <div class='informacao'> {$solicitacao["assunto"]}</div><br clear='all'/>";
            echo "<fieldset>";
            echo "<legend>Solicitação</legend>";
            echo $solicitacao["descricao"];
            echo "</fieldset>";
            echo "<br clear='all'>";
            echo"</div>";
            echo"<div class='assentamentos' style='overflow-y:auto;overflow-x:hidden;float:right; width: 65%; height: 310px; border:1px solid #DDDDDD;'>";
            
            if (empty($solicitacao["eticket_respostas"])) {

                echo "<center><b>Ainda não há nenhuma resposta para sua solicitação</b></center>";
            } else {

                //pr($solicitacao['eticket_respostas']);
                foreach ($solicitacao["eticket_respostas"] as $retorno) {
                    ?>

                    <fieldset>
                        <legend class="eticketTituloChamado"><?php echo $funcionarios[$retorno["users_id"]] . "&nbsp;&nbsp;-&nbsp;&nbsp;" . $date->format("d/m/Y h:i:s", $retorno["created"]) . "&nbsp;&nbsp;-&nbsp;&nbsp;" . $status[$retorno["status_id"]]; ?></legend>
                        <div class="descricao"><?php echo $retorno["descricao"]; ?></div>
                        <?php
                        if (!empty($retorno["previsao"]) && $retorno["previsao"] != "0000-00-00") {
                            echo "<strong>Previsão:" . $date->format("d/m/Y", $retorno["previsao"]) . "</strong>";
                        }
                        ?>
                    </fieldset>

                    <?php
                }
            }

            echo"</div>";
            echo "<br clear='all' />";
            echo"<div class='postagem' style='border:1px solid #DDDDDD;float:left; width: 100%; height: 95px;margin-top:10px;'>";
            echo $form->create("", array("id" => "versolicitacao"));
            if ($loggedUser['id'] == $solicitacao['responsavel'] || substr_count($emailSetor, $loggedUser['username']) > 0) {
                echo $form->input("status_id", array("type" => "select","div"=>"ladoalado", "options" => $listaStatus, "class" => "Form1Bloco", "label" => "Status Solicitação"));
                echo $form->input("responsavel", array("type" => "select","div"=>"ladoalado", "options" => $comboResponsavel, "value" => $solicitacao["responsavel"], "label" => "Direcionar para ", "class" => "Form1Bloco"));
                echo $form->input("previsao", array("type" => "text", "label" => "Previsão", "class" => "FormMeioBloco", "alt" => "date"));
            }
            echo $form->input("descricao", array("div"=>"ladoalado","type" => "textarea", "rows" => "4", "label" => "Responder", "style" => "width:525px; height:34px;"));
            
            echo $form->close("Enviar", array("class" => "botao"));
        } else {
            echo "<b>Essa solicitação não existe, ou você não tem permissão para vê-la</b>";
        }
        echo "</div>";
        echo "</div>";


        
        break;

    case "responder":
        echo "<div class='titulo'>Chamados para Atendimento</div>";
        echo $xgrid->start($responder)
                ->caption("Minhas Solicitações")
                ->noData('Nehum registro encontrado!')
                ->col("Protocolo")->cell("#{id}")->position(1)
                ->col("id")->hidden()
                ->hidden(array("rh_setor_id", "rh_setor", "status_id", "modified", "users_id", "responsavel", "eticket_respostas", "notaAtendimento", "descricao"))
                ->col("assunto")->title("Assunto")
                ->col("previsao")->title("Previsão")->date("d/m/Y")
                ->col("created")->date("d/m/Y H:i")->title("Abertura")
                ->col("eticket_status")->title("Status")->cellArray("nome")
                ->col("acompanhar")->title("Acompanhar")->conditions("id", array(">=1" => array("label" => "aaaaa", "href" => "/eticket/Tickets/ver/{id}", "border" => "0")))
                ->alternate("grid_claro", "grid_escuro");
        break;
}
?>