<?php
foreach($compromissos as $compromisso){
    $listaCal[$compromisso["dia"]] = $compromisso["qtd"];
}
$output = '';
if ($month == '' && $year == '') {
    $time = time();
    $month = date('n', $time);
    $year = date('Y', $time);
}

$date = getdate(mktime(0, 0, 0, $month, 1, $year));
$today = getdate();
$hours = $today['hours'];
$mins = $today['minutes'];
$secs = $today['seconds'];

if (strlen($hours) < 2)
    $hours = "0" . $hours;
if (strlen($mins) < 2)
    $mins = "0" . $mins;
if (strlen($secs) < 2)
    $secs = "0" . $secs;
$meses = array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
$days = date("t", mktime(0, 0, 0, $month, 1, $year));
$start = $date['wday'] + 1;
$name = $meses[(date("m")-1)];
$year2 = $date['year'];
$offset = $days + $start - 1;

if ($month == 12) {
    $next = 1;
    $nexty = $year + 1;
} else {
    $next = $month + 1;
    $nexty = $year;
}

if ($month == 1) {
    $prev = 12;
    $prevy = $year - 1;
} else {
    $prev = $month - 1;
    $prevy = $year;
}

if ($offset <= 28)
    $weeks = 28;
elseif ($offset > 35)
    $weeks = 42;
else
    $weeks = 35;

$output .= "
<table class='cal' cellspacing='1'>
<tr>
	<td colspan='7'>
		<table class='calhead'>
		<tr>
			<td align='right'>
				<div style='float:left;'>$name</div><div style='float:right;'>$year2</div>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr class='dayhead'>
	<td>Dom</td>
	<td>Seg</td>
	<td>Ter</td>
	<td>Qua</td>
	<td>Qui</td>
	<td>Sex</td>
	<td>Sab</td>
</tr>";

$col = 1;
$cur = 1;
$next = 0;

for ($i = 1; $i <= $weeks; $i++) {
    if ($next == 3)
        $next = 0;
    if ($col == 1)
        $output.="<tr class='dayrow'>";

    $output.="<td valign='top' ";
    if ($cur == date("d"))
        $output .= " class='dayover'>";
    else
    $output.="onMouseOver=\"this.className='dayover'\" onMouseOut=\"this.className='dayout'\">";

    if ($i <= ($days + ($start - 1)) && $i >= $start) {
        $output.="<div class='day'";
        if ($cur == date("d"))
            $output.=" style='color:#06F;'";
        $output .="><b>$cur</b></div><br clear='all' /><div class='calEvents'>{$listaCal[$cur]}</div></td>";

        $cur++;
        $col++;
    } else {
        $output.="&nbsp;</td>";
        $col++;
    }

    if ($col == 8) {
        $output.="</tr>";
        $col = 1;
    }
}

$output.="</table>";

echo $output;
?>