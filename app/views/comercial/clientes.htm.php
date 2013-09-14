<script>
    function valida(message) {
        var x=document.getElementsByTagName("input");
        var i=0;
        var c=new Array();
        a=0;
        for (i=0;i<=x.length-1;i++) {
            if (x[i].type=="checkbox") {
                c[a] = x[i];
                a++;
            }
        }
        i=0;
        var checked = false;
        for (i=0;i<=c.length-1;i++) {
            if (c[i].checked==true) {
                checked = true;
                break;
            }
        }
        if (!checked) {
            alert(message);
            return false;
        }else if (confirm("Deseja Continuar?")) {
            return true;
        }else{
            return false;
        }
    }
    function criaProposta(id){
        switch(id){
            case "1":
                if(valida("Primeiro Selecione o(s) Cliente(s)")){
                    $("#formGridClientes").ajaxSubmit(function(data){
                        $("#contComercial").html(data);
                    });
                }
                break;
        }
        $("#FormAction").val(-1);
        
    }
    
    $(function(){
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        $("#buscaCliente").ajaxForm(function(){
            stateLoad("#contComercial");
            $.post("/comercial/clientes/grid",$("#buscaCliente").serialize(), function(data){
                $("#contComercial").html(data);
            });
        }); 
    });
</script>


<script type="text/javascript">
            $(document).ready(function() {
                $("#cadComercialCliente").ajaxForm({
                    success:function(){
                        alert("Enviado com Sucesso");
                    },
                    "target":"#contComercial"
                });
                $("#FormTipocliente").change(function(){
                    var tipoCliente = $("#FormTipocliente").val();
                    if(tipoCliente=='pj'){
                        $("#pf").hide();
                        $("#pj").show();
                    }else{
                        $("#pj").hide();
                        $("#pf").show();
                    }
                });

                var tipoCliente = $("#FormTipocliente").val();
                if(tipoCliente=='pj'){
                    $("#pf").hide();
                    $("#pj").show();
                }else{
                    $("#pj").hide();
                    $("#pf").show();
                }

            });
                                            
            $("#FormCep").change(function(){
                cep = $("#FormCep").val().replace("-", "");
                $.getJSON("/integracao/cep/"+cep, function(consulta){
                    if(consulta.resultado == 0){
                        alert("CEP Não Encontrado!");
                    }else{
                        $("#FormLogradouro").val(consulta.tipo_logradouro+" "+consulta.logradouro);
                        $("#FormBairro").val(consulta.bairro);
                    }
                });
            });
            $("#FormEstadoId").change(function(){
                $("#FormMunicipioId").load("/integracao/options/sys_municipios/nome/<?php echo "0" . "/uf/" ?>"+$("#FormEstadoId").val());
            });
                                                                                                                                    
            $("#FormMunicipioId").load("/integracao/options/sys_municipios/nome/<?php echo (empty($dados["municipio_id"])) ? "0" : $dados["municipio_id"] . "/uf/" . $dados["estado_id"]; ?>");
                                                                                                                                
                                            
            $(function(){
                $("#abaCadastroCliente").tabs({
        <?php
        if (empty($dados)) {
            echo "disabled:[2,3,4,5]";
        }
        ?>
                });
                loadDiv("#gridEnderecos","/comercial/clientesEnderecos/grid/<?php echo $dados['id'] ?>");
                loadDiv("#gridContatos","/comercial/clientesContatos/grid/<?php echo $dados['id'] ?>");
                loadDiv("#gridConsumo","/comercial/clientesConsumo/grid/<?php echo $dados['id'] ?>");
                loadDiv("#gridHistorico","/comercial/clientesHistorico/grid/<?php echo $dados['id'] ?>");
                                                                                                

            });
        </script>
<?php
switch ($op) {
    case "cadastrar":
        echo $form->create("", array("enctype" => "multipart/form-data", "id" => "cadComercialCliente", "class" => "formee"));
        echo $html->openTag("div", array("id" => "abaCadastroCliente"));
        $menu = $html->tag("li", $html->link("Dados", "#dadosBasicos", null, false, true));
        $menu .= $html->tag("li", $html->link("Perfil", "#dadosPerfil", null, false, true));
        $menu .= $html->tag("li", $html->link("Endereços", "#dadosEnderecos", null, false, true));
        $menu .= $html->tag("li", $html->link("Contatos", "#dadosContatos", null, false, true));
        $menu .= $html->tag("li", $html->link("Consumo", "#dadosConsumo", null, false, true));
        $menu .= $html->tag("li", $html->link("Historico de Contato", "#dadosHistoricoContato", null, false, true));
        $menu .= $html->Tag("div", "<b>#{$dados["id"]}</b>", array("style" => "float:right; margin-top:5px; margin-right:5px; font-size:18px;"));
        echo $html->tag("ul", $menu);
        //Aba Dados Básicos
        echo $html->openTag("div", array("id" => "dadosBasicos"));

        echo $form->input("tipoCliente", array("type" => "select", "div" => "grid-12-12", "label" => "Tipo de Cliente", "options" => array("pj" => "Jurídica", "pf" => "Pessoa Física"), "value" => $dados['tipoCliente']));
        echo "<div id='pj'>";
        echo $form->input("razaoSocial", array("type" => "text", "label" => "Razão Social", "div" => "grid-12-12", "value" => $dados["razaoSocial"]));
        echo $form->input("nomeFantasia", array("type" => "text", "label" => "Nome Fantasia", "div" => "grid-12-12", "value" => $dados["nomeFantasia"]));
        echo $form->input("cnpj", array("type" => "text", "alt" => "cnpj", "label" => "CNPJ", "div" => "grid-3-12", "value" => $dados["cnpj"]));
        echo $form->input("ie", array("type" => "text", "label" => "IE", "div" => "grid-3-12", "value" => $dados["ie"]));
        echo $form->input("suframa", array("type" => "text", "label" => "SUFRAMA", "div" => "grid-3-12", "value" => $dados["suframa"]));
        echo $form->input("im", array("type" => "text", "label" => "Inscrição Municipal", "div" => "grid-3-12", "value" => $dados["im"]));
        echo "</div>";
        echo "<div id='pf'>";
        echo $form->input("razaoSocialPf", array("type" => "text", "label" => "Nome", "div" => "grid-12-12", "value" => $dados["razaoSocial"]));
        echo $form->input("cnpjPf", array("type" => "text", "alt" => "cpf", "label" => "CPF", "div" => "grid-3-12", "value" => $dados["cnpj"]));
        echo $form->input("iePf", array("type" => "text", "label" => "RG", "div" => "grid-3-12", "value" => $dados["ie"]));
        echo $form->input("orgaoEmissorPf", array("label" => "Orgão Emissor", "div" => "grid-3-12", "value" => $dados["orgaoEmissor"]));
        echo $form->input("estadoEmissorPf", array("type" => "select", "label" => "Estado", "div" => "grid-3-12", "options" => $optionsEstados, "value" => $dados['estadoEmissor']));
        echo "</div>";

        echo $form->input("cep", array("type" => "text", "label" => "Cep", "alt" => "cep", "div" => "grid-2-12", "value" => $dados["cep"]));
        echo $form->input("logradouro", array("type" => "text", "label" => "Endereço", "div" => "grid-10-12", "value" => $dados["logradouro"]));
        echo $form->input("nro", array("type" => "text", "label" => "Número", "div" => "grid-2-12", "value" => $dados["nro"]));
        echo $form->input("complemento", array("type" => "text", "label" => "Complemento", "div" => "grid-7-12", "value" => $dados["complemento"]));
        echo $form->input("bairro", array("type" => "text", "label" => "Bairro", "div" => "grid-3-12", "value" => $dados["bairro"]));
        echo $form->input("estado_id", array("type" => "select", "label" => "Estado", "options" => $optionsEstados, "div" => "grid-2-12", "value" => $dados["estado_id"]));
        echo $form->input("municipio_id", array("type" => "select", "label" => "Cidade", "div" => "grid-10-12", "options" => array("Selecione o Estado"), "value" => $dados["municipio_id"]));

        echo $form->input("fone", array("type" => "text", "alt" => "telefone", "label" => "Telefone", "div" => "grid-3-12", "value" => $dados["fone"]));
        echo $form->input("fax", array("type" => "text", "alt" => "telefone", "label" => "Fax", "div" => "grid-3-12", "value" => $dados["fax"]));
        echo $form->input("email", array("type" => "text", "label" => "E-mail", "div" => "grid-6-12", "value" => $dados["email"]));
        echo $form->input("site", array("type" => "text", "label" => "Site:", "div" => "grid-6-12", "value" => $dados["site"]));
        echo $form->input("ativo", array("type" => "select", "label" => "Acesso ao Sistema", "options" => array("1" => "Ativo", "0" => "Desativado"), "div" => "grid-6-12", "value" => $dados["ativo"]));
        echo $form->input("observacao", array("type" => "textarea", "label" => "Observação:", "div" => "grid-12-12", "value" => $dados["observacao"]));
        echo $html->tag("br", "", array("clear" => "all"));
        
        echo $html->closeTag("div");

        //Aba Perfil
        echo $html->openTag("div", array("id" => "dadosPerfil"));
        echo $html->tag("h3", "Classificação", array("class" => "title"));
        echo $form->input("classificacao", array("type" => "select", "label" => "Classificação", "div" => "grid-3-12", "options" => array_reverse(range("A", "C")), "value" => $dados["classificacao"]));
        echo $form->input("prospectar", array("type" => "select", "label" => "Prospecção", "div" => "grid-3-12", "options" => array("Prospectar", "Em Andamento", "Prospectado"), "value" => $dados["prospectar"]));
        echo $form->input("importa", array("type" => "select", "label" => "Importação", "options" => $bool, "div" => "grid-3-12", "value" => $dados["importa"]));
        echo $form->input("exporta", array("type" => "select", "label" => "Exportação", "options" => $bool, "div" => "grid-3-12", "value" => $dados["exporta"]));
        echo $form->input("incentivoFiscal", array("type" => "select", "label" => "Incentivo Fiscal", "options" => $bool, "div" => "grid-2-12", "value" => $dados["incentivoFiscal"]));
        echo $form->input("obsIncentivoFiscal", array("label" => "Obs", "div" => "grid-10-12", "value" => $dados["obsIncentivoFiscal"]));
        echo $html->tag("br", "", array("clear" => "all"));
        echo $html->tag("h3", "Representação / Comissionamento", array("class" => "title"));
        echo $form->input("representante_id", array("type" => "select", "options" => $optRepresentantes, "label" => "Representante", "div" => "grid-10-12", "value" => $dados["representante"]["id"]));
        echo $form->input("comissaoRepresentante", array("label" => "Comissão (%)", "alt" => "porcentagem", "div" => "grid-2-12", "value" => $dados["comissaoRepresentante"]));
        echo $html->closeTag("div");


        //Aba contatos
        echo $html->openTag("div", array("id" => "dadosEnderecos"));
        echo $html->link("Novo Endereço", "javascript:AbreJanela('/comercial/clientesEnderecos/cadastrar/{$dados["id"]}', 500, 350, 'Cadastrar Endereço', null, true);", array("class" => "botao grid-2-12"));
        echo $html->tag("div", $html->printWarning("Em Desenvolvimento"), array("id" => "gridEnderecos", "class" => "grid-12-12"));
        echo $html->closeTag("div");

        //Aba contatos
        echo $html->openTag("div", array("id" => "dadosContatos"));
        echo $html->tag("div", "", array("id" => "gridContatos", "class" => "grid-12-12"));
        echo $html->link("Novo Contato", "javascript:AbreJanela('/comercial/clientesContatos/cadastrar/{$dados["id"]}', 500, 350, 'Cadastrar Contato', null, true);", array("class" => "botao grid-2-12"));
        echo $html->closeTag("div");
        //Aba Consumo
        echo $html->tag("div", $html->tag("div", "", array("id" => "gridConsumo", "class" => "grid-12-12")), array("id" => "dadosConsumo"));
        //Aba Histórico de Contato
        echo $html->tag("div", $html->tag("div", "", array("id" => "gridHistorico", "class" => "grid-12-12")), array("id" => "dadosHistoricoContato"));
        echo $html->closeTag("div");
        echo $form->close("Salvar", array("class" => "grid-2-12"));
        break;
//Área do cadastro do primeiro contato do Cliente.        
    case "primeiroContato":
        echo $form->create("", array("enctype" => "multipart/form-data", "id" => "primeiroContato", "class" => "formee"));
        echo $html->openTag("div",array("class"=>"container_12"));
        echo $html->openTag("div",array("class"=>"grid_8"));
        echo $html->tag("h3","Dados da Empresa",array("class"=>"title"));
        echo $form->input("origem", array("type" => "select", "div" => "grid-4-12", "label" => "Origem", "options" => array("Nacional","Extrangeira"), "value" => $dados['tipoCliente']));
        echo $form->input("tipoCliente", array("type" => "select", "div" => "grid-8-12", "label" => "Tipo de Cliente", "options" => array("pj" => "Jurídica", "pf" => "Pessoa Física"), "value" => $dados['tipoCliente']));
        echo "<div id='pj'>";
        echo $form->input("nomeFantasia", array("type" => "text", "label" => "Nome Fantasia", "div" => "grid-12-12", "value" => $dados["nomeFantasia"]));
        echo "</div>";
        echo "<div id='pf'>";
        echo $form->input("razaoSocial", array("type" => "text", "label" => "Nome", "div" => "grid-12-12", "value" => $dados["razaoSocial"]));
        echo "</div>";

        echo $form->input("estado_id", array("type" => "select", "label" => "Estado", "options" => $optionsEstados, "div" => "grid-4-12", "value" => $dados["estado_id"]));
        echo $form->input("municipio_id", array("type" => "select", "label" => "Cidade", "div" => "grid-8-12", "options" => array("Selecione o Estado"), "value" => $dados["municipio_id"]));
        
        echo $form->input("observacao", array("type" => "textarea", "label" => "Observação", "div" => "grid-12-12", "value" => $dados["observacao"]));
        echo $html->closeTag("div");
        
        echo $html->openTag("div",array("class"=>"grid_4"));
        echo $html->tag("h3","Dados do Contato",array("class"=>"title"));
        echo $form->input("contato_nome",array("type"=>"text","label"=>"Nome","div"=>"grid-12-12"));
        echo $form->input("contato_email", array("type" => "text", "label" => "E-mail", "div" => "grid-12-12", "value" => $dados["email"]));
        echo $form->input("contato_tel1", array("type" => "text", "alt" => "telefone", "label" => "Telefone", "div" => "grid-12-12", "value" => $dados["fone1"]));
        echo $form->input("contato_tel2", array("type" => "text", "alt" => "telefone", "label" => "Celular / Telefone Alternativo", "div" => "grid-12-12", "value" => $dados["fone2"]));
        echo $form->close("Salvar", array("class" => "grid-12-12"));
        echo $html->closeTag("div");
        echo $html->closeTag("div");
        
        break;
    case "grid":
        echo $form->create("/comercial/envioProposta/criaNova", array("id" => "formGridClientes", "class" => "formee"));
        echo $xgrid->start($dadosGrid)
                ->caption("Clientes")
                ->noData('Nehum registro encontrado!')
                ->hidden(array("enderecos", "municipio_id", "estado_id", "created", "id", "cnpj", "contatos", "contratos", "representante", "cidade", "consumo"))
                ->col('chk')->checkbox('clientes[]', '{id}')->title('')->position(0)
                ->col("razaoSocial")->title("Razão Social")
                ->col("municipio")->title("Cidade")->cellArray("nome")->position(4)
                ->col("estado_id")->title("UF")->conditions($optionsEstados)
                ->col("editar")->title("")->cell("editar.png", "javascript:loadDiv('#contComercial','/comercial/clientes/cadastrar/{id}');")
                ->col("deletar")->title("")->cell("contato.png", "javascript:AbreJanela('/comercial/clientesHistorico/cadastrar/{id}',600,300,'Historico de Contatos',null,true);")
                ->col("imprimir")->title("")->cell("icone_imprimir.gif", "/comercial/clientes/printFichaCliente/{id}")
                ->alternate("grid_claro", "grid_escuro");
        echo $form->input("action", array("type" => "select", "label" => "Ações", "options" => array("Selecione", "1" => "Enviar Proposta", "Ficha Sintética", "Ficha Analítica"), "div" => "grid-3-12", "onChange" => "criaProposta(this.value);"));
        echo $form->close(null);
        break;

    case "printFichaCliente":
        ?>
        <fieldset>
            <legend><h1>Cliente</h1></legend>
            <table border="0" width="100%">
                <?php
                if ($dados["tipoCliente"] == 'pj') {

                    echo "<tr>";
                    echo "<td colspan='3'><center><h2>" . $dados['nomeFantasia'] . "</h2>";
                    echo "<h3>" . $dados['razaoSocial'] . "</h3></center>";
                    echo "<br/>";
                    echo "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td><b>Cnpj</b><br/>" . $dados['cnpj'] . "</td>";
                    echo "<td><b>IE</b><br/>" . $dados['ie'] . "</td>";
                    echo "<td><b>IM</b><br/>" . $dados['im'] . "</td>";
                    echo "</tr>";
                } else {
                    echo "<tr>";
                    echo "<td><center><h1>" . $dados['razaoSocial'] . "</h1></center></td> ";
                    echo "<br/>";
                    echo" </tr>";
                    echo "<tr>";
                    echo "<td><b>CPF</b><br/>" . $dados['cnpj'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td><b>RG</b><br/>" . $dados['ie'] . "</td>";
                    echo "<td><b>Orgão Emissor</b><br/>" . $dados['orgaoEmissor'] . "</td>";
                    echo "<td><b>Estado Emissor</b><br/>" . $optionsEstados[$dados['estadoEmissor']] . "</td>";
                    echo "</tr> ";
                }
                ?>
                <tr>
                    <td><b>Endereço</b><br/><?php echo $dados['endereco'] ?></td>
                    <td><b>Bairro</b><br/><?php echo $dados['bairro'] ?></td>
                </tr>
                <tr>
                    <td><b>Cidade</b><br/><?php echo $dados['cidade'] ?></td>
                    <td><b>UF</b><br/><?php echo $optionsEstados[$dados['estado']] ?></td>
                    <td><b>Cep</b><br/><?php echo $dados['cep'] ?></td>
                </tr>
                <tr>
                    <td><b>Telefone</b><br/><?php echo $dados['fone'] ?></td>
                    <td><b>Fax</b><br/><?php echo $dados['fax'] ?></td>
                </tr>
                <tr>
                    <td><b>E-mail</b><br/><?php echo $dados['email'] ?></td>
                </tr>
                <tr>
                    <td><b>Site</b><br/><?php echo $dados['site'] ?></td>
                </tr>
                <tr>
                    <td><b>Observação</b><br/><?php echo $dados['observacao'] ?></td>
                </tr>
                <tr>
                    <?php $status = array("1" => "Ativa", "0" => "Desativada"); ?>
                    <td><b>Status</b><br/><?php echo $status[$dados['ativo']] ?></td>
                </tr>
            </table>

            <?php
            $comboTipoContato = array("Selecione...", "Financeiro", "Comercial", "Administrativo");
            foreach ($dados['contatos'] as $contato) {

                echo "<fieldset><legend><h3>Contato  " . $comboTipoContato[$contato['tipoContato']] . "</h3></legend>";
                echo "<table>
             <tr>
             <td><b>Nome</b><br/>" . $contato['nome'] . "</td>
             </tr>
             <tr>
             <td><b>E-mail</b><br/>" . $contato['email'] . "</td>
             </tr>
             <tr>
             <td><b>Telefone 1</b><br/>" . $contato['tel1'] . "</td>
             <td><b>Telefone 2</b><br/>" . $contato['tel2'] . "</td>
             </tr>
             </table>";
                echo "</fieldset>";
            }
            ?>
        </fieldset>
        <?php
        break;
    case "buscar":
        echo $html->tag("h3", "Buscar", array("class" => "title"));
        //Caixa de Busca de Clientes
        echo $form->create("/comercial/clientes/grid", array("id" => "buscaCliente", "class" => "formee"));
        echo $form->input("nomeFantasia", array("type" => "text", "label" => "Nome", "div" => "grid-12-12"));
        echo $form->input("estado", array("type" => "select", "options" => $optionsEstados, "div" => "grid-6-12", "label" => "Região"));
        echo $form->input("limit", array("type" => "select", "options" => array("10" => "10", "20" => "20", "30" => "30", "40" => "40", "50" => "50"), "div" => "grid-6-12", "label" => "Registros"));
        echo $form->input("categoria1", array("type" => "select", "label" => "Grupo", "div" => "grid-12-12", "onChange" => "populaCombo('/integracao/options/estoque_catprodutos/nome/-1/pai/'+this.value, '#FormCategoria2', 'options');", "options" => $dadosCat1));
        echo $form->input("categoria2", array("type" => "select", "div" => "grid-12-12", "label" => "Tipo", "onChange" => "populaCombo('/integracao/options/estoque_catprodutos/nome/-1/pai/'+this.value, '#FormCategoria3', 'options');"));
        echo $form->input("categoria3", array("type" => "select", "div" => "grid-12-12", "label" => "Aplicação", "onChange" => "populaCombo('/integracao/options/estoque_catprodutos/nome/-1/pai/'+this.value, '#FormCategoria4', 'options');"));
        echo $form->input("categoria4", array("type" => "select", "label" => "Produto Final", "div" => "grid-12-12"));
        echo $form->close("Buscar", array("class" => "botao grid-12-12"));
        echo "<br clear='all' />";
        break;
}
?>