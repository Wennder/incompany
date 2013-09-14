<!-- Start PureCSSMenu.com MENU -->
<ul class="pureCssMenu pureCssMenum">
    <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:void(0);"><span><img alt="Fabricantes" src="/images/iconesMenu/factory.png" /></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
        <ul class="pureCssMenum">
            <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:AbreJanela('/importacoes/fornecedoresProcesso/cadastrar/<?php echo $op ?>',440,275,'Adicionar Fabricantes',0,true);">+ Fabricante</a></li>
        </ul>
        <!--[if lte IE 6]></td></tr></table></a><![endif]--></li>

<li class="pureCssMenui"><a class="pureCssMenui" href="javascript:void(0);"><span><img src="/images/iconesMenu/folder.png" /></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
        <ul class="pureCssMenum">
            <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:AbreJanela('/importacoes/uploadDocumento/cadastrar/<?php echo $op ?>',440,275,'Documentos - Anexos',0,true);">Anexar Doc.</a></li>
            <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:AbreJanela('/importacoes/conteineres/cadastrar/<?php echo $op ?>',440,275,'Adicionar Contêiner',0,true);">Adicionar Contêiner</a></li>
            <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:AbreJanela('/importacoes/conteineres/importar/<?php echo $op ?>',500,600,'Importar Contêiner',0,true);">Importar Contêiner</a></li>

        </ul>
        <!--[if lte IE 6]></td></tr></table></a><![endif]--></li>

<li class="pureCssMenui"><a class="pureCssMenui" href="javascript:void(0);"><span><img src="/images/iconesMenu/cart.png" /></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
        <ul class="pureCssMenum">
            <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:AbreJanela('/importacoes/itensProcesso/cadastrar/<?php echo $op ?>',440,275,'Adicionar Produtos à Importação',0,true);">+ Produto</a></li>

        </ul>
        <!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
    <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:void(0);"><span><img src="/images/iconesMenu/money_add.png" /></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
        <ul class="pureCssMenum">
            <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:void(0);"><span>Despesas</span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul class="pureCssMenum">
                    <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:AbreJanela('/importacoes/despesasNacionalizacao/cadastrar/<?php echo $op ?>', 500, 600, 'Despesas de Nacionalização', 0, true);">Itens</a></li>
                    <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:AbreJanela('/importacoes/despesasNacionalizacao/setTerminal/<?php echo $op ?>',440,210,'Alteração de Terminal',0,true);">Terminal</a></li>
                </ul>
                <!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
            <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:void(0);"><span>Câmbio</span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul class="pureCssMenum">
                    <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:AbreJanela('/importacoes/contratosCambio/cadastrar/<?php echo $op ?>',440,275,'Contratots de Câmbio: Inserir',0,true);">+ Contrato</a></li>
                </ul>
                <!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
            <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:void(0);"><span>Fechamento</span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
                <ul class="pureCssMenum">
                    <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:AbreJanela('/importacoes/custosFechamento/cadastrar/<?php echo $op ?>/1',440,160,'Fechamento : Adicionar Crédito',0,true);">+ Crédito</a></li>
                    <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:AbreJanela('/importacoes/custosFechamento/cadastrar/<?php echo $op ?>/0',440,160,'Fechamento : Adicionar Débito',0,true);">+ Débito</a></li>
                    <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:confirmaAjax('Deseja Realmente Fazer o Fechamento dos Impostos? \n','/importacoes/custosFechamento/impostos/<?php echo $op; ?>'); loadDiv('#contCustosFechamento','/importacoes/custosFechamento/grid/<?php echo $op ?>');">Impostos</a></li>
                    <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:confirmaAjax('Deseja Realmente Fechar as Despesas Aduaneiras? \n','/importacoes/custosFechamento/despesas/<?php echo $op; ?>'); loadDiv('#contCustosFechamento','/importacoes/custosFechamento/grid/<?php echo $op ?>');">Despesas</a></li>
                </ul>
                <!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
        </ul>
        <!--[if lte IE 6]></td></tr></table></a><![endif]--></li>

<li class="pureCssMenui"><a class="pureCssMenui" href="javascript:void(0);"><span><img alt="Relatórios" src="/images/iconesMenu/printer.png" /></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
        <ul class="pureCssMenum">
            <li class="pureCssMenui"><a class="pureCssMenui" href="/relatorios/importacoes_planilha/<?php echo $op ?>" target="_blank">Visão Geral</a></li>
            <li class="pureCssMenui"><a class="pureCssMenui" href="/relatorios/importacoes_fechamento/<?php echo $op ?>" target="_blank">Fechamento</a></li>
            <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:AbreJanela('/relatorios/importacoes_precovenda/filtro/<?php echo $op; ?>',420,210,'Imprimir Relatório: Formação de Preço de Venda',0,true);" target="_blank">Preço Venda</a></li>
        </ul>
        <!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
    <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:recalculaProcesso(<?php echo $op ?>);"><span><img alt="Recalcular" src="/images/iconesMenu/calculator_black.png" /></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]--><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
    <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:void(0);" id="salvaProcesso"><span><img alt="Salvar" src="/images/iconesMenu/disk.png" /></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]--><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
    <li class="pureCssMenui"><a class="pureCssMenui" href="javascript:confirma('Deseja Realmente Encerrar este Processo?','/importacoes/fecharProcesso/<?php echo $op; ?>');" id="fechaProcesso"><span><img alt="Salvar" src="/images/iconesMenu/stop.png" /></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]--><!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
</ul>
<div id="ultimoSave" style="margin-top: 10px;margin-right: 10px; color: #000000;float:right; font-weight: bold; font-size: 16px;"></div>

<!-- End PureCSSMenu.com MENU -->



