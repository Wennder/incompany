<script type='text/javascript'>
    $(document).ready(function() {
    $("#milestones").accordion();
    });
</script>
<div class="linhaInferior">
    <div class="titulo_projeto"><?php echo $dadosForm["nome"] ?></div>
    <div class="porcentagem_projeto">100%</div>
    <br clear="all"/>
</div>

<?php
//pr($dadosForm);
echo $html->link("Novo Milestone",
        "javascript:popIn('janelaModal','/projetos/milestones/novo/{$dadosForm["id"]}');",
        array("class" => "botao"));

        echo $html->openTag("div",array("id"=>"milestones"));
        //foreach inicio
        foreach ($dadosForm['milestones'] as $milestone)
        {
            echo $html->openTag("h3");
            echo $milestone['nome'];
            echo $html->closeTag("h3");
            echo $html->div($html->link(
                    "Nova atividade","javascript:popIn('janelaModal','/projetos/atividades/novo/{$milestone['projetos_projeto_id']}/{$milestone['id']}');",array("class" => "botao"))
                    .$xgrid->start($milestone["atividades"])
                );
            
        }

        //--------------------
        //fim foreach
        echo $html->closeTag("div");
?>