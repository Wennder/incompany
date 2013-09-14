<script>
$().ready(function() {
    $("#FrmCadSenha").validate({
		rules: {
                    password: {
				required: true,
				minlength: 6
			},
			password2: {
				required: true,
				minlength: 6,
				equalTo: "#FormPassword"
			},
			username: {
				required: true,
				email: true
			}
                },
                messages:{
                    username: {
				required: "Digite um email",
				email: "O Email digitado não é válido"
			},
			password: {
				required: "Digite uma senha",
				minlength: "Sua senha deve ter no mínimo 6 caracteres"
			},
			password2: {
				required: "Confirme sua senha",
				minlength: "Sua senha deve ter no mínimo 6 caracteres",
				equalTo: "Senhas não conferem"
			}
                }
                });
});
</script>
<div class="content_conteudo">
<?php
echo $form->create("",array("id"=>"FrmCadSenha"));
echo $form->input("username",array("label"=>"Email","class"=>"Form1Bloco"));
echo $form->input("password",array("label"=>"Senha","type"=>"password","class"=>"Form1Bloco"));
echo $form->input("password2",array("label"=>"Confirme a Senha","type"=>"password","class"=>"Form1Bloco"));
echo "<br/>";
echo $form->close("Salvar");
?>
</div>