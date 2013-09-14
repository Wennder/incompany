<?php
    $this->pageTitle = "RH :: Pré Cadastro de Funcionário"
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
                    required:"Digite seu E-mail."
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
        <?php 
        	echo $html->link("","javascript:saveForm();",array("class"=>"save","style"=>"float:right; height:25px;"));
        ?>
    </ul>
    <div id="dadosPessoais">
        <?php
        echo $form->input("id", array("type" => "hidden", "value" => $dadosUsuario["id"]));
        echo $form->input("nome", array("type" => "text", "label" => "Nome Completo", "class" => "Form2Blocos", "value" => $dadosUsuario["nome"]));
        echo $form->input("endereco", array("type" => "text", "label" => "Endereço", "class" => "Form2Blocos", "value" => $dadosUsuario["endereco"]));
        echo $form->input("cidade", array("type" => "text", "label" => "Cidade", "class" => "Form1Bloco", "div" => "ladoalado", "value" => $dadosUsuario["cidade"]));
        $estados = array("Selecione...", "AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE", "TO");
        echo $form->input("estado", array("type" => "select", "options" => $estados, "label" => "Estado", "class" => "FormMeioBloco", "div" => "ladoalado", "value" => $dadosUsuario["estado"]));
        echo $form->input("cep", array("type" => "text", "label" => "CEP", "class" => "FormMeioBloco", "alt" => "cep", "value" => $dadosUsuario["cep"]));
        echo $form->input("username", array("type" => "text", "label" => "E-mail", "class" => "Form2Blocos", "value" => $dadosUsuario["username"]));
        echo $form->input("tel", array("type" => "text", "label" => "Telefone", "class" => "Form1Bloco", "div" => "ladoalado", "alt" => "telefone", "value" => $dadosUsuario["tel"]));
        echo $form->input("cel", array("type" => "text", "label" => "Celular", "class" => "Form1Bloco", "alt" => "telefone", "value" => $dadosUsuario["cel"]));
        echo $form->input("tel_recado", array("type" => "text", "label" => "Telefone de Recado", "class" => "Form1Bloco", "alt" => "telefone", "value" => $dadosUsuario["tel_recado"]));
        echo $form->input("sexo", array("type" => "select", "options" => array("Selecione...","Masculino","Feminino"), "label" => "Sexo", "class" => "Form1Bloco", "value" => $dadosUsuario["sexo"]));
        echo $form->input("dt_nascimento", array("type" => "text", "label" => "Data de Nascimento", "class" => "Form1Bloco", "div" => "ladoalado", "alt" => "date", "value" => $date->format("d-m-Y", $dadosUsuario["dt_nascimento"])));
        $optionsEstadoCivil = array(0 => "Selecione...", 1 => "Solteiro", 2 => "Casado", 3 => "Separado", 4 => "Divorciado", 5 => "Viúvo");
        echo $form->input("estado_civil", array("type" => "select", "options" => $optionsEstadoCivil, "label" => "Estado Civil", "class" => "Form1Bloco", "value" => $dadosUsuario["estado_civil"]));
        echo $form->input("cpf", array("label" => "CPF","alt"=>"cpf" ,"div"=>"ladoalado", "class" => "Form1Bloco", "value" => $dadosUsuario["cpf"]));
        echo $form->input("rg", array("label" => "RG", "class" => "Form1Bloco", "value" => $dadosUsuario["rg"]));
        ?>
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
        echo $form->input("observacao", array("type" => "textarea", "rows" => "5", "class" => "Form2Blocos", "label" => "Observação", "value" => $dadosUsuario["observacao"]));
        ?>
    </div>
</div>
<?php
        echo "<center>";
        echo $form->close();
        echo "</center>";
?>