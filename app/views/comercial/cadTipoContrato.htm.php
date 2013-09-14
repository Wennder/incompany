<script>
$(function(){
	$("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        $('textarea.editor').ckeditor();
});
</script>
<?php
switch ($op) {
    case "novo":
?>
        <script>
            $(function(){
            $("#contratos").tabs();
        });
    </script>
    <?php
    echo $form->create();
    ?>
    <div id="contratos">
        <ul>
            <li><a href="#dadosBasicos">Dados Básicos</a></li>
            <li><a href="#minuta">Minuta do Contrato</a></li>
        </ul>
        <div id="dadosBasicos">
        <?php        
        echo $form->input("nome", array("type" => "text", "label" => "Nome", "class" => "Form2Blocos", "value" => $dadosTipoContrato["nome"]));
        echo $form->input("descricaoServico", array("type" => "textarea", "label" => "Descrição de Serviço","class"=>"Form2Blocos", "value" => $dadosTipoContrato["descricaoServico"]));
        ?>
    </div>
    <div id="minuta">
        <?php
        echo $form->input("minuta",array("type"=>"textarea","class"=>"editor","value"=>$dadosTipoContrato["minuta"]));
        ?>
    </div>
</div>
<?php
    echo $form->close("Salvar",array("class"=>"botao"));
        break;

    case "grid":
        echo $xgrid->start($gridTipoContrato)
                ->caption("Tipos de Contratos Cadastrados")
                ->noData('Nehum registro encontrado!')
                ->col("id")->hidden()
                ->col("nome")->title("Nome")
                ->col("descricaoServico")->title("Descrição")->slice(20)->hidden()
                ->col("created")->title("Inserção")->date("d/m/Y")
                ->col("modified")->title("Modificação")->date("d/m/Y")
                ->col("editar")->title("Editar")->conditions("id", array(">=1" => array("label" => "editar.gif", "href" => "/comercial/cadTipoContrato/novo/{id}", "border" => "0")))
                ->col("deletar")->title("Excluir")->conditions("id", array(">=1" => array("label" => "deletar.png", "href" => "/comercial/cadTipoContrato/deletar/{id}", "border" => "0")))
                ->alternate("grid_claro", "grid_escuro");
        echo $html->link("*Novo","javascript:loadDiv('#contComercial','/comercial/cadTipoContrato/novo');",array("class"=>"botao"));
        break;
}
?>