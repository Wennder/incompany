<div class="fontPrintficha">
<table border="0" width="100%">
        <tr>
            <td colspan="2"><center><h2><?php echo $dadoFuncionario["nome"]; ?></h2></center>
             <br/>
                <br/>
</td>
        </tr>
   
        <tr>
            <td valign="top" width="200">
                <?php
                $foto = $assistec->getPhoto($dadoFuncionario["foto"]["file"]);
                echo $html->image($foto["url"], array("width" => "200", "bd" => $foto["bd"], "style" => "padding-right:15px;"), true);
                ?>
            </td>
            
            <td valign="top">
                
                <?php
              // pr($dadoFuncionario);
                ?> 
                <fieldset>
                    <legend><h2>Dados básicos</h2></legend>
                    
                <table border="0">
                    <tr>
                           <td colspan="3"><b></b></td>
                        </tr>
                        <tr>
                           <td colspan="3"><b>Nome:</b><br/><?php echo $dadoFuncionario["nome"];?></td>
                        </tr>
                        <tr>
                           <td colspan="3"><b>Endereço:</b><br/><?php echo $dadoFuncionario["endereco"];?></td> 
                            
                        </tr>
                        <tr>
                             <td colspan="0"><b>Cidade:</b><br/><?php echo $dadoFuncionario["cidade"];?></td> 
                              <td colspan="0"><b>UF:</b><br/><?php echo $optionsEstados[$dadoFuncionario["estado"]];?></td> 
                               <td colspan="0"><b>CEP:</b><br/><?php echo $dadoFuncionario["cep"];?></td> 
                        </tr>
                        <tr>
                            <?php $sexo = array("Não preenchido","Masculino","Feminino") ?>
                            <td colspan="3"><b>Sexo:</b><br/><?php echo $sexo[$dadoFuncionario["sexo"]];?></td> 
                        </tr>
                        <tr>
                           <td colspan=""><b>Data de Nascimento:</b><br/><?php echo $date->format("d/m/Y",$dadoFuncionario["dt_nascimento"]);?></td>
                           <?php $optionsEstadoCivil = array(0 => "Selecione...", 1 => "Solteiro", 2 => "Casado", 3 => "Separado", 4 => "Divorciado", 5 => "Viúvo");?>
                            <td colspan=""><b>Estado Civil:</b><br/><?php echo $optionsEstadoCivil[$dadoFuncionario["estado_civil"]];?></td> 
                        </tr>
                        <tr>
                            <td colspan=""><b>CPF:</b><br/><?php echo $dadoFuncionario["cpf"];?></td>
                            <td colspan=""><b>RG:</b><br/><?php echo $dadoFuncionario["rg"];?></td> 
                        </tr>
                        </table>
                </fieldset>
                <br/>
                <br/>
                
                 <fieldset>
                     <legend><b><h2>Dados Profissionais</h2></b></legend>
                <table border="0">
                   
                       <tr>
                           <td colspan=""><b>Matricula:</b><br/><?php echo $dadoFuncionario["matricula"];?></td>
                           <?php $optionsGrau = array(0 => "Selecione...", "Ensino Fundamental", "Ensino Médio", "Técnico", "Sup. Cursando", "Sup. Incompleto", "Sup. Completo", "Pós Graduação", "Mestrado", "Doutorado");?>
                            <td colspan=""><b>Grau de Instrução:</b><br/><?php echo $optionsGrau[$dadoFuncionario["grau_instrucao"]];?></td> 
                        </tr>
                        <tr>
                            <td colspan=""><b>Grupo de Empresa:</b><br/><?php echo $dadoFuncionario["grupo_empresa"]["nome"];?></td>
                            <td colspan=""><b>Empresa:</b><br/><?php echo$dadoFuncionario["empresa"]["nomeFantasia"];?></td> 
                        </tr>
                        <tr>
                            <td colspan=""><b>Departamento:</b><br/><?php echo $dadoFuncionario["rh_setor"]["nome"];?></td>
                            <td colspan=""><b>Cargo:</b><br/><?php echo $dadoFuncionario["cargo"];?></td> 
                        </tr>
                        <tr>
                          <td colspan=""><b>Gerente:</b><br/><?php echo $dadoFuncionario["gerente_funcionario"]["nome"];?></td>
                        </tr>
                        <tr>
                           <td colspan=""><b>Data de Admissão:</b><br/><?php echo $date->format("d/m/Y",$dadoFuncionario["dt_admissao"]);?></td>
                            <td colspan=""><b>Data de Desligamento:</b><br/><?php echo $date->format("d/m/Y",$dadoFuncionario["dt_desligamento"]);?></td> 
                        </tr>
                        <tr>
                            <td colspan="2"><b>Observação:</b><br/><?php echo $dadoFuncionario["observacao"];?></td>
                        </tr>
                        
                       </table>
                     </fieldset>
                <br/>
                <br/>
                
                <fieldset>
                    <legend><b><h2>Dados Bancários</h2></b></legend>
                <table border="0">
                    
                          <tr>
                            <td colspan="2"><b>Banco:</b><br/><?php echo $dadoFuncionario["financeiro_bancos"]["nome"];?></td>
                        </tr>
                        <tr>
                            <?php $tipoCont = array("0"=>"Selecione...","1"=>"Conta Poupança","2"=>"Conta Corrente","3"=>"Conta Salário");?>
                            <td colspan="2"><b>Tipo de Conta:</b><br/><?php echo $tipoCont[$dadoFuncionario["tipoConta"]];?></td>
                        </tr>
                        <tr>
                            <td colspan=""><b>Agência:</b><br/><?php echo $dadoFuncionario["agenciaPagamento"];?></td>
                             <td colspan=""><b>Conta:</b><br/><?php echo $dadoFuncionario["contaPagamento"];?></td>
                        </tr>
                      </table>
                    </fieldset>

            </td>
        </tr>
</table>
</div>