<?php
    $this->pageTitle = "RH :: Cadastro de Funcionários"
?>

<script type="text/javascript" >    
    function load(div,url,urlReturn){      

        $.get(url);
        $("#"+div).load(urlReturn);
    }
    function saveForm(){
    	$('#cadFuncionarios').submit();

    }

    $(function(){
    $(".save").button({  
    icons: {  
         primary: "ui-icon-disk"  
    },  
    text:false  
}); 

$(".senha").button({  
    icons: {  
         primary: "ui-icon-unlocked"  
    },  
    text:false  
}); 
        $("#tabCadFuncionario").tabs();
        $("#wdwCadDocumentos").dialog({
            autoOpen: false,
            modal:true,
            height:300,
            width:400,
            beforeClose:function(){
                $("#gridDocumentos").load("/rh/cadDocumento/<?php echo $dadosUsuario["id"] ?>");
            }
        });

        $("#cadDependente").dialog({
            autoOpen: false,
            modal:true,
            height:300,
            width:500,
            beforeClose:function(){
                $("#gridDependente").load("/rh/cadDependente/<?php echo $dadosUsuario["id"] ?>"); 
            }
        });
        $("#FormGrupoempresaId").change(function(){
        var idGrupo = $("#FormGrupoempresaId").val();
        $("#carregaEmpresa").load("/rh/selectEmpresa/"+idGrupo+"/");
        });


        
        $("#carregaEmpresa").load("/rh/selectEmpresa/<?php echo $dadosUsuario["grupoEmpresa_id"]?>/<?php echo $dadosUsuario["sysEmpresas_id"]?>/");
        $("#cadDependente").load("/rh/cadDependente/<?php echo $dadosUsuario["id"] ?>/cad");
        $("#gridDependente").load("/rh/cadDependente/<?php echo $dadosUsuario["id"] ?>");
        $("#wdwCadDocumentos").load("/rh/cadDocumento/<?php echo $dadosUsuario["id"] ?>/cad");
        $("#gridDocumentos").load("/rh/cadDocumento/<?php echo $dadosUsuario["id"] ?>");
        $("#cadFuncionarios").validate({
            errorContainer: "#errConteiner",
            rules: {
                nome: {
                    required:true
                },
                endereco: {
                    required:true
                },
                cidade: {
                    required:true
                },
                estado: {
                    selectRequerido:0
                },
                cep: {
                    required:true
                },
                username: {
                    email:true,
                    required:true
                },
                tel: {
                    required:true
                },
                cel: {
                    required:true
                },
                dt_nascimento: {
                    required:true
                },
                estado_civil: {
                    selectRequerido:0
                },
                //Começo dados profissionais
                grau_instrucao: {
                    selectRequerido:0
                },
                sysEmpresas_id: {
                    selectRequerido:0
                },
                grupoEmpresa_id:{
                    selectRequerido:0

                },
                rh_setor_id: {
                    selectRequerido:0
                },
                cargo: {
                    required:true
                },
                salario: {
                    selectRequerido:0
                },
                //começo documentos
                rg: {
                    required:true
                },
                cpf: {
                    required:true
                }

            },
            messages: {
                nome: {
                    required:"Digite um Nome."
                },
                endereco: {
                    required:"Digite um Endereço."
                },
                cidade: {
                    required:"Digite o nome da Cidade."
                },
                estado: {
                    selectRequerido:"Selecione o Estado."
                },
                cep: {
                    required:"Digite o CEP."
                },
                username: {
                    required:"Digite seu E-mail.",
                    email:"Digite um email válido!"
                },
                tel: {
                    required:"Digite um numero Telefone."
                },
                cel: {
                    required:"Digite um numero de Celular"
                },
                dt_nascimento: {
                    required:"Digite a data de nascimento."
                },
                estado_civil: {
                    selectRequerido:"Selecione o Estado Civil."
                },
                //Começo dados profissionais
                grau_instrucao: {
                    selectRequerido:"Selecione o Grau de Instrução."
                },
                sysEmpresas_id: {
                    selectRequerido:"Digite qual a Empresa."
                },
                 grupoEmpresa_id:{
                    selectRequerido:"Informe o Grupo de Empresa!"

                },
                rh_setor_id: {
                    selectRequerido:"Selecione o Departamento."
                },
                cargo: {
                    required:"Digite o cargo."
                },
                salario: {
                    selectRequerido:"O salário deve ser maior que R$0,00."
                },
                //começo documentos
                rg: {
                    required:"Digite o RG."
                },
                cpf: {
                    required:"Digite o CPF."
                }
            }
        });
        //Fim Validação
    });
</script>
<?php
echo $form->create("", array("enctype" => "multipart/form-data", "id" => "cadFuncionarios"));
?>
<div id="tabCadFuncionario">
    <ul>
        <li><a href="#dadosPessoais">Dados Pessoais</a></li>
        <li><a href="#dadosProfissionais">Profissional</a></li>
        <li><a href="#dadosBancarios">Dados Bancários</a></li>
        <li><a href="#dadosDocumentos">Documentos</a></li>
        <li><a href="#dadosDependentes">Dependentes</a></li>
        <?php 
        if($dadosUsuario["id"]>0 && $dadosUsuario["password"]!=""){
        	echo $html->link("","/rh/resetSenha/".$dadosUsuario["id"]."",array("class"=>"senha","style"=>"float:right; height:25px;"));
        }
        echo $html->link("","javascript:saveForm();",array("class"=>"save","style"=>"float:right; height:25px;"));
        ?>
    </ul>
    <div id="dadosPessoais">
        <div style="width:550px; float:left;">
        <?php
        echo $form->input("id", array("type" => "hidden", "value" => $dadosUsuario["id"]));
        echo $form->input("nome", array("type" => "text", "label" => "Nome Completo","class"=>"Form2Blocos", "value" => $dadosUsuario["nome"]));
        echo $form->input("endereco", array("type" => "text", "label" => "Endereço", "class" => "Form2Blocos", "value" => $dadosUsuario["endereco"]));
        echo $form->input("cidade", array("type" => "text", "label" => "Cidade", "div" => "ladoalado","class"=>"Form1Bloco", "value" => $dadosUsuario["cidade"]));
        $estados = array("Selecione...", "AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE", "TO");
        echo $form->input("estado", array("type" => "select", "options" => $estados, "label" => "Estado", "class" => "FormMeioBloco","div"=>"ladoalado", "value" => $dadosUsuario["estado"]));
        echo $form->input("cep", array("type" => "text", "label" => "CEP","class" => "FormMeioBloco", "alt" => "cep", "value" => $dadosUsuario["cep"]));
        echo $form->input("username", array("type" => "text", "label" => "E-mail", "class" => "Form2Blocos", "value" => $dadosUsuario["username"]));
        echo $form->input("tel", array("type" => "text", "label" => "Telefone", "class" => "Form1Bloco", "div" => "ladoalado", "alt" => "telefone", "value" => $dadosUsuario["tel"]));
        echo $form->input("cel", array("type" => "text", "label" => "Celular", "class" => "Form1Bloco", "alt" => "telefone", "value" => $dadosUsuario["cel"]));
        echo $form->input("tel_recado", array("type" => "text", "label" => "Telefone de Recado", "class" => "Form1Bloco", "alt" => "telefone", "value" => $dadosUsuario["tel_recado"]));
        echo $form->input("sexo", array("type" => "select", "options" => array("Selecione...","Masculino","Feminino"), "label" => "Sexo", "class" => "Form1Bloco", "value" => $dadosUsuario["sexo"]));
        echo $form->input("dt_nascimento", array("type" => "text", "label" => "Data de Nascimento", "class" => "Form1Bloco", "div" => "ladoalado", "alt" => "date", "value" => $date->format("d-m-Y", $dadosUsuario["dt_nascimento"])));
        $optionsEstadoCivil = array(0 => "Selecione...", 1 => "Solteiro", 2 => "Casado", 3 => "Separado", 4 => "Divorciado", 5 => "Viúvo");
        echo $form->input("estado_civil", array("type" => "select", "options" => $optionsEstadoCivil, "label" => "Estado Civil", "class" => "Form1Bloco", "value" => $dadosUsuario["estado_civil"]));
        echo $form->input("cpf", array("label" => "CPF","alt"=>"cpf", "div"=>"ladoalado", "class" => "Form1Bloco", "value" => $dadosUsuario["cpf"]));
        echo $form->input("rg", array("label" => "RG", "class" => "Form1Bloco", "value" => $dadosUsuario["rg"]));
        ?>
        </div>
        <div style="width:130px; float:right; border: 1px #DDDDDD solid;">
            <label for="foto">Foto</label>
            <?php
                $foto = $geral->getPhoto($dadosUsuario["foto"]["file"]);
                echo $html->image($foto["url"], array("width" => "130", "bd" => $foto["bd"],"id"=>"foto"), true);
            ?>
        </div>
        <br clear="all"/>
    </div>
    <div id="dadosProfissionais">
        <?php
        
        $optionsGrau = array(0 => "Selecione...", "Ensino Fundamental", "Ensino Médio", "Técnico", "Sup. Cursando", "Sup. Incompleto", "Sup. Completo", "Pós Graduação", "Mestrado", "Doutorado");
        echo $form->input("matricula", array("type" => "text", "label" => "Mátricula", "class" => "Form1Bloco","div"=>"ladoalado", "value" => $dadosUsuario["matricula"]));
        echo $form->input("grau_instrucao", array("type" => "select", "options" => $optionsGrau, "label" => "Grau de Instrução", "class" => "Form1Bloco", "value" => $dadosUsuario["grau_instrucao"]));
        echo $form->input("grupoEmpresa_id",array("type"=>"select","options"=> $grupoEmpresa,"label"=>"Grupo de Empresa:","div"=>"ladoalado","class"=>"Form1Bloco","value"=>$dadosUsuario["grupoEmpresa_id"]));
        echo "<div id='carregaEmpresa'> </div>";
        echo $form->input("rh_setor_id", array("type" => "select", "label" => "Departamento", "options" => $perfis, "class" => "Form1Bloco","div"=>"ladoalado", "value" => $dadosUsuario["rh_setor_id"]));
        echo $form->input("cargo", array("type" => "text", "label" => "Cargo", "class" => "Form1Bloco", "value" => $dadosUsuario["cargo"]));
        echo $form->input("interventor",array("type"=>"select","options"=>$bool,"class" => "FormMeioBloco","value"=>$dadosUsuario["interventor"],"label"=>"I. Fiscal"));
        echo $form->input("gerente_id", array("type" => "select", "label" => "Gerente", "options" => $gerentes, "class" => "Form2Blocos", "value" => $dadosUsuario["gerente_id"]));
        //echo $form->input("cliente_id", array("type" => "select", "label" => "Cliente", "options" => $clientes, "class" => "Form2Blocos", "value" => $dadosUsuario["cliente_id"]));
        echo $form->input("salario", array("type" => "text", "alt" => "moeda", "label" => "Salário", "class" => "Form1Bloco", "value" => $dadosUsuario["salario"]));
        echo $form->input("dt_admissao", array("type" => "text", "label" => "Data de Admissão", "class" => "Form1Bloco", "alt" => "date", "div" => "ladoalado", "value" => $date->format("d-m-Y", $dadosUsuario["dt_admissao"])));
        echo $form->input("dt_desligamento", array("type" => "text", "label" => "Data de Desligamento", "class" => "Form1Bloco", "alt" => "date", "value" => $date->format("d-m-Y", $dadosUsuario["dt_desligamento"])));
        echo $form->input("observacao", array("type" => "textarea", "rows" => "5", "class" => "Form2Blocos", "label" => "Observação", "value" => $dadosUsuario["observacao"]));
        ?>
    </div>
    <div id="dadosDocumentos">
        <?php
        $idF = (int) $dadosUsuario["id"];
        ?>
        <a href="javascript:popIn('wdwCadDocumentos','/rh/cadDocumento/<?php echo $idF ?>/cad');" class="botao">*Novo</a>
        <div id="wdwCadDocumentos">

        </div>
        <br><br>
        <div id="gridDocumentos">

        </div>
    </div>
    <div id="dadosDependentes">
        <a href="javascript:popIn('cadDependente','/rh/cadDependente/<?php echo $idF ?>/cad');" class="botao">*Novo</a>
                       
        <div id="cadDependente"></div>
        <div id="gridDependente"></div>
    </div>
    <div id="dadosBancarios">
    <?php
        echo $form->input("financeiro_bancos_id",array("class"=>"Form2Blocos","label"=>"Banco","type"=>"select","options"=>$bancos,"value"=>$dadosUsuario["financeiro_bancos_id"]));
        echo $form->input("tipoConta",array("class"=>"Form2Blocos","label"=>"Tipo de Conta","options"=>array("Selecione...","Conta Poupança","Conta Corrente","Conta Salário"),"type"=>"select","value"=>$dadosUsuario["tipoConta"]));
        echo $form->input("agenciaPagamento",array("class"=>"Form1Bloco","label"=>"Agência","div"=>"ladoalado","value"=>$dadosUsuario["agenciaPagamento"]));
        echo $form->input("contaPagamento",array("class"=>"Form1Bloco","label"=>"Conta","value"=>$dadosUsuario["contaPagamento"]));        
    ?>
    </div>
</div>
<?php
        echo "<center>";
        echo $form->close();
        if($loggedUser["permissao"]==1 && $dadosUsuario["id"]>0 && $dadosUsuario["password"]!=""){
            echo $html->link("Resetar Senha","javascript:deletar('/rh/resetSenha/".$dadosUsuario["id"]."');",array("class"=>"botao"));
        }
        echo "</center>";
?>