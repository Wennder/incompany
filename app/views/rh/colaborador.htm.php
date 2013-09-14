<script>
    $(function(){
      $("input:text").setMask();
      $("input[alt=date]").datepicker({"dateFormat":"dd-mm-yy"});
    });
</script>
<?php
echo $form->create("",array("class"=>"formee"));
echo $html->tag("h3","Dados Pessoais",array("class"=>"title"));
echo $html->tag("br","",array("clear"=>"all"),true);
echo $form->input("nome",array("label"=>"Nome Completo","div"=>"grid-12-12","value"=>$dadosForm["nome"]));
echo $form->input("cep",array("label"=>"CEP","alt"=>"cep","div"=>"grid-2-12","value"=>$dadosForm["cep"]));
echo $form->input("endereco",array("label"=>"Endereço","div"=>"grid-10-12","value"=>$dadosForm["endereco"]));
echo $form->input("nro",array("label"=>"Número","div"=>"grid-2-12","value"=>$dadosForm["nro"]));
echo $form->input("complemento",array ("label"=>"Complemento","div"=>"grid-6-12","value"=>$dadosForm["complemento"]));
echo $form->input("bairro",array ("label"=>"Bairro","div"=>"grid-4-12","value"=>$dadosForm["bairro"]));
echo $form->input("estado_id",array("type"=>"select","options"=>$optionsEstados,"label"=>"Estado","div"=>"grid-2-12","value"=>$dadosForm));
echo $form->input("municipio_id",array("type"=>"select","label"=>"Cidade","div"=>"grid-10-12","value"=>$dadosForm));
echo $form->input("emailPessoal",array("label"=>"Email Pessoal","div"=>"grid-6-12","value"=>$dadosForm["username"]));
echo $form->input("username",array("label"=>"Email Corporativo ","div"=>"grid-6-12","value"=>$dadosForm["username"]));
echo $form->input("telefone",array("label"=>"Telefone","alt"=>"telefone","div"=>"grid-4-12","value"=>$dadosForm["telefone"]));
echo $form->input("cel",array("label"=>"Celular","alt"=>"telefone","div"=>"grid-4-12","value"=>$dadosForm["cel"]));
echo $form->input("telRecado",array("label"=>"Telefone de Recado","alt"=>"telefone","div"=>"grid-4-12","value"=>$dadosForm["telRecado"]));
echo $form->input("dtNascimento",array("label"=>"Data de Nascimento","alt"=>"date","div"=>"grid-4-12","value"=>$dadosForm["dtNascimento"]));
echo $form->input("rg",array("label"=>"RG","div"=>"grid-4-12","value"=>$dadosForm["rg"]));
echo $form->input("cpf",array("label"=>"CPF","alt"=>"cpf","div"=>"grid-4-12","value"=>$dadosForm["cpf"]));
echo $form->input("sexo",array("type"=>"select","options"=>array("Selecione","Masculino","Feminino"),"div"=>"grid-4-12","value"=>$dadosForm["sexo"]));
$optionsEstadoCivil = array(0 => "Selecione...", 1 => "Solteiro", 2 => "Casado", 3 => "Separado", 4 => "Divorciado", 5 => "Viúvo");
echo $form->input("estadoCivil",array("label"=>"Estado Civil", "type"=>"select","options"=>$optionsEstadoCivil,"div"=>"grid-4-12","value"=>$dadosForm["estadoCivil"]));
echo $form->input("grauInstrucao",array("type"=>"select","options"=>array(),"label"=>"Grau de Instrução","div"=>"grid-4-12","value"=>$dadosForm["grauInstrucao"]));
echo $html->tag("br","",array("clear"=>"all"),true);
echo $html->tag("h3","Dados Profissionais",array("class"=>"title"));
echo $html->tag("br","",array("clear"=>"all"),true);
echo $form->input("matricula",array("label"=>"Matrícula","div"=>"grid-2-12","value"=>$dadosForm["matricula"]));
echo $form->input("grupo_id",array("type"=>"select","options"=>array(),"label"=>"Grupo de Empresa","div"=>"grid-3-12","value"=>$dadosForm["grupo_id"]));
echo $form->input("empresa_id",array("type"=>"select","options"=>array(),"label"=>"Empresa","div"=>"grid-4-12","value"=>$dadosForm));
echo $form->input("departamento_id",array("type"=>"select","options"=>array(),"label"=>"Departamento","div"=>"grid-3-12","value"=>$dadosForm["departamento_id"]));
echo $form->input("gerente",array("type"=>"select","options"=>$bool,"div"=>"grid-2-12","label"=>"Gerenciamento","value"=>$dadosForm["gerente"]));
echo $form->input("cargo",array("label"=>"Cargo","div"=>"grid-6-12","value"=>$dadosForm["cargo"]));
echo $form->input("funcionario_id",array("type"=>"select","options"=>array(),"label"=>"Gerente","div"=>"grid-4-12","value"=>$dadosForm));
echo $form->input("salario",array("label"=>"Salário","div"=>"grid-4-12","alt"=>"moeda","value"=>$dadosForm["salario"]));
echo $form->input("dtAdmissao",array("label"=>"Admissão","div"=>"grid-2-12","alt"=>"date","value"=>$dadosForm["dtAdmissao"]));
echo $form->input("dtDesligamento",array("label"=>"Desligamento","div"=>"grid-2-12","alt"=>"date","value"=>$dadosForm["dtDesligamento"]));
echo $html->tag("br","",array("clear"=>"all"),true);
echo $html->tag("h3","Dados Bancários",array("class"=>"title"));
echo $html->tag("br","",array("clear"=>"all"),true);
echo $form->input ("financeiro_banco_id",array("type"=>"select","options"=>$optBancos ,"label"=>"Banco", "div"=>"grid-6-12","value"=>$dadosForm["financeiro_bancos_id"]));
echo $form->input("tipoConta",array("class"=>"Form2Blocos","label"=>"Tipo de Conta","div"=>"grid-6-12", "options"=>array("Selecione...","Conta Poupança","Conta Corrente","Conta Salário"),"type"=>"select","value"=>$dadosForm["tipoConta"]));
echo $form->input("agenciaPagamento",array ("label"=>"Agência","div"=>"grid-6-12","value"=>$dadosForm["agenciaPagamento"]));
echo $form->input("contaPagamento",array("div"=>"grid-6-12" ,"label"=>"Conta","value"=>$dadosForm["contaPagamento"]));        


?>